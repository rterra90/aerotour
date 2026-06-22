<?php
class Aerotour_Helper
{

  /**
   * Consolida todos os dados da excursão em um array limpo
   */
  public static function get_formatted_excursion_data($product_id)
  {
    global $wpdb;
    $product = wc_get_product($product_id);
    if (!$product) return null;

    $variacoes = $product->get_available_variations();

    // agrupa os ids de embarque globais e embarques por variação
    $ids_embarques_data = array();
    $embarques_por_variacao = array();

    foreach ($variacoes as $variacao) {
      $var_id = $variacao['variation_id'];
      $variation_embarques = json_decode(get_post_meta($var_id, '_embarques_config', true), true);

      array_push($embarques_por_variacao, array(
        'variation_id' => $var_id,
        'variation_dia' => $variacao['attributes']['attribute_dia'],
        'variation_embarques' => $variation_embarques
      ));

      $ids_embarques_var = array_column($variation_embarques, 'embarque_id');
      $ids_embarques_data = array_merge($ids_embarques_data, $ids_embarques_var);
    }
    
    // busca os detalhes dos embarques globais
    if (!empty($ids_embarques_data)) {
      $ids_str_data = implode(',', array_map('intval', array_unique($ids_embarques_data)));
      $embarques_detalhes = $wpdb->get_results("SELECT * FROM aer_embarques WHERE id IN ($ids_str_data)");
    }


    // Lógica de Embarques (Originalmente no template [cite: 3, 6])
    $locais_embarque = json_decode(get_post_meta($product_id, 'embarques', true), true);
    $ids_embarques = $locais_embarque ? array_column($locais_embarque, 'embarqueId') : [];

    $embarques_db = [];
    if (!empty($ids_embarques)) {
      $ids_str = implode(',', array_map('intval', $ids_embarques));
      $embarques_db = $wpdb->get_results("SELECT * FROM aer_embarques WHERE id IN ($ids_str)");
    }

    // Mapeia nomes e endereços (Originalmente no template [cite: 7, 8])
    if ($locais_embarque && $embarques_db) {
      foreach ($locais_embarque as &$emb_exc) {
        foreach ($embarques_db as $db) {
          if ((int)$db->id === (int)$emb_exc['embarqueId']) {
            $emb_exc['nome'] = $db->nome;
            $emb_exc['endereco'] = $db->endereco;
            $emb_exc['obs'] = $db->obs;
            $emb_exc['link_mapa'] = $db->link_mapa;
          }
        }
      }
    }
    $variacoes = $product->get_available_variations();  

    //Define as propriedades 'encerrar_vendas' e 'dia' em cada variação
    foreach ($variacoes as $i => $var) {
      $variacoes[$i]['encerrar_vendas'] = get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes' ? true : false;
      $att_dia = $var['attributes']['attribute_dia'];
      $variacoes[$i]['dia'] = $att_dia;
    }

    $datas = self::get_datas_da_excursao($product);
    return [
      'id'            => $product_id,
      'nome'          => $product->get_name(),
      'img'           => wp_get_attachment_image_src($product->get_image_id(), 'full')[0] ?? null,
      'variacoes'     => $variacoes,
      'datas'         => $datas,
      'local'         => get_post_meta($product_id, 'local_evento', true),
      'chegada'       => get_post_meta($product_id, 'previsao_chegada', true),
      'ingressos'     => [
        'url'   => get_post_meta($product_id, 'ingressos_link', true),
        'label' => get_post_meta($product_id, 'ingressos_label', true)
      ],
      'embarques'     => $locais_embarque,
      'show_vendidos' => get_post_meta($product_id, 'show_vendidos', true) === 'yes',
      'embarques_detalhes' => $embarques_detalhes,
      'embarques_por_variacao' => $embarques_por_variacao
    ];
  }

  /**
   * Obtém array de datas da excursão no formato ['dd/mm/aaaa']
   */
  public static function get_datas_da_excursao($product)
  {
    $variacoes = $product->get_available_variations();
    $datas = [];
    foreach ($variacoes as $var) {
      $var['encerrar_vendas'] = get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes';
      $var['dia'] = $var['attributes']['attribute_dia'] ?? '';
      if ($var['dia']) $datas[] = $var['dia'];
    }

    // Ordenação de Datas
    usort($datas, function ($a, $b) {
      return DateTime::createFromFormat('d/m/Y', $a) <=> DateTime::createFromFormat('d/m/Y', $b);
    });

    return $datas;
  }

  /**
   * Calcula o total de reservas (Originalmente no template [cite: 51, 52])
   */
  public static function get_reservas_count($product_id, $variacoes)
  {
    global $wpdb;
    $variacao_ids = array_column($variacoes, 'variation_id');
    if (empty($variacao_ids)) return 0;

    $ids_str = implode(',', $variacao_ids);
    $count = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}reservas WHERE status != 'cancel' AND variation_id IN ($ids_str)");

    $incremento = get_post_meta($product_id, 'vendidos_inc', true);
    return is_numeric($incremento) ? $count + (int)$incremento : $count;
  }

  public static function is_excursion_closed($product_id)
  {
    $ultima_data = get_post_meta($product_id, 'data_limite_excursao', true);
    $is_encerrada = date('Ymd') > $ultima_data;
    return $is_encerrada;
  }

  public static function get_excursion_schema($product_id)
  {
    $product = wc_get_product($product_id);
    if (!$product) return null;

    $excursao = self::get_formatted_excursion_data($product_id);
    $is_encerrada = self::is_excursion_closed($product_id);

    $datas = Aerotour_Helper::get_datas_da_excursao($product);

    $start_date_obj = DateTime::createFromFormat('d/m/Y', $datas[0]);
    $start_date = $start_date_obj->format('Y-m-d');

    $offers = [];
    foreach ($excursao['variacoes'] as $i => $var) {
      $is_instock = !$var['encerrar_vendas'] && $var['is_in_stock'];

      $offers[] = [
        "@type"         => "Offer",
        "name"          => "Excursão - Dia " . $datas[$i],
        "price"         => $var['display_price'],
        "priceCurrency" => "BRL",
        "availability"  => $is_instock ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
        "url"           => get_permalink($product_id),
        "seller" => [
          "@type" => "Organization",
          "name" => "Aerotour Excursões",
          "url" => "https://www.aerotour.com.br/"
        ]
      ];
    }

    return [
      "@context"    => "https://schema.org/",
      "@type"       => ['Product', 'Event'],
      "name"        => 'Excursão ' . $excursao['nome'],
      "image"       => [$excursao['img']],
      "description" => wp_strip_all_tags($product->get_short_description()),
      "sku"         => $product->get_sku(),
      "brand"       => [
        "@type" => "Brand",
        "name"  => "Aerotour Excursões"
      ],
      'startDate' => $start_date,
      'eventStatus' => $is_encerrada
        ? 'https://schema.org/EventMovedOnline'
        : 'https://schema.org/EventScheduled',
      "offers"      => $offers
    ];
  }
}


/**
 * Ajusta a Tag Canonical para produtos de excursões passadas
 */
add_filter('wpseo_canonical', 'ajustar_canonical_excursao_passada'); // Yoast SEO
add_filter('rank_math/frontend/canonical', 'ajustar_canonical_excursao_passada'); // Rank Math
add_filter('get_canonical_url', 'ajustar_canonical_excursao_passada', 10, 2); // WordPress Nativo

function ajustar_canonical_excursao_passada($canonical_url)
{
  if (! is_product()) return $canonical_url;

  $novo_evento_id = get_post_meta(get_the_ID(), 'more_recent_event_id', true);

  if ($novo_evento_id) {
    // Verifica a data limite do novo evento
    $data_limite = get_post_meta($novo_evento_id, 'data_limite_excursao', true);
    $hoje = date('Ymd');

    // Só altera o canonical se o novo evento ainda for futuro ou hoje
    if (! $data_limite || $data_limite >= $hoje) {
      return get_permalink($novo_evento_id);
    }
  }

  return $canonical_url;
}

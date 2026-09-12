<?php
function get_excursoes($args = []){
  $product_cat = $args['product_cat'] ?? '';
  $product_ids = $args['product_ids'] ?? [];

  $hoje = date('Ymd');
  $args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => 30,
    'tax_query' => $product_cat ? [
      [
        'taxonomy' => 'product_cat',
        'field' => 'slug',
        'terms' => $product_cat
      ]
    ] : [],
    'post__in' => $product_ids ? $product_ids : [],
    'meta_key' => 'data_limite_excursao',
    'orderby' => 'meta_value_num',
    'order' => 'ASC',
    'meta_query' => [
      [
        'key' => 'data_limite_excursao',
        'value' => $hoje,
        'compare' => '>=',
        'type' => 'NUMERIC'
      ]
    ]
  ];
  $query = new WP_Query($args); // Executa a consulta para obter as excursões com data limite maior ou igual a hoje
  $excursoes_ids = $query->posts; // Obtém os IDs dos produtos retornados pela consulta
  $excursoes = array_map('wc_get_product', $excursoes_ids); // Converte IDs em objetos de produto do WooCommerce
  return $excursoes;
}


function aer_proximas_excursoes($excursoes, $filter = null)
{
  if (empty($excursoes)) {
    return [];
  }

  
  $proximas_exc = [];
  $agora = time();

  foreach ($excursoes as $excursao) {
    $exc_id = $excursao->get_id();
    //obter a meta "data_inicio_excursao" para ordenar as excursões próximas e adicionar ao objeto da excursão
    $data_inicio_excursao = get_post_meta($exc_id, 'data_inicio_excursao', true);
    $excursao->data_inicio_excursao = $data_inicio_excursao;

    // Filtro de Destaque: aproveita o objeto já existente
    if ($filter === 'destaque') {
      // Usa o método nativo do WooCommerce para verificar se está em destaque
      if ($excursao->is_featured()) {
        $proximas_exc[] = $excursao;
      }

      continue;
    }

    // Filtro Em Breve: produtos sem embarques definidos
    if ($filter === 'em-breve') {
      if (get_post_meta($exc_id, 'exc_embarques', true) === '') {
        $proximas_exc[] = $excursao;
      }
      if (count($proximas_exc) >= 8) {
        break;
      } // Limite de performance
      continue;
    }

    // Caso padrão (Galeria ou nulo): apenas retorna o que já foi filtrado na home
    $proximas_exc[] = $excursao;
    if (count($proximas_exc) >= 8 && $filter !== 'galeria') {
      break;
    }
  }


  //ordena os produtos pela meta "data_inicio_excursao" após adicionar à lista, data mais antiga primeiro
  usort($proximas_exc, function ($a, $b) {
    $a_data = $a->data_inicio_excursao ?? get_post_meta($a->get_id(), 'data_inicio_excursao', true);
    $b_data = $b->data_inicio_excursao ?? get_post_meta($b->get_id(), 'data_inicio_excursao', true);
    return $a_data <=> $b_data;
  });

  return $proximas_exc;
}

function aer_excursoes_apos_data($excursoes, $data_ref)
{
  $excs = [];
  $final_excs = [];
  foreach ($excursoes as $excursao) {
    $exc_id = $excursao->get_id();
    $variacoes = $excursao->get_available_variations();
    $data_inicial = $variacoes[0]['attributes']['attribute_dia'];
    $data_inicial =
      count(explode('/', $data_inicial)) == 3
        ? $data_inicial
        : $data_inicial . '/' . date('Y');
    $data_inicial_std =
      explode('/', $data_inicial)[2] .
      '-' .
      explode('/', $data_inicial)[1] .
      '-' .
      explode('/', $data_inicial)[0];
    if (strtotime($data_inicial_std) > strtotime(date($data_ref))) {
      $excs[$exc_id] = strtotime($data_inicial_std);
    }
  }
  asort($excs);
  $i = 0;
  foreach ($excs as $key => $exc) {
    if ($i < 8) {
      array_push($final_excs, wc_get_products(['include' => [$key]])[0]);
    }
    $i++;
  }
  return $final_excs;
}
?>

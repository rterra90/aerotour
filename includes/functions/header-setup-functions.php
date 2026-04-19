<?php

/**
 * Aerotour: Funções de Lógica de Template e Busca de Dados
 */

/**
 * 1. SEO: Gera a meta description baseada no contexto da página
 */
function aer_get_seo_description()
{
  if (is_product()) {
    return get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
  } elseif (is_product_category()) {
    $cat_name = strtolower(get_queried_object()->name);
    return "Confira todas as nossas próximas excursões para $cat_name e faça sua reserva!";
  } elseif (is_archive()) {
    return 'Confira todas as nossas próximas excursões e faça sua reserva!';
  }

  return 'Excursões para shows e eventos é com a Aerotour! Saídas de Campinas, Indaiatuba, Sumaré, Hortolândia, Paulínia, Salto, Valinhos, Vinhedo e Jundiaí.';
}

/**
 * 2. HOME: Busca dados da excursão em destaque (Hero) com cache
 */
function aer_get_hero_data()
{
  delete_transient('aer_featured_trip');
  $featured_data = get_transient('aer_featured_trip');

  if (false === $featured_data) {
    $hoje = date('Ymd'); // Formato yyyymmdd igual ao seu meta_value
    $excursoes_hero = wc_get_products([
      'status'      => 'publish',
      'limit'       => 1,
      'featured'    => true,
      'meta_query'  => [
        [
          'key'     => 'data_limite_excursao',
          'value'   => date('Ymd'),
          'compare' => '>=',
          'type'    => 'NUMERIC'
        ]
      ],
      'orderby'     => 'meta_value_num',
      'meta_key'    => 'data_limite_excursao', // Necessário para o orderby saber qual meta usar
      'order'       => 'ASC',
    ]);

    $featured_data = ['bg' => '', 'focus' => ''];

    $opt_featured_data = [
      'bg_desktop' => '',
      'bg_mobile'  => '',
      'focus'      => ''
    ];

    if (!empty($excursoes_hero)) {
      $proxima_exc = $excursoes_hero[0];
      $id = $proxima_exc->get_id();
      $bg_id = get_post_meta($id, 'dest_img_1_id', true);
      $focus_id = get_post_meta($id, 'dest_img_2_id', true);

      // Busca os diferentes tamanhos da mesma imagem de fundo
      $bg_desktop_src = wp_get_attachment_image_src($bg_id, 'full');
      $bg_mobile_src  = wp_get_attachment_image_src($bg_id, 'hero_mobile'); // O tamanho que criamos

      // Fallback: se o hero_mobile não existir, usa o 'medium_large' do WP
      if (!$bg_mobile_src) {
        $bg_mobile_src = wp_get_attachment_image_src($bg_id, 'medium_large');
      }


      $bg_src = wp_get_attachment_image_src($bg_id, 'full');
      $focus_src = wp_get_attachment_image_src($focus_id, 'large');

      $featured_data = [
        'bg'    => $bg_src ? $bg_src[0] : '',
        'focus' => $focus_src ? $focus_src[0] : ''
      ];

      $opt_featured_data = [
        'bg_desktop' => $bg_desktop_src ? $bg_desktop_src[0] : '',
        'bg_mobile'  => $bg_mobile_src ? $bg_mobile_src[0] : '',
        'focus'      => $focus_src ? $focus_src[0] : ''
      ];
    }
    set_transient('aer_featured_trip', $featured_data, DAY_IN_SECONDS);
  }
  return $opt_featured_data;
}

/**
 * 3. CAMPANHAS: Busca campanhas ativas para a roleta com cache
 */
function aer_get_active_campaigns()
{
  global $wpdb;
  $campanhas_ativas = get_transient('aer_campanhas_ativas');

  if ($campanhas_ativas === false) {
    $todas_campanhas = $wpdb->get_results(
      $wpdb->prepare(
        'SELECT `id`,`nome_campanha`,`valido_de`, `valido_ate`, `status` from `aer_camp_premios`'
      )
    );

    $campanhas_ativas = array_values(
      array_filter($todas_campanhas, function ($_camp) {
        $inicio = strtotime($_camp->valido_de);
        $final = strtotime($_camp->valido_ate) + 86400; // Inclui o último dia
        $agora = time();
        return $agora >= $inicio && $agora <= $final;
      })
    );
    set_transient('aer_campanhas_ativas', $campanhas_ativas, HOUR_IN_SECONDS);
  }
  return $campanhas_ativas;
}

/**
 * 4. RASTREIO: Injeta scripts de marketing apenas para usuários não administradores
 */
function aer_inject_tracking_scripts()
{
  // Lista de IPs de localhost (IPv4 e IPv6)
  $whitelist = array('127.0.0.1', '::1');
  $localhost_url = $_SERVER['HTTP_HOST'] === 'localhost';
  $is_localhost = in_array($_SERVER['REMOTE_ADDR'], $whitelist) || $localhost_url;

  if (current_user_can('administrator')) {
    return;
  } ?>
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-F1239QYGYB"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', 'G-F1239QYGYB');
  </script>

  <script>
    ! function(f, b, e, v, n, t, s) {
      if (f.fbq) return;
      n = f.fbq = function() {
        n.callMethod ?
          n.callMethod.apply(n, arguments) : n.queue.push(arguments)
      };
      if (!f._fbq) f._fbq = n;
      n.push = n;
      n.loaded = !0;
      n.version = '2.0';
      n.queue = [];
      t = b.createElement(e);
      t.async = !0;
      t.src = v;
      s = b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t, s)
    }(window,
      document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '704341881591730');
    fbq('track', 'PageView');
  </script>

  <script async crossorigin="anonymous" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9214010465016719"></script>
<?php
}
add_action('wp_head', 'aer_inject_tracking_scripts');

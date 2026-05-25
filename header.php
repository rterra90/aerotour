<!DOCTYPE html>
<html lang="pt-BR">

<?php
global $wpdb;
$user = wp_get_current_user();
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= aer_get_seo_description() ?>">
  <meta name="copyright" content="© <?= date('Y') ?> Aerotour Excursões" />
  <meta name='impact-site-verification' value='add848c6-76d4-4a87-bb61-581c82810766'>
  <title><?= wp_title('|', true, 'right') ?></title>
  <link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() ?>/assets/images/icones/aer-favicon.png" type="image/x-icon">

  <!-- Estilo principal -->
  <link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/style.min.css??ver=<?= aer_get_asset_version(
                                                                                          '/style.min.css'
                                                                                        ) ?>">


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="preload" href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'" crossorigin>
  <noscript>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap">
  </noscript>

  <?php
  $hero = aer_get_hero_data();
  $bg_desktop = esc_url($hero['bg_desktop']);
  $bg_mobile  = esc_url($hero['bg_mobile']);

  ?>
  <style>
    /* Garante que o CSS peça exatamente o que foi pré-carregado */
    .carousel-item.featured-bg {
      background-image: url('<?= $bg_mobile ?>');
    }

    @media (min-width: 769px) {
      .carousel-item.featured-bg {
        background-image: url('<?= $bg_desktop ?>');
      }
    }
  </style>

  <?php

  // Preload Inteligente para o Background
  if ($bg_mobile) { ?>
    <link class="opt" rel="preload" as="image" href="<?= esc_url($hero['bg_mobile']) ?>" fetchpriority="high" media="(max-width: 768px)">
  <?php }

  if ($bg_desktop) { ?>
    <link class="opt" rel="preload" as="image" href="<?= esc_url($hero['bg_desktop']) ?>" fetchpriority="high" media="(min-width: 769px)">
  <?php }

  // Preload para a imagem de foco (logo/artista) - geralmente a mesma para ambos
  if ($hero['focus']) { ?>
    <link rel="preload" as="image" href="<?= esc_url($hero['focus']) ?>" fetchpriority="high">
  <?php }


  $campanhas_ativas = aer_get_active_campaigns(); ?>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>
  <script src="<?= get_stylesheet_directory_uri() ?>/js/helper/cards-slider.js?ver=<?= aer_get_asset_version(
                                                                                      '/cards-slider.js'
                                                                                    ) ?>" defer></script>

  <?php if (is_front_page()): ?>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Aerotour Excursões",
        "image": "https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/logo-padrao.png",
        "@id": "https://www.aerotour.com.br/",
        "url": "https://www.aerotour.com.br/",
        "telephone": "+55-19-99747-7465",
        "sameAs": [
          "https://www.facebook.com/aerotourcampinas",
          "https://www.instagram.com/aerotour_excursoes"
        ]
      }
    </script>
  <?php endif; ?>

  <!-- Mercado Pago (Apenas no Checkout) -->
  <?php if (is_checkout()): ?>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
  <?php endif; ?>

  <noscript><img class="d-none" height="1" width="1" src="https://www.facebook.com/tr?id=704341881591730&ev=PageView&noscript=1" /></noscript>

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <?php wp_body_open(); ?>

  <?php if (isset($_COOKIE['parceiro_pdv'])) {

    $codigo_pdv = sanitize_text_field($_COOKIE['parceiro_pdv']);
    $nome_pdv = obter_nome_pdv_por_codigo($codigo_pdv);
  ?>

    <!-- TROCAR POR MODAL BOOTSTRAP -->
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // salva em localStorace chave 'pdv_alert_popup' com valor false apenas se 'pdv_alert_popup' não estiver definido
        if (!localStorage.getItem('pdv_alert_popup')) {
          localStorage.setItem('pdv_alert_popup', 'checked');

          //Instancia um novo modal
          const modalElement = new Modal('generalModal', '.modal-content-body');
          modalElement.open('parceiroPDV', {
            nomeParceiro: '<?= $nome_pdv ?>'
          });
        }
      });
    </script>

    <!-- FIM TROCAR POR MODAL BOOTSTRAP -->
  <?php
  } else {
  ?>
    <script>
      localStorage.removeItem('pdv_alert_popup');
    </script>
  <?php
  }

  $header_type_class = get_theme_mod('theme_header_type', 'header-fixed');
  $show_top_header = get_theme_mod('theme_show_top_header', true);
  $top_header_text = get_theme_mod('theme_top_header_text', "Seja bem vindo ao nosso site!");

  if ($show_top_header) : ?>
    <div id="top-header">
      <h1 class="mb-0 h6"><?= $top_header_text; ?></h1>
    </div>
  <?php endif; ?>

  <header class="main-header-modern <?= $show_top_header ? 'has-top-header ' : ''; ?><?= $header_type_class; ?> <?= is_front_page() ? 'is-on-home' : 'is-inner-page'; ?>" id="aer_header">
    <?php // Tenta obter as campanhas ativas do cache primeiro
    $campanhas_ativas = get_transient('aer_campanhas_ativas');
    if ($campanhas_ativas === false) {
      // Se não estiver no cache, faz a consulta ao banco de dados
      $todas_campanhas = $wpdb->get_results(
        $wpdb->prepare(
          'SELECT `id`,`nome_campanha`,`valido_de`, `valido_ate`, `status` from `aer_camp_premios`'
        )
      ); // Filtra as campanhas para encontrar apenas as que estão no prazo de validade
      $campanhas_ativas = array_values(
        array_filter($todas_campanhas, function ($_camp) {
          $inicio = strtotime($_camp->valido_de); // Adiciona 24h ao prazo final para garantir que o último dia seja incluso
          $final = strtotime($_camp->valido_ate) + 86400;
          $agora = time();
          return $agora >= $inicio && $agora <= $final;
        })
      ); // Salva o resultado no cache por 1 hora (3600 segundos)
      set_transient('aer_campanhas_ativas', $campanhas_ativas, HOUR_IN_SECONDS);
    }
    ?>

    <div class="topbar d-flex justify-content-between align-items-center py-3">
      <div class="header-logo">
        <a href="<?= get_home_url() ?>">
          <?php
          if(get_theme_mod('theme_header_logo')) : ?>
          <img src="<?= esc_url(get_theme_mod('theme_header_logo')) ?>" alt="Logo <?= bloginfo('name'); ?>">
          <?php else : ?>
          <img src="<?= get_stylesheet_directory_uri(  ); ?>/assets/placeholders/header-logo-placeholder.png" alt="Logo placeholder">
          <?php endif; ?>
        </a>
      </div>

      <div class="header-hub">
        <div class="header-status-greeting d-none d-md-block">
          <a href="<?= wc_get_page_permalink('myaccount') ?>">
            <?= is_user_logged_in() ? 'Olá, <strong>' . wp_get_current_user()->display_name . '</strong>' : 'Olá, <strong>visitante</strong>' ?>
          </a>
        </div>

        <?php
        $menu_style = get_theme_mod('theme_menu_style', 'menu-dropdown');
        $target_id  = ($menu_style === 'menu-offcanvas') ? 'navOffcanvasMenu' : 'navModernDropdown';
        ?>

        <div class="header-actions-wrapper d-flex align-items-center gap-2">
          <?php $notifications_count = 0; ?>
          <?php if (false) : ?>
            <div class="action-icon notification-icon">
              <i class="bi bi-bell"></i>
              <?php if ($notifications_count > 0) : ?> <span class="action-badge"><?= $notifications_count; ?></span> <?php endif; ?>
            </div>
          <?php endif; ?>

          <div class="action-icon account-icon">
            <a href="<?= wc_get_page_permalink('myaccount') ?>"><i class="bi bi-person"></i></a>
          </div>

          <div class="action-icon cart-icon">
            <?php $cart_count = (int) WC()->cart->get_cart_contents_count(); ?>
            <a href="<?= wc_get_cart_url(); ?>">
              <i class="bi bi-cart"></i>
              <?php if ($cart_count > 0) : ?> <span class="action-badge"><?= $cart_count; ?></span> <?php endif; ?>

            </a>
          </div>

          <button class="navbar-toggler" type="button"
            data-bs-toggle="<?= ($menu_style === 'menu-offcanvas') ? 'offcanvas' : 'collapse'; ?>"
            data-bs-target="#<?= $target_id; ?>"
            aria-controls="<?= $target_id; ?>">
            <span class="navbar-toggler-icon"><i class="bi bi-list"></i></span>
          </button>
        </div>

        <?php if ($menu_style === 'menu-offcanvas') : ?>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="navOffcanvasMenu" aria-labelledby="navOffcanvasMenuLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="navOffcanvasMenuLabel">Menu</h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="offcanvas-body">
              <?php theme_render_menu_content(); // Função auxiliar para evitar repetição 
              ?>
            </div>
          </div>
        <?php else : ?>
          <div class="collapse navbar-collapse" id="navModernDropdown">
            <div class="dropdown-content-inner">
              <?php theme_render_menu_content(); ?>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <?php
      function theme_render_menu_content()
      { ?>
        <div class="user-dropdown-section">
          <?php if (is_user_logged_in()) : ?>
            <a href="<?= wc_get_page_permalink('myaccount') ?>" class="user-link"><i class="bi bi-person"></i> Minha Conta</a>
          <?php else : ?>
            <a href="<?= wc_get_page_permalink('myaccount') ?>" class="user-link login-btn">Entrar / Cadastrar</a>
          <?php endif; ?>
        </div>

        <hr class="dropdown-divider">

        <?php wp_nav_menu([
          'menu' => 'principal',
          'container' => 'ul',
          'menu_class' => 'navbar-nav'
        ]); ?>

        <hr class="dropdown-divider">

        <div class="d-flex justify-content-between align-items-center px-1">
          <div class="color-scheme-wrapper">
            <button id="theme-switcher" class="theme-toggle-btn">
              <div class="toggle-track">
                <i class="bi bi-brightness-low"></i>
                <i class="bi bi-moon"></i>
                <div class="toggle-thumb"></div>
              </div>
            </button>
          </div>
          <div class="social-dropdown-links d-flex gap-3">
            <a href="<?= get_option('contato_facebook'); ?>" target="_blank"><?= aer_icons('facebook', 20, 20) ?></a>
            <a href="<?= get_option('contato_instagram'); ?>" target="_blank"><?= aer_icons('instagram', 20, 20) ?></a>
          </div>
        </div>
      <?php } ?>

    </div>
    <script>
      // Ajustes Dark/Light Mode
      document.addEventListener('DOMContentLoaded', function() {
        const themeBtn = document.getElementById('theme-switcher');
        const body = document.body;

        // 1. Verifica se já existe uma preferência salva
        const savedTheme = localStorage.getItem('aerotour-theme') || 'theme-dark';
        body.classList.add(savedTheme);

        themeBtn.addEventListener('click', function() {
          if (body.classList.contains('theme-dark')) {
            body.classList.replace('theme-dark', 'theme-light');
            localStorage.setItem('aerotour-theme', 'theme-light');
          } else {
            body.classList.replace('theme-light', 'theme-dark');
            localStorage.setItem('aerotour-theme', 'theme-dark');
          }
        });
      });

      // Header fixo
      window.addEventListener('scroll', function() {
        const header = document.querySelector('#aer_header.header-fixed');
        if (header) {
          if (window.scrollY > 26) header.classList.add('scrolled');
          else header.classList.remove('scrolled');
        }

      });
    </script>
  </header>
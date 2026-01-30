<!DOCTYPE html>
<html lang="pt-BR">

<?php
global $wpdb;
$user = wp_get_current_user();
$description_content = '';
if (is_product()) {
  $description_content = get_post_meta(
    get_the_ID(),
    '_yoast_wpseo_metadesc',
    true
  );
} elseif (is_product_category()) {
  $description_content =
    'Confira todas as nossas próximas excursões para ' .
    strtolower(get_queried_object()->name) .
    'e faça sua reserva!';
} elseif (is_archive()) {
  $description_content =
    'Confira todas as nossas próximas excursões e faça sua reserva!';
} else {
  $description_content =
    'Excursões para shows e eventos é com a Aerotour! Saídas de Campinas, Indaiatuba, Sumaré, Hortolândia, Paulínia, Salto, Valinhos, Vinhedo e Jundiaí.';
}
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?= $description_content ?>">
  <meta name="copyright" content="© <?= date('Y') ?> Aerotour Excursões" />
  <meta name='impact-site-verification' value='add848c6-76d4-4a87-bb61-581c82810766'>

  <style>
    .carousel-item.active {
      background-image: url('<?= esc_url($background_img) ?>');
    }
  </style>

  <title><?= wp_title('|', true, 'right') ?></title>
  <!-- //bloginfo('name') -->
  <link rel="canonical" href="<?= esc_url(get_permalink(get_the_ID())) ?>" />
  <link rel="shortcut icon" href="<?= get_stylesheet_directory_uri() ?>/assets/images/icones/aer-favicon.png" type="image/x-icon">

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
// 1. Otimização de busca de dados (Cache com Transients)
$featured_data = get_transient('aer_featured_trip');
$featured_data = []; //deve ser apagado após teste
if (count($featured_data) === 0) {
  $excursoes_hero = wc_get_products([
    'orderby' => 'date',
    'order' => 'DESC',
    'status' => 'publish',
    'limit' => 5,
    'featured' => true
  ]);

  // Inicializamos como array vazio para evitar erros
  $featured_data = [];

  foreach ($excursoes_hero as $_exc) {
    $featured_data = [
      'bg' => wp_get_attachment_image_src(
        get_post_meta($_exc->get_id(), 'dest_img_1_id', true),
        'full'
      )[0],
      'focus' => wp_get_attachment_image_src(
        get_post_meta($_exc->get_id(), 'dest_img_2_id', true),
        'large'
      )[0]
    ];
    break;
  }
  set_transient('aer_featured_trip', $featured_data, DAY_IN_SECONDS);
}
$background_img = $featured_data['bg'] ?? '';
$focus_img = $featured_data['focus'] ?? '';

//Preload das imagens de destaque da home
if ($background_img): ?>
    <link rel="preload" as="image" href="<?= esc_url(
      $background_img
    ) ?>" fetchpriority="high">
    <?php if ($focus_img): ?>
        <link rel="preload" as="image" href="<?= esc_url(
          $focus_img
        ) ?>" fetchpriority="high">
    <?php endif; ?>
<?php endif;
?>

  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/helper/style-selected-element.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" defer></script>

<script src="<?= get_stylesheet_directory_uri() ?>/js/helper/cards-slider.js?ver=<?= aer_get_asset_version(
  '/cards-slider.js'
) ?>" defer></script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "Aerotour Excursões",
  "image": "https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/main.png",
  "@id": "https://www.aerotour.com.br/",
  "url": "https://www.aerotour.com.br/",
  "telephone": "+55-19-99747-7465",
  "sameAs": [
    "https://www.facebook.com/aerotourcampinas",
    "https://www.instagram.com/aerotour_excursoes"
  ]
}
</script>


<script>
window.addEventListener('load', function() {
    
    // 1. Bloco de Rastreamento (Apenas para não-admins e com atraso)
    <?php if (!current_user_can('administrator')): ?>
        setTimeout(function() {
            // 1. Google Tag Manager (GTM)
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-W8B65D68');

            // 2. Google Analytics (gtag.js)
            var gtagScript = document.createElement('script');
            gtagScript.src = "https://www.googletagmanager.com/gtag/js?id=G-F1239QYGYB";
            gtagScript.async = true;
            document.head.appendChild(gtagScript);
            
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-F1239QYGYB');

            // 3. Meta Pixel (Facebook)
            !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '704341881591730');
            fbq('track', 'PageView');

            // 4. Google ADS
            var adsense = document.createElement('script');
            adsense.src = "https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9214010465016719";
            adsense.async = true;
            adsense.crossOrigin = "anonymous";
            document.head.appendChild(adsense);
        }, 3500);

        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=704341881591730&ev=PageView&noscript=1"
        /></noscript>

//         <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W8B65D68"
// height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php endif; ?>

    // 2. Bloco do Mercado Pago (Apenas no Checkout)
    <?php if (is_checkout()): ?>
        setTimeout(function() {
            var mp = document.createElement('script');
            mp.src = "https://sdk.mercadopago.com/js/v2";
            mp.async = true;
            document.head.appendChild(mp);
            console.log('Mercado Pago: SDK carregado para finalização de compra.');
        }, 1000); // Carrega um pouco antes dos rastreadores por ser funcional
    <?php endif; ?>

});
</script>






<body <?php body_class(); ?>>

<?php if (isset($_COOKIE['parceiro_pdv'])) {

  $codigo_pdv = sanitize_text_field($_COOKIE['parceiro_pdv']);
  $nome_pdv = obter_nome_pdv_por_codigo($codigo_pdv);
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // salva em localStorace chave 'pdv_alert_popup' com valor false apenas se 'pdv_alert_popup' não estiver definido
      if (!localStorage.getItem('pdv_alert_popup')) {
        localStorage.setItem('pdv_alert_popup', 'checked');

        //Instancia um novo modal
        const modalElement = new Modal('generalModal', '.modal-content-body');
        modalElement.open('parceiroPDV', {nomeParceiro: '<?= $nome_pdv ?>'});
      }
    });
  </script>
<?php
} else {
   ?>
    <script>
      //remove a chave 'pdv_alert_popup' do localStorage
      localStorage.removeItem('pdv_alert_popup');
    </script>
  <?php
} ?>

  <?php
  if (
    !is_user_logged_in() &&
    get_option('new_register_coupon_status') &&
    get_option('new_register_coupon_status')['status'] === 'ativado'
  ) { ?>
      <div id="top-header">Cadastre-se e ganhe um <strong>cupom de 10%</strong> para sua próxima reserva. É por tempo limitado!</div>
      <?php }
  $url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  if (strpos($url, '/blog/') !== false) {
    echo '';
  } else {
     ?>
      <div id="top-header">
      <h1 class="mb-0 h6">Excursões para shows eventos é com a Aerotour!</h1>
    </div>
    <?php
  }
  ?>
  <header class="hero-container <?= is_front_page()
    ? ''
    : 'inner-header' ?>" id="aer_header">
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
?>  <?php if (isset($campanhas_ativas[0])) {
    $campanha_atual = $campanhas_ativas[0];
    include 'includes/modals/roleta.php';
    // if(is_user_logged_in()){
    //   if(wp_get_current_user() -> ID == 42  || wp_get_current_user() -> ID == 70)
    //   include 'includes/modals/roleta.php';
    // }
  } ?>


    <div class="topbar d-flex justify-between py-3">
      <div class="logo">
        <a href="<?= get_home_url() ?>">
          <img src="<?= esc_url(
            get_theme_mod('aer_logo')
          ) ?>" alt="<?= esc_attr(
  get_post_meta(
    attachment_url_to_postid(get_theme_mod('aer_logo')),
    '_wp_attachment_image_alt',
    true
  )
) ?>">
        </a>
      </div>
      <div class="navbar-flex-wrapper">
        <nav class="navbar navbar-expand-lg d-flex justify-content-end">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">

            <!-- Verificar a necessidade de incluir a classe nav-item do bootstrap nas li's -->
            <?php wp_nav_menu([
              'menu' => 'principal',
              'container' => 'ul',
              'menu_class' => 'navbar-nav d-flex'
            ]); ?>
          </div>
        </nav>
        <div class="user">
          <?= !is_user_logged_in()
            ? '<a href="' . wc_get_page_permalink('myaccount') . '">'
            : '' ?>
          <div class="topbar-user-wrapper">
              <div class="<?= is_user_logged_in()
                ? 'usuario-logado'
                : '' ?> d-flex">
              
                <div class="saudacao d-flex align-items-center gap-2"><?= aer_icons(
                  'user',
                  16,
                  16
                ) ?><span><?= is_user_logged_in()
  ? $user->display_name
  : 'Olá, visitante' ?></span></div>
                <?php if (is_user_logged_in()) { ?>
                <div class="user-menu-container user-menu-btn" onclick="openModalBox('user-menu-modal')">
                  
                    <?php wp_nav_menu([
                      'menu' => 'Usuário header',
                      'container_id' => 'user-menu-modal',
                      'container_class' => 'd-none'
                    ]); ?>
                  <script>changeStyle("#user-menu-modal .menu-item")</script>
                </div>
                <?php } ?>
              </div>
              
            </div>
          <?= !is_user_logged_in() ? '</a>' : '' ?>
          
        </div>
      </div>
      <div class="topbar-social">
        <a href="https://www.facebook.com/aerotourcampinas/" target="_blank" aria-label="Ícone do Facebook"><?= aer_icons(
          'facebook',
          26,
          26
        ) ?></a>   
        <a href="https://www.instagram.com/aerotour_excursoes/" target="_blank" aria-label="Ícone do Instagram"><?= aer_icons(
          'instagram',
          26,
          26
        ) ?></a> 
      </div>
    </div>

    <script>
      const loginInputs = document.querySelectorAll('#loginform .input');
      function handleLoginClass(event) {
        event.currentTarget.value !== '' ? event.currentTarget.classList.add('preenchido') : event.currentTarget.classList.remove('preenchido');
      }
      loginInputs.forEach(input => {
        input.addEventListener('focus', handleLoginClass);
        input.addEventListener('blur', handleLoginClass);
      });
      
    </script>
  </header>
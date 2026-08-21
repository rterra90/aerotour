<?php

use Pelago\Emogrifier\CssInliner;

$root_url = get_stylesheet_directory_uri();

// ENDPOINTS PARA CONSUMIR A REST API
require_once get_template_directory() . '/endpoints/api_reserva_put.php';
require_once get_template_directory() . '/endpoints/cupom_update.php';
require_once get_template_directory() . '/endpoints/cupom_update.php';
require_once get_template_directory() . '/endpoints/api_campanhas_get.php';
require_once get_template_directory() . '/endpoints/api_google_login.php';
require_once get_template_directory() .
  '/endpoints/participantes_roleta_put.php';
require_once get_template_directory() . '/endpoints/api_user_get.php';
require_once get_template_directory() . '/endpoints/api_leads_reserva.php';
// require_once(get_template_directory() . '/endpoints/api_contratos_post.php');

// Adiciona um tamanho focado em mobile (proporção vertical/centralizada)
add_image_size('hero_mobile', 600, 900, true); // O 'true' força o corte (crop) central

// 1. Criar o Widget de inserção de reservas em massa no Dashboard
add_action('wp_dashboard_setup', 'aer_add_csv_import_widget');

function aer_add_csv_import_widget()
{
  wp_add_dashboard_widget(
    'aer_reserva_import_box',         // ID do Widget
    'Importar Passageiros (CSV)',     // Título
    'aer_reserva_import_display'      // Função de exibição
  );
}

// 2. Interface do Widget
function aer_reserva_import_display()
{
  // Verificar se o formulário foi enviado
  if (isset($_POST['aer_import_nonce']) && wp_verify_nonce($_POST['aer_import_nonce'], 'aer_csv_upload')) {
    aer_handle_csv_upload();
  }
?>
  <form method="post" enctype="multipart/form-data">
    <?php wp_nonce_field('aer_csv_upload', 'aer_import_nonce'); ?>
    <p>Selecione o arquivo .csv com os passageiros:</p>
    <input type="file" name="aer_csv_file" accept=".csv" required />
    <p style="font-size: 11px; color: #666;">
      Formato esperado: Nome Completo, CPF, Telefone, Embarque
    </p>
    <?php submit_button('Importar Passageiros'); ?>
  </form>
  <?php
}

// 3. Processamento do CSV e Inserção no Banco
function aer_handle_csv_upload()
{
  global $wpdb;
  $table_name = 'aer_reservas'; // Ajuste se o prefixo for diferente

  if (!empty($_FILES['aer_csv_file']['tmp_name'])) {
    $file = fopen($_FILES['aer_csv_file']['tmp_name'], 'r');
    $count = 0;

    // Ignorar o cabeçalho se o seu CSV tiver um
    // fgetcsv($file); 

    while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
      // $data[0] = Nome, $data[1] = CPF, $data[2] = Telefone, $data[3] = Embarque

      $wpdb->insert(
        $table_name,
        array(
          'user_id'       => 0,
          'order_user_id' => 0,
          'variation_id'  => 5572,
          'order_id'      => 0,
          'status'        => 'normal',
          'p_nome'        => sanitize_text_field($data[0]),
          'p_cpf'         => sanitize_text_field($data[1]),
          'p_telefone'    => sanitize_text_field($data[2]),
          'embarque'      => sanitize_text_field($data[3]),
          'horario'       => '00:00', // Valor padrão caso a coluna exija
          'saida'         => 0,
          'volta'         => 0,
          'data_nasc'     => null,
          'rota'          => 1
        )
      );
      $count++;
    }
    fclose($file);
    echo "<div class='updated'><p>Sucesso! $count passageiros importados.</p></div>";
  }
}

// Localize script com URLs do site para uso em JS
wp_enqueue_script('theme-links', get_template_directory_uri() . '/js/main.js', array(), '1.0', true);
wp_localize_script('theme-links', 'themeLinks', [
  'adminUrl' => admin_url(),
  'ajaxUrl' => admin_url('admin-ajax.php'),
  'siteUrl' => get_site_url(),
  'cartUrl' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : null,
  'stylesheetUrl' => get_stylesheet_directory_uri(),
  'gLoginClientId' => get_option('google_client_id') ?: null,
]);



// ÁREA DE INCLUDES
require_once get_template_directory() . '/includes/theme-setup.php';
require_once get_template_directory() . '/includes/header-functions.php';
require_once get_template_directory() . '/includes/woocommerce-functions.php';
require_once get_template_directory() . '/includes/utilities.php'; // Funções utilitárias gerais
require_once get_template_directory() . '/includes/functions/ajax-hooks.php';
require_once get_template_directory() . '/includes/functions/usuarios-functions.php';
require_once get_template_directory() . '/includes/footer-scripts.php';
require_once get_template_directory() . '/includes/functions/pax-meta-functions.php'; //Funções para o fluxo de metadados de passageiros

require_once get_template_directory() . '/includes/tabela-solic-edit-pax.php';



require_once get_template_directory() . '/admin-head-scripts.php';
require_once get_template_directory() . '/admin-footer-scripts.php';
// require_once get_template_directory() . '/email-hooks.php';
require_once get_template_directory() . '/exc-passageiros-admin.php';
require_once get_template_directory() . '/includes/preview-emails.php';
require_once get_template_directory() . '/includes/functions/login-functions.php';
require_once get_template_directory() . '/includes/functions/refunds-functions.php';
require_once get_template_directory() . '/includes/cards-slider.php';
require_once get_template_directory() . '/includes/functions/sort-excursoes.php';
require_once get_template_directory() . '/includes/functions/coupons-functions.php';
require_once get_template_directory() . '/includes/functions/blog.php';
require_once get_template_directory() . '/includes/functions/general-customize.php';
require_once get_template_directory() . '/includes/afiliados/pdv-functions.php';
require_once get_template_directory() . '/includes/features/leads/leads-functions.php';

// require_once get_template_directory() . '/includes/functions/contrato.php';



add_filter( 'woocommerce_add_notice', 'filtrar_notice_confirmacao_email', 10, 1 );
function filtrar_notice_confirmacao_email( $message ) {
    // Substitua 'confirme seu e-mail' por uma parte do texto exato exibido no aviso
    if ( strpos( strtolower( $message ), 'email address to check for past orders' ) !== false || strpos( strtolower( $message ), 'verify your email' ) !== false ) {
        return false; // Intercepta e ignora essa mensagem específica
    }
    return $message;
}






// FUNÇÃO GLOBAL PARA RENDERIZAR E-MAILS
function aer_render_email($template_name, $args = [])
{
  // Define o caminho para a pasta de emails
  $template_path = __DIR__ . "/emails/email-{$template_name}.php";
  $css_path = __DIR__ . "/emails/emails-estilos.css";

  if (!file_exists($template_path)) {
    return 'Template não encontrado.';
  }

  // Extrai o array $args para variáveis individuais (ex: $args['nome'] vira $nome)
  extract($args);

  ob_start();
  include $template_path;
  $html = ob_get_clean();
  // return ob_get_clean();

  // Se existir um arquivo CSS, injetamos ele para o processamento
  $html_com_estilo = $html;

  if (file_exists($css_path)) {

    $css = file_get_contents($css_path);

    // Se você não usa Composer, uma alternativa é injetar o <style> 
    // temporariamente para o cliente, ou usar um conversor.
    // Aqui, vamos envolver o HTML com o estilo para garantir a leitura.
    $html = "<html><meta name='color-scheme' content='light dark'><meta name='supported-color-schemes' content='light dark'><head><style>{$css}</style></head><body>{$html}</body></html>";

    // Verifica se a classe existe antes de instanciar
    if ( class_exists( 'Pelago\Emogrifier\CssInliner' ) ) {
        $cssInliner = \Pelago\Emogrifier\CssInliner::fromHtml( $html );
        if ( ! empty( $css ) ) {
            $cssInliner->inlineCss( $css );
        }
        $html = $cssInliner->render();
    } else {
        // Se a classe não for encontrada, injeta o CSS direto em uma tag <style> no head
        $html = str_replace( '</head>', '<style>' . $css . '</style></head>', $html );
    }
    // $html_com_estilo = CssInliner::fromHtml($html)->inlineCss($css)->render();
  }

  return $html_com_estilo;
}

// FUNÇÃO GLOBAL DE ENVIO DE E-MAILS
function aer_send_email($to, $subject, $template_name, $args = [])
{
  // Definição de body e headers
  $body = aer_render_email($template_name, $args);
  $headers = [
    'Content-Type: text/html; charset=UTF-8',
    'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
  ];

  // Disparo do e-mail
  return wp_mail($to, $subject, $body, $headers);
}

// FUNÇÃO QUE ESTILIZA OS EMAILS PADRÃO DO WOOCOMMERCE
add_filter('woocommerce_email_styles', 'custom_woocommerce_email_styles', 999, 2);
function custom_woocommerce_email_styles($css, $email)
{
  $custom_css = "
        .email-box { background-color: #ffffff !important; }
        h1 { font-family: Raleway, Arial, sans-serif; }
        a { color: #400f0f; text-decoration: underline; }
        
        
        /* Proteção Dark Mode que definimos antes */
        @media (prefers-color-scheme: dark) {
            .email-container { background-color: #1a1a1a !important; }
            .email-box { background-color: #ffffff !important; }
            .light-img { display: none !important; }
            .dark-img-wrapper { display: block !important; width: auto !important; max-height: none !important; }
        }
    ";
  return $css . $custom_css;
}


// Adicionar campo personalizado ao checkout
add_filter('woocommerce_checkout_fields', 'add_cpf_checkout_field');

function add_cpf_checkout_field($fields)
{
  $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
  $fields['billing']['cpf'] = [
    'label' => 'CPF',
    'placeholder' => 'CPF',
    'required' => true,
    'class' => ['form-row-wide'],
    'priority' => 25,
    'default' => strlen($cpf_meta_atual) != 11 ? '' : cpf_mask($cpf_meta_atual),
    'maxlength' => 14
  ];
  return $fields;
}

// Adicionar validação ao campo personalizado
add_action('woocommerce_checkout_process', 'custom_checkout_field_validation');
function custom_checkout_field_validation()
{
  function validar_cpf($cpf)
  {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o CPF tem 11 dígitos
    if (strlen($cpf) != 11) {
      return false;
    }

    // Verifica se todos os dígitos são iguais
    if (preg_match('/(\d)\1{10}/', $cpf)) {
      return false;
    }

    // Calcula o primeiro dígito verificador
    for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
        $d += $cpf[$c] * ($t + 1 - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
        return false;
      }
    }
    return true;
  }

  if (empty($_POST['cpf'])) {
    wc_add_notice(
      'Por favor, informe o CPF nos dados de faturamento.',
      'error'
    );
  } else {
    $checkout_cpf = $_POST['cpf'];
    if (validar_cpf($checkout_cpf)) {
      $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
      if ($cpf_meta_atual == '') {
        update_user_meta(
          get_current_user_id(),
          'cpf',
          str_replace('.', '', str_replace('-', '', $checkout_cpf))
        );
      }
    } else {
      wc_add_notice(
        'Por favor, verifique o CPF informado nos Detalhes de cobrança.',
        'error'
      );
    }
  }
}

add_filter('wc_add_to_cart_message', 'add_to_cart_message', 10, 2);
function add_to_cart_message($message, $product_id)
{
  $produto = wc_get_product($product_id);
  return "<div class='aer-notices-cart'><p class='aer-notices-cart-title'>Adicionado ao carrinho com sucesso: <span>" .
    $produto->name .
    '</span></p><p>Confira os detalhes de sua solicitação abaixo e continue para o pagamento para confirmar sua reserva!</p><p>Você também pode continuar comprando para reservar seu lugar em outras de nossas excursões no mesmo pedido.</p></div>';
}

add_filter('gettext', 'cant_add_more_message', 10, 3);
add_filter('ngettext', 'cant_add_more_message', 10, 3);
function cant_add_more_message($translated, $text, $domain)
{
  if (
    str_starts_with($text, 'You cannot add another') &&
    $domain === 'woocommerce'
  ) {
    // Replacement text (where "%s" is the dynamic product name)
    $translated = __(
      '<p>Você já tem uma solicitação de reserva para essa excursão em seu carrinho.</p>',
      $domain
    );
  }
  return $translated;
}

add_filter('woocommerce_get_availability', 'change_availability_text', 10, 2);
function change_availability_text($args, $product)
{
  if ($product->managing_stock() && $product->is_type('variation')) {
    $args['availability'] = $product->get_stock_quantity();
    $args['class'] = 'stock-count';
  }
  return $args;
}

/* Termos e condições */
add_action(
  'woocommerce_register_form',
  'add_terms_and_conditions_to_registration',
  20
);
function add_terms_and_conditions_to_registration()
{
?>
  <p class="form-row terms wc-terms-and-conditions">
    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
      <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked(
                                                                                                                            apply_filters(
                                                                                                                              'woocommerce_terms_is_checked_default',
                                                                                                                              isset($_POST['terms'])
                                                                                                                            ),
                                                                                                                            true
                                                                                                                          ); ?> id="terms" /> <span class="small">Concordo com os <b><a href="<?= get_privacy_policy_url() ?>" target="_blank">termos de uso</b> e com a <b>política de privacidade.</b></a></span>
    </label>
    <input type="hidden" name="terms-field" value="1" />
  </p>
<?php
}

// Validate required term and conditions check box
add_action(
  'woocommerce_register_post',
  'terms_and_conditions_validation',
  20,
  3
);
function terms_and_conditions_validation($username, $email, $validation_errors)
{
  // if(strlen($_POST['username']) !== 14 || !validaCPF($_POST['username'])) $validation_errors->add( 'cpf_error', __( 'Por favor, informe um CPF válido.', 'woocommerce' ) );
  if (!isset($_POST['terms'])) {
    $validation_errors->add(
      'terms_error',
      __(
        'É obrigatório concordar com a política de privacidade.',
        'woocommerce'
      )
    );
  }

  return $validation_errors;
}
/* Fim Termos e condições */


//ANTES DE CALCULAR O TOTAL DO CARRINHO
add_action('woocommerce_before_calculate_totals', 'aer_fees');
function aer_fees($cart_items)
{
  foreach ($cart_items->get_cart() as $item) {
    $item_fee =
      isset($item['taxa']) && $item['taxa'] !== 'unset' && $item['taxa'] != 0
      ? (int) $item['taxa']
      : 0;
    $final_price = $item['data']->regular_price + $item_fee;

    // Verifica se há desconto antecipado quando foi adicionado ao carrinho (1ª verificação)
    $desconto_antecipado = $item['desconto_antecipado'];
    if ($desconto_antecipado !== false && $desconto_antecipado !== 'false') {
      $data_evento = new DateTime($desconto_antecipado); //yyyy-mm-dd
      $hoje = new DateTime(); // data e hora atuais

      // calcula a diferença de dias
      $intervalo = $hoje->diff($data_evento);
      $dias_ate_evento = (int) $intervalo->format('%r%a'); // %r mantém o sinal

      // data quando faltarão 30 dias para exibir no aviso
      $data_limite_desconto = (clone $data_evento)->modify('-30 days');

      $item['data']->update_meta_data(
        'data_limite_desconto',
        $data_limite_desconto->format('Y-m-d')
      );
      $item['data']->update_meta_data('preco_original', $final_price);

      if ($dias_ate_evento >= 29) {
        //30 dias ou mais, concede o desconto
        $final_price = $final_price * 0.95;
        $item['data']->update_meta_data('desconto_antecipado_rev', true);
      } else {
        $item['data']->update_meta_data('desconto_antecipado_rev', false);
      }
    }

    //Define o preço do item
    $item['data']->set_price($final_price);
  }
}

add_filter('wp_title', 'filter_function_name', 10, 3);

function filter_function_name($title, $sep, $seplocation)
{
  if (str_starts_with($title, 'Loja')) {
    return 'Todas as excursões | ';
  } elseif (str_contains($title, 'Categorias de produto | ')) {
    return str_replace('Categorias de produto | ', '', $title);
  }
  return $title;
}



// Função para atualizar a data limite do produto pai baseada nas variações (utilities)
function aer_atualizar_data_limite_produto($product_id)
{
  $product = wc_get_product($product_id);
  if (!$product || !$product->is_type('variable')) {
    return;
  }

  $maior_timestamp = 0;
  $variations = $product->get_available_variations();

  foreach ($variations as $variation) {
    // Extrai a data do nome da variação (ex: "Show - 25/12/2024")
    if (
      preg_match(
        '/(\d{2})\/(\d{2})\/(\d{4})/',
        $variation['attributes']['attribute_dia'] ?? '',
        $matches
      )
    ) {
      $timestamp = strtotime("{$matches[3]}-{$matches[2]}-{$matches[1]}");
      if ($timestamp > $maior_timestamp) {
        $maior_timestamp = $timestamp;
      }
    }
  }

  if ($maior_timestamp > 0) {
    // Salva no formato YYYYMMDD para busca rápida no banco
    update_post_meta(
      $product_id,
      'data_limite_excursao',
      date('Ymd', $maior_timestamp)
    );
  }
}

// Executa sempre que um produto for salvo/atualizado
add_action('woocommerce_update_product', 'aer_atualizar_data_limite_produto');



//FUNÇÕES QUE CARREGAM APENAS NO PAINEL ADMIN
if (is_admin()) {

  // CONFIGURAÇÕES DO TEMA
  require_once get_template_directory() .
    '/includes/admin-pages/theme-settings.php';

  // CUSTOMIZAÇÕES EM CREATE/EDIT PRODUCT PAGE
  require_once get_template_directory() . '/includes/functions/create-edit-product-functions.php';

  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/check-in/check-in-widget.php'; // widget check-in
  require_once get_template_directory() .
    '/includes/admin-pages/reservas-admin.php'; //página Reservas
  require_once get_template_directory() .
    '/includes/admin-pages/embarques/embarques-admin.php'; //página Embarques
  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/home-cards-widget.php'; // widget home cards
  require_once get_template_directory() .
    '/includes/admin-pages/panel-widgets/campanhas_cupons_widget.php'; // widget campanhas cupons
  require_once get_template_directory() .
    '/includes/admin-pages/cancelamentos-admin.php';
  require_once get_template_directory() .
    '/includes/admin-pages/exc-embarques-admin.php';

  //   require_once get_template_directory() .
  // '/includes/admin-pages/fluxo-adicionar-excursao.php'; // widget check-in

  /**
   * Renderiza o input (Helper)
   */
  // function admin_render_input_field($args)
  // {
  //   $option = get_option($args['label_for']);
  //   $type = isset($args['type']) ? $args['type'] : 'text';
  //   echo '<input type="' . esc_attr($type) . '" name="' . esc_attr($args['label_for']) . '" value="' . esc_attr($option) . '" class="regular-text">';
  // }



  //ADMIN CUSTOM SCRIPTS
  function admin_custom_scripts()
  {
    wp_enqueue_style(
      'admin-style',
      get_template_directory_uri() . '/css/admin-style.css',
      false,
      '1.0.0'
    );
    wp_enqueue_script(
      'react',
      'https://unpkg.com/react@18/umd/react.development.js'
    );
    wp_enqueue_script(
      'react-dom',
      'https://unpkg.com/react-dom@18/umd/react-dom.development.js'
    );
    wp_enqueue_script(
      'media-selector',
      get_template_directory_uri() . '/js/media-selector.js',
      ['jquery'],
      null,
      true
    );
    wp_enqueue_script(
      'fetch-admin-api',
      get_template_directory_uri() . '/js/fetch-admin-api.js',
      ['jquery'],
      null,
      true
    );
    wp_localize_script('fetch-admin-api', 'theme_links', [
      'adminUrl' => admin_url(),
      'adminAjaxUrl' => admin_url('admin-ajax.php')
    ]);
    wp_enqueue_script(
      'sortable-js',
      'https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js',
      [],
      '1.14.0',
      true
    );

    wp_enqueue_script(
      'home-galerias-widget',
      get_template_directory_uri() .
        '/js/admin-panel-widgets/home-galerias-widget/home-galerias-widget.js',
      ['jquery'],
      null,
      true
    );
  }
  add_action('admin_enqueue_scripts', 'admin_custom_scripts');

  // ADMIN MENU
  add_action('admin_menu', 'admin_menu_custom_options');
  function admin_menu_custom_options()
  {
    add_menu_page(
      'Embarques',
      'Embarques',
      'manage_options',
      'embarques',
      'embarques_admin_page',
      'dashicons-location',
      25
    );
    add_menu_page(
      'Cancelamentos',
      'Cancelamentos',
      'manage_options',
      'cancelamentos',
      'cancelamentos_admin_page',
      'dashicons-money-alt',
      25
    );
    add_menu_page(
      'Reservas',
      'Reservas',
      'manage_options',
      'reservas',
      'reservas_admin_page',
      'dashicons-money-alt',
      25
    );
  }

  // WIDGETS PAINEL ADMIN
  add_action('wp_dashboard_setup', 'aer_dashboard_widgets');
  function aer_dashboard_widgets()
  {
    wp_add_dashboard_widget(
      'manage_coupons',
      'Gerenciar cupons',
      'manage_coupons_widget'
    );
    // wp_add_dashboard_widget('aer_check_in', 'Check-in', 'aer_check_in_widget');
    wp_add_dashboard_widget('check_in', 'Novo Check-in', 'check_in_widget');
    wp_add_dashboard_widget(
      'cards_home',
      'Excursões da página inicial',
      'home_cards_widget'
    );
    wp_add_dashboard_widget(
      'campanhas_cupons_widget',
      'Campanhas de cupons',
      'campanhas_cupons_widget'
    );
  }

  // REMOVE OPÇÕES AVANÇADAS PADRÃO DO WOOCOMMERCE NÃO UTILIZADAS
  /* Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */
  add_filter('woocommerce_product_data_tabs', 'adiciona_passageiros_painel');
  function adiciona_passageiros_painel($tabs)
  {
    unset($tabs['shipping']);
    unset($tabs['inventory']);

    $tabs['Passageiros'] = [
      'label' => 'Passageiros',
      'target' => 'passageiros_meta',
      'priority' => 10
    ];
    $tabs['Embarques'] = [
      'label' => 'Pontos de embarque',
      'target' => 'exc_embarques_meta',
      'priority' => 11
    ];
    return $tabs;
  }
  /* Fim Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */

  add_action('admin_footer', 'carregar_js_personalizado_para_abas');
  function carregar_js_personalizado_para_abas()
  {
  ?>
    <script>
      jQuery(function($) {
        // Ao clicar na aba personalizada
        $('body').on('click', '.wc-tabs li a', function() {
          var target = $(this).attr('href');
          if (target === '#exc_embarques_meta') { // Verifique se a aba personalizada foi selecionada
            const _allVar = document.querySelectorAll('#variable_product_options .woocommerce_variations .woocommerce_variation');
            const _datas = Array.from(_allVar).map((_d) => {
              return _d.querySelector('h3 > select').value
            })
            const _wrapper = document.querySelector('#exc_embarques_meta.panel.woocommerce_options_panel');
            if (_datas.length < 1) {
              _wrapper.querySelector('.section-show').style.display = 'none';
              _wrapper.querySelector('.section-hide').style.display = 'block';
            } else {

              _wrapper.querySelector('.section-show').style.display = 'block';
              _wrapper.querySelector('.section-hide').style.display = 'none';

              _wrapper.querySelector('.section-show').dataset.dias = JSON.stringify(_datas)
            }
          }
        });
      });
    </script>
<?php
  }

  // Permitir upload de SVG
  add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
  });

  // Corrigir exibição do SVG na biblioteca de mídia
  add_filter('wp_prepare_attachment_for_js', function ($response, $attachment, $meta) {
    if ($response['mime'] === 'image/svg+xml' && empty($response['sizes'])) {
      $response['sizes'] = [
        'full' => [
          'url' => $response['url'],
          'width' => 100,
          'height' => 100,
          'orientation' => 'portrait',
        ]
      ];
    }
    return $response;
  }, 10, 3);
};


?>
<?php
$root_url = get_stylesheet_directory_uri();

function slugify($str, $delimiter = '-'){
  $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
  return $slug;

} 


//Número de produtos na página de arquivo
add_filter( 'loop_shop_per_page', function( $cols ) {
  return 100;
}, 20 );

//Remove a exibição de cross-sell do cart
remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

//Medidas de imagens
add_image_size( 'card_img_size', 300, 95);
add_image_size( 'blog_card_thumb', 330, 220);

//ADICIONAR SUPORTE WOOCOMMERCE
function aerotour_add_woocommercer_support(){
  add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'aerotour_add_woocommercer_support');


// include 'includes/initial-setup.php';

include 'utilities.php';
include 'admin-head-scripts.php';
include 'admin-footer-scripts.php';
include 'admin-ajax-hooks.php';
include 'email-hooks.php';
include 'exc-passageiros-admin.php';

include 'includes/functions/login-functions.php';
include 'includes/functions/refunds-functions.php';
include 'includes/cards-slider.php';
// include 'includes/functions/contrato.php';
include 'includes/functions/sort-excursoes.php';
include 'includes/functions/coupons-functions.php';
include 'includes/functions/blog.php';
include 'includes/functions/general-customize.php';
include 'includes/functions/process-product-meta.php';




function remover_breadcrumb_em_arquivos_woocommerce() {
  if ( is_product_category() || is_shop() || is_product_tag() ) remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
}
add_action( 'wp', 'remover_breadcrumb_em_arquivos_woocommerce' );


/* Adiciona campos ao formulário de registro */
  function campos_registro(){
    $campos = [['Primeiro nome', 'billing_first_name'], ['Sobrenome', 'billing_last_name']];

    foreach($campos as $campo){
      ?>
        <p class="form-row">
          <label for=<?= $campo[1]; ?>><?php _e($campo[0], 'text_domain'); ?><span class="required">*</span></label>
          <input type="text" class="input-text" name=<?= $campo[1]; ?> id=<?= $campo[1]; ?> value=<?php if (!empty($_POST[$campo[1]])) esc_attr_e($_POST[$campo[1]]); ?> >
      </p>
      <?php
    }

  }
  function salva_campos($customer_id) {
    $campos = [['Primeiro nome', 'billing_first_name'], ['Sobrenome', 'billing_last_name']];

    foreach($campos as $campo){
      if($campo[0] === "Primeiro nome" && isset($_POST[$campo[1]])){
        update_user_meta($customer_id, $campo[1], sanitize_text_field($_POST[$campo[1]]));
        wp_update_user(['ID'=>$customer_id, 'first_name'=>$_POST[$campo[1]]]);
        wp_update_user(['ID'=>$customer_id, 'display_name'=>$_POST[$campo[1]]]);

      } elseif ($campo[0] === "Sobrenome" && isset($_POST[$campo[1]])){
        update_user_meta($customer_id, $campo[1], sanitize_text_field($_POST[$campo[1]]));
        wp_update_user(['ID'=>$customer_id, 'last_name'=>$_POST[$campo[1]]]);

      } elseif ($campo[0] === "Telefone" && isset($_POST[$campo[1]])){
        update_user_meta($customer_id, $campo[1], sanitize_text_field($_POST[$campo[1]]));
      } 
    }

    if(isset($_POST['register_method'])){
      update_user_meta( $customer_id, 'register_method', $_POST['register_method']);
      // if($_POST['register_method'] === '_google_register'){
      // wp_new_user_notification( $customer_id, null,'user');
      // }
    }

    update_user_meta( $customer_id, 'billing_city', '');
    update_user_meta( $customer_id, 'data_nasc', '');
    update_user_meta( $customer_id, 'rg', '');
    update_user_meta( $customer_id, 'rg_orgao_exp', '');
    update_user_meta( $customer_id, 'cupons', '');


    if(isset($_POST['qr_event_coupon_control'])) update_user_meta( $customer_id, 'qr_event_coupon_control', $_POST['qr_event_coupon_control']);
    else if(isset($_POST['new_register_coupon_control'])) update_user_meta( $customer_id, 'new_register_coupon_control', $_POST['new_register_coupon_control']);
  }

  add_action('woocommerce_register_form_start', 'campos_registro');
  // add_action('woocommerce_register_form', 'avisos_registro');
  add_action('woocommerce_created_customer', 'salva_campos');
/* Fim Adiciona campos ao formulário de registro */

/* Formulário de alteração de dados pessoais */
  function add_fields_to_edit_account_form(){
    $campos = [['Telefone', 'billing_phone'], ['CPF', 'cpf'], ['RG', 'rg'], ['Data de nascimento', 'data_nasc'], ['Cidade', 'billing_city']];
    foreach($campos as $campo){
      $value = isset(get_user_meta(get_current_user_id())[$campo[1]][0]) ? esc_attr( get_user_meta(get_current_user_id())[$campo[1]][0] ) : '';
      ?>
      <div>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
        <label for="<?= $campo[1]; ?>"><?= $campo[0]; ?></label>
        <?php
          if($campo[0] == "CPF" && $value !== ""){
            ?>
            <input disabled type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" id="<?= $campo[1]; ?>" value="<?php echo cpf_mask($value); ?>" />
            <?php
          }else{
            ?>
            <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="<?= $campo[1]; ?>" id="<?= $campo[1]; ?>" value="<?php echo $value; ?>" />
            <?php
          }
        ?>

        </p>
      </div>
      <?php
    }
    ?>
    <?php
  }

  function save_account_details_form($customer_id){
    $campos = [['Telefone', 'billing_phone'], ['CPF', 'cpf'], ['RG', 'rg'], ['Data de nascimento', 'data_nasc'], ['Cidade', 'billing_city']];
    foreach($campos as $campo){
        if( isset( $_POST[$campo[1]] ) ){
          $_value = $_POST[$campo[1]];
          if($campo[1] == 'cpf'){
            $_value = str_replace('-', '', str_replace('.', '', $_POST[$campo[1]]));
          }
          
          update_user_meta( $customer_id, $campo[1], sanitize_text_field($_value) );
        }
      }
  }

  add_action( 'woocommerce_edit_account_form', 'add_fields_to_edit_account_form' );
  add_action( 'woocommerce_save_account_details', 'save_account_details_form' );
/* Fim Formulário de alteração de dados pessoais */

/* Insere os dados do passageiro como meta do item do carrinho */
  add_filter( 'woocommerce_add_cart_item_data', 'insere_dados_passageiro_pedido', 10, 6 );
  function insere_dados_passageiro_pedido($cart_item_data, $product_id, $variation_id, $quantity){
    global $wpdb;
    $cart_item_data['embarque'] = $_POST['embarque'];
    $cart_item_data['horario'] = $_POST['horario'];
    $cart_item_data['passageiros'] = $_POST['passageiros'];
    $cart_item_data['taxa'] = $_POST['taxa'];

    return $cart_item_data;

    
  }
/* Fim Insere os dados do passageiro como meta do item do carrinho */


/* Insere dados do passageiro como meta da order */
  add_action( 'woocommerce_checkout_update_order_meta', 'insere_passageiro_order_pendente', 10, 3 );
  function insere_passageiro_order_pendente( $order_id, $data ) {

    $order_meta = array();

    //ajustar pdv
    // if(!empty($_POST['pdv'])) update_post_meta($order_id, 'pdv', $_POST['pdv']); 
    // if(!empty($_POST['pdv'])) $passageiro_a['pdv'] = $_POST['pdv'];
    //   $passageiro = json_encode($passageiro_a, JSON_UNESCAPED_UNICODE);


    foreach(WC()->cart->get_cart() as $cart_item){
      $passageiros = json_decode(str_replace('\"', '"', $cart_item['passageiros']));
      $order_item_meta = array(
        'passageiros' => $passageiros,
        'embarque' => $cart_item['embarque'],
        'horario' => $cart_item['horario'],
        'variation_id' => $cart_item['variation_id'],
        'order_id' => $order_id
      );
      array_push($order_meta, $order_item_meta);
    }
    update_post_meta($order_id, 'passageiros_items', $order_meta);
    
    $order_meta = json_encode($order_meta, JSON_UNESCAPED_UNICODE);
    update_post_meta($order_id, 'passageiros_items_str', $order_meta);
  }
/* Fim Insere dados do passageiro como meta da order */


/* Insere passageiro na lista após o pagamento */
  add_action( 'woocommerce_order_status_processing', 'pagamento_processing' );
  function pagamento_processing($order_id){
    $order = wc_get_order( $order_id );
    if($order->get_status() === 'processing') $order->update_status( 'completed' );
  }

  add_action( 'woocommerce_order_status_completed', 'pagamento_completed' );
  function pagamento_completed($order_id){
    global $wpdb;
    $order = wc_get_order( $order_id );
    $passageiros_items = get_post_meta($order_id, 'passageiros_items', true);
    
    $p_index = 0;
    foreach($order -> get_items() as $order_item){
      $passageiros = $passageiros_items[$p_index]['passageiros'];
      // $passageiros = array_filter($passageiros, function ($item){ if($item !== false) return $item; });
      $embarque = $passageiros_items[$p_index]['embarque'];
      $horario = $passageiros_items[$p_index]['horario'];
      $variation_id = $passageiros_items[$p_index]['variation_id'];
      $p_index = $p_index + 1;

      foreach($passageiros as $passageiro){
        //Obtém o ID do usuário titular do pedido
        $order_user_id = $order -> get_customer_id();
        $reserva_user_id = 0;


        $user_nickname = wp_get_current_user() -> user_login;
        if(is_numeric($user_nickname)){ //usuários antigos, com CPF no nickname
            // $reserva_user_id = $passageiro -> doc != $user_nickname ? 0 : $order_user_id; 

            if($passageiro -> doc != $user_nickname){

              if(username_exists($passageiro -> doc)){
                $reserva_user_id = username_exists($passageiro -> doc);
              }else{
                $args = array( 'meta_key' => 'cpf', 'meta_value' => $passageiro -> doc, 'number' => 1, 'count_total' => false, 'fields' => 'ID', );
                $user_query = new WP_User_Query($args);
                if (!empty($user_query->get_results())) {
                $reserva_user_id = $user_query->get_results()[0];
              }else{
                $reserva_user_id = 0;
              }
              }


            }else{
              $reserva_user_id = $order_user_id;
            }

        }else{ //usuários novos, com email no nickname

          //CPF meta do usuário atual que está fazendo o pedido
          $cpf_current_user = get_user_meta(get_current_user_id(), 'cpf', true);

          if((int)$passageiro -> doc !== (int)$cpf_current_user){
            
            if(username_exists($passageiro -> doc)){ //Verifica se existe user antigo com o cpf no user_login
              $reserva_user_id = username_exists($passageiro -> doc);
              
            } else { //Verifica se existe user novo com o cpf no meta 'cpf'

              $args = array( 'meta_key' => 'cpf', 'meta_value' => $passageiro -> doc, 'number' => 1, 'count_total' => false, 'fields' => 'ID', );
              $user_query = new WP_User_Query($args);

              // Verifica se encontrou algum usuário
              if (!empty($user_query->get_results())) {
                $reserva_user_id = $user_query->get_results()[0];
              }else{
                $reserva_user_id = 0;
              }
            }

          }else{
            $reserva_user_id = $order_user_id;
          }
        }

        $nome_embarque = $wpdb -> get_results("SELECT nome from aer_embarques WHERE id = $embarque");
        $nome_embarque = $nome_embarque[0] -> nome;
        $mapaRota = [
            'ida-e-volta' => 1,
            'ida' => 2,
            'volta' => 3
        ];
        $rota = $mapaRota[$passageiro->tripType] ?? null;

        $wpdb -> query("INSERT INTO `aer_reservas` (`ID`, `user_id`, `order_user_id`, `variation_id`, `order_id`, `status`, `p_nome`, `p_cpf`, `p_telefone`, `embarque`, `horario`, `data_nasc`, `rota`) VALUES (NULL, '".$reserva_user_id."', '".$order_user_id."', '".$variation_id."', '".$order_id."', 'normal', '".$passageiro -> nome_completo."', '".$passageiro -> cpf."', '".$passageiro -> celular."', '".$nome_embarque."', '".$horario."', '".$passageiro -> data_nascimento."', '".$rota."')");
      }
    }
  }



  add_action( 'woocommerce_order_status_completed', 'pagamento_completo' );
  function pagamento_completo($order_id){

    $order = wc_get_order( $order_id );
    $order_items = $order->get_items( apply_filters( 'woocommerce_purchase_order_item_types', 'line_item' ) );

    $passageiro_string = $order -> get_meta('passageiro');
    $passageiro = json_decode($passageiro_string, true);



    //Envia email para pdv que fez a venda
    if(isset($passageiro['pdv'])){
      $exc_vendidas = array();
      foreach($order_items as $item){
        $product = $item->get_product();
        $nome_excursao = $product -> get_title();
        array_push($exc_vendidas, $nome_excursao);
      }

      function email_excursoes($excs){
        if(sizeof($excs) === 1) return $excs[0];
        else return implode(', ', $excs);
      }


      $email_to = 'renatobancadorock@gmail.com';
      $email_subject = 'Nova reserva Aerotour em seu ponto de venda!';
      $email_message = "<html>
      <head>
        <title>Nova reserva Aerotour em seu ponto de venda!</title>
      </head>
      <body>
        <p>Uma nova reserva nas excursões da Aerotour foi registrada junto ao seu ponto de venda. Confira os detalhes abaixo:</p>
        <div>
          <p>Ponto de venda: " . str_replace('_', ' ', strtoupper($passageiro['pdv'])) . "</p>
          <p>Pedido: " . $order_id . "</p>
          <p>Excursão: " . email_excursoes($exc_vendidas) . "</p>
          <p>Cliente: " . $passageiro['nome_completo'] . "</p>
        </div>
        <br/>
        <p>Guarde este e-mail para futuras conferências.</p>
      </body>
    </html>";
    $email_headers = "From: Aerotour Excursões <contato@aerotour.com.br>" . "\r\n";
    $email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $email_headers .= "MIME-Version: 1.0" . "\r\n";
      mail($email_to, $email_subject, $email_message, $email_headers);
    }


    $_i = 0;
    foreach($order->get_items() as $item){
      $passageiros = get_post_meta( $item -> get_variation_id(), 'passageiros', true ) !== '' ? json_decode(get_post_meta( $item -> get_variation_id(), 'passageiros' )[0], true) : array();

      /* formata o valor de 'embarque' - pode ser array ou string */
      if(gettype($passageiro['embarque']) !== 'string'){
        $passageiro_a = $passageiro;
        $passageiro_a['embarque'] = $passageiro['embarque'][$_i];
        array_push($passageiros, $passageiro_a);
      }else array_push($passageiros, $passageiro);
      
      $_i++;
      $passageiros_array = json_encode($passageiros, JSON_UNESCAPED_UNICODE);
      update_post_meta($item -> get_variation_id(), 'passageiros', $passageiros_array);
      }
  }
/* Fim Insere passageiro na lista após o pagamento */



// Adicionar campo personalizado ao checkout
add_filter('woocommerce_checkout_fields', 'add_cpf_checkout_field');

function add_cpf_checkout_field($fields) {
    $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
    $fields['billing']['cpf'] = array(
        'label'       => 'CPF',
        'placeholder' => 'CPF',
        'required'    => true,
        'class'       => array('form-row-wide'),
        'priority'    => 25,
        'default'     => strlen($cpf_meta_atual) != 11 ? '' : cpf_mask($cpf_meta_atual),
        'maxlength'   => 14
    );
    return $fields;
}

// Adicionar validação ao campo personalizado
add_action('woocommerce_checkout_process', 'custom_checkout_field_validation');
function custom_checkout_field_validation() {

  function validar_cpf($cpf) {
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
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
  }

  if (empty($_POST['cpf'])) {
      wc_add_notice('Por favor, informe o CPF nos dados de faturamento.', 'error');
  }else{
    $checkout_cpf = $_POST['cpf'];
    if(validar_cpf($checkout_cpf)){
      $cpf_meta_atual = get_user_meta(get_current_user_id(), 'cpf', true);
      if($cpf_meta_atual == '') update_user_meta( get_current_user_id(), 'cpf', str_replace('.', '', str_replace('-', '', $checkout_cpf)) );
    }else{
      wc_add_notice('Por favor, verifique o CPF informado nos dados de faturamento.', 'error');

    }
  }
}



add_filter('wc_add_to_cart_message', 'add_to_cart_message', 10, 2);
function add_to_cart_message($message, $product_id) {
  $produto = wc_get_product($product_id);
    return "<div class='aer-notices-cart'><p class='aer-notices-cart-title'>Adicionado ao carrinho com sucesso: <span>" . $produto -> name . "</span></p><p>Confira os detalhes de sua solicitação abaixo e continue para o pagamento para confirmar sua reserva!</p><p>Você também pode continuar comprando para reservar seu lugar em outras de nossas excursões no mesmo pedido.</p></div>";
}

add_filter(  'gettext',  'cant_add_more_message', 10, 3 );
add_filter(  'ngettext',  'cant_add_more_message', 10, 3 );
function cant_add_more_message( $translated, $text, $domain  ) {
    if( str_starts_with($text, 'You cannot add another') && $domain === 'woocommerce' ){
        // Replacement text (where "%s" is the dynamic product name)
        $translated = __( '<p>Você já tem uma solicitação de reserva para essa excursão em seu carrinho.</p>', $domain );
    }
    return $translated;
}


add_filter( 'woocommerce_get_availability', 'change_availability_text', 10, 2 );
function change_availability_text($args, $product){
  if ( $product->managing_stock() && $product->is_type('variation') ) {
    $args['availability'] = $product->get_stock_quantity();
    $args['class'] = 'stock-count';
  }
  return $args;
}


/* Termos e condições */
  add_action( 'woocommerce_register_form', 'add_terms_and_conditions_to_registration', 20 );
  function add_terms_and_conditions_to_registration() {
  ?>
  <p class="form-row terms wc-terms-and-conditions">
              <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                  <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); ?> id="terms" /> <span class="small">Concordo com os <b><a href="<?= get_privacy_policy_url(); ?>" target="_blank">termos de uso</b> e com a <b>política de privacidade.</b></a></span>
              </label>
              <input type="hidden" name="terms-field" value="1" />
          </p>
  <?php
  }

  // Validate required term and conditions check box
  add_action( 'woocommerce_register_post', 'terms_and_conditions_validation', 20, 3 );
  function terms_and_conditions_validation( $username, $email, $validation_errors ) {
    // if(strlen($_POST['username']) !== 14 || !validaCPF($_POST['username'])) $validation_errors->add( 'cpf_error', __( 'Por favor, informe um CPF válido.', 'woocommerce' ) );
    if ( ! isset( $_POST['terms'] ) )
          $validation_errors->add( 'terms_error', __( 'É obrigatório concordar com a política de privacidade.', 'woocommerce' ) );

      return $validation_errors;
  }
/* Fim Termos e condições */


/* Ponto de venda em cart_collaterals */
add_action( 'woocommerce_review_order_before_payment', 'exibe_pdv');
function exibe_pdv(){
  ?>
  <div class="cart_collaterals_pdv">
    <p>Ponto de venda: <span></span></p>
    <input type="hidden" name="pdv">
    <script>

      if(window.sessionStorage.getItem('aer_pdv')){
        document.querySelector('input[name="pdv"]').value = window.sessionStorage.getItem('aer_pdv'); 
        document.querySelector('.cart_collaterals_pdv span').innerText = window.sessionStorage.getItem('aer_pdv').replace(/\_/g, ' ');
      }else document.querySelector('.cart_collaterals_pdv').remove();
    </script>
  </div>
    
  <?php
}
/* Fim Ponto de venda em cart_collaterals */

/* Valida adição ao carrinho*/
add_filter( 'woocommerce_add_to_cart_validation', 'filter_add_to_cart_validation', 10, 5 );
function filter_add_to_cart_validation($passed, $product_id, $quantity, $variation_id, $variations){
    foreach(WC()->cart->get_cart() as $cart_item){
        if($cart_item['variation_id'] === $variation_id){
            $passed = false;
                        // Displaying a custom message
            $message = __( "<span>Parece que você já tem uma reserva para essa excursão no carrinho.<a href='".wc_get_cart_url()."' class='message-link'>Ver carrinho</a></span>", "woocommerce" );
            wc_add_notice( $message, 'error' );
            // We stop the loop
            break; 
        } 
        else $passed = true;
    }
    return $passed;
}
/* Fim Valida adição ao carrinho*/

add_filter( 'woocommerce_checkout_must_be_logged_in_message', 'custom_checkout_must_be_logged_in_message', 10, 1 );
function custom_checkout_must_be_logged_in_message(){
  ?>
    <script>
      if(window.location.href === '<?= wc_get_checkout_url(); ?>'){
        window.sessionStorage.setItem('aer_redirect_after_login', JSON.stringify({page:"checkout", url:"<?= wc_get_cart_url(); ?>"}))
        window.location.href = '<?= get_permalink( wc_get_page_id( 'myaccount' ) ); ?>'
      }
    </script>
  <?php
}

//ANTES DE CALCULAR O TOTAL DO CARRINHO
add_action('woocommerce_before_calculate_totals', 'aer_fees');
function aer_fees($cart_items){
  foreach($cart_items -> get_cart() as $item){
    $item_fee = (isset($item['taxa']) && $item['taxa'] !== 'unset' && $item['taxa'] != 0)
  ? (int) $item['taxa']
  : 0;
    $final_price = $item['data'] -> regular_price + $item_fee;

    // Verifica se há desconto antecipado quando foi adicionado ao carrinho (1ª verificação)
    $desconto_antecipado = $item['desconto_antecipado'];
    if($desconto_antecipado !== false && $desconto_antecipado !== "false"){
      $data_evento = new DateTime($desconto_antecipado); //yyyy-mm-dd
      $hoje = new DateTime(); // data e hora atuais

      // calcula a diferença de dias
      $intervalo = $hoje->diff($data_evento);
      $dias_ate_evento = (int) $intervalo->format('%r%a'); // %r mantém o sinal

      // data quando faltarão 30 dias para exibir no aviso
      $data_limite_desconto = (clone $data_evento)->modify('-30 days');

      $item['data']->update_meta_data('data_limite_desconto', $data_limite_desconto->format('Y-m-d'));
      $item['data']->update_meta_data('preco_original', $final_price);

      if($dias_ate_evento >= 29) { //30 dias ou mais, concede o desconto
        $final_price = $final_price * 0.95;
        $item['data']->update_meta_data('desconto_antecipado_rev', true);
      }else{
        $item['data']->update_meta_data('desconto_antecipado_rev', false);
      }
    }

    //Define o preço do item
    $item['data']->set_price($final_price);

  } 
}

add_filter( 'wp_title', 'filter_function_name', 10, 3 );

function filter_function_name( $title, $sep, $seplocation ) {
	if(str_starts_with( $title, 'Loja' )){
	  return "Todas as excursões | ";
  }else if(str_contains( $title, 'Categorias de produto | ' )){
    return str_replace('Categorias de produto | ', '', $title);
  }
	return $title;
}

require_once(get_template_directory() . '/endpoints/cupom_update.php');
require_once(get_template_directory() . '/endpoints/api_campanhas_get.php');
require_once(get_template_directory() . '/endpoints/participantes_roleta_put.php');
require_once(get_template_directory() . '/endpoints/api_user_get.php');
// require_once(get_template_directory() . '/endpoints/api_contratos_post.php');


//FUNÇÕES QUE CARREGAM APENAS NO PAINEL ADMIN
if (is_admin()) {
  include_once get_template_directory() . '/includes/admin-pages/panel-widgets/gerenciar-exc-widgets.php'; // widget check-in
  include_once get_template_directory() . '/includes/admin-pages/reservas-admin.php'; //página Reservas
  include_once get_template_directory() . '/includes/admin-pages/embarques/embarques-admin.php'; //página Embarques
  include_once get_template_directory() . '/includes/admin-pages/panel-widgets/home-cards-widget.php'; // widget home cards
  include_once get_template_directory() . '/includes/admin-pages/panel-widgets/campanhas_cupons_widget.php'; // widget campanhas cupons
  include_once get_template_directory() . '/includes/admin-pages/cancelamentos-admin.php';
  include_once get_template_directory() . '/includes/admin-pages/exc-embarques-admin.php';

  //ADMIN CUSTOM SCRIPTS
  function admin_custom_scripts() {
    wp_enqueue_style( 'admin-style', get_template_directory_uri() . '/css/admin-style.css', false, '1.0.0' );
    wp_enqueue_script('react', "https://unpkg.com/react@18/umd/react.development.js");
    wp_enqueue_script('react-dom', "https://unpkg.com/react-dom@18/umd/react-dom.development.js");
    wp_enqueue_script('media-selector', get_template_directory_uri() . '/js/media-selector.js', array('jquery'), null, true);
    wp_enqueue_script('fetch-admin-api', get_template_directory_uri() . '/js/fetch-admin-api.js', array('jquery'), null, true);
    wp_localize_script('fetch-admin-api', 'ajax_url', admin_url( 'admin-ajax.php' ));
    wp_enqueue_script('sortable-js', 'https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js', array(), '1.14.0', true);

  }
  add_action( 'admin_enqueue_scripts', 'admin_custom_scripts' );


  // ADMIN MENU
  add_action('admin_menu', 'admin_menu_embarques');
  function admin_menu_embarques(){
    add_menu_page('Embarques', 'Embarques', 'manage_options', 'embarques','embarques_admin_page', 'dashicons-location', 25);
    add_menu_page('Cancelamentos', 'Cancelamentos', 'manage_options', 'cancelamentos','cancelamentos_admin_page', 'dashicons-money-alt', 25);
    add_menu_page('Reservas', 'Reservas', 'manage_options', 'reservas','reservas_admin_page', 'dashicons-money-alt', 25);
  }

  // WIDGETS PAINEL ADMIN
  add_action('wp_dashboard_setup', 'aer_dashboard_widgets');
  function aer_dashboard_widgets(){ 
    wp_add_dashboard_widget('manage_coupons', 'Gerenciar cupons', 'manage_coupons_widget');
    wp_add_dashboard_widget('aer_check_in', 'Check-in', 'aer_check_in_widget');
    wp_add_dashboard_widget('cards_home', 'Excursões da página inicial', 'home_cards_widget');
    wp_add_dashboard_widget('campanhas_cupons_widget', 'Campanhas de cupons', 'campanhas_cupons_widget');
  }

  // REMOVE OPÇÕES AVANÇADAS PADRÃO DO WOOCOMMERCE NÃO UTILIZADAS
  /* Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */
  add_filter( 'woocommerce_product_data_tabs', 'adiciona_passageiros_painel' );
  function adiciona_passageiros_painel($tabs){
    unset( $tabs[ 'shipping' ] );
    unset( $tabs[ 'inventory' ] );

    $tabs['Passageiros'] = array(
      'label' => 'Passageiros',
      'target' => 'passageiros_meta',
      'priority' => 10,
    );
    $tabs['Embarques'] = array(
      'label' => 'Pontos de embarque',
      'target' => 'exc_embarques_meta',
      'priority' => 11,
    );
    return $tabs;
  }
  /* Fim Adiciona tab 'Passageiros' e 'Embarques' no painel - produto */


  add_action('admin_footer', 'carregar_js_personalizado_para_abas');
  function carregar_js_personalizado_para_abas() {
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
                   if(_datas.length < 1){
                      _wrapper.querySelector('.section-show').style.display = 'none';
                      _wrapper.querySelector('.section-hide').style.display = 'block';
                   }
                   else{

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
  



}
?>
<?php
//
// Adiciona cupom após login de usuário já anteriormente registrado, se habilitado
function add_coupon_after_login( $user_login, $user ) {
  $cupom_login = $_POST['qr_event_coupon_control'];
  if(isset($cupom_login)){
    // $cupons_customer = json_decode(get_user_meta($user -> ID, 'cupons', true));
    // $cupons_customer_a = array();
    update_user_meta($user -> ID, 'qr_event_coupon_control', $_POST['qr_event_coupon_control']);
  }
}
add_action('wp_login', 'add_coupon_after_login', 10, 2);


//
//Adiciona opções na página de edição/criação de cupom
function action_woocommerce_coupon_options_usage_restriction( $coupon_get_id, $coupon ) {
  ?>
    <div class="options_group options_group_restrict_customers">
    <?php
      woocommerce_wp_checkbox(
        array(
          'id'      => 'restrict_customers_coupon',
          'value'   => get_post_meta( get_the_ID(), 'restrict_customers_coupon', true ),
          'label'   => 'Restringir usuários',
          'desc_tip' => true,
          'description' => 'O cupom será exclusivo para usuários habilitados',
        )
      );
    ?>
  </div>
  <?php
    if(get_post_meta( get_the_ID(), 'restrict_customers_coupon', true ) === 'yes'){
      ?>
      <div class="coupon-customer-set">

        <!-- Componente busca usuário -->
        <?php include __DIR__.'/../admin-pages/components/user-search.php'; ?>

        
        <div class="allowed_customers">
          <?php $bb = new WC_Coupon(2902); print_r($bb -> get_used_by()); ?>
          <p>Usuários habilitados</p>
          <ul>
            <?php
              $allowed_customers = get_post_meta( get_the_ID(), 'allowed_customers', true);
              print_r($allowed_customers);
              if($allowed_customers !== ''){
                $allowed_customers_obj = json_decode($allowed_customers);
                foreach(array_reverse($allowed_customers_obj) as $user_id){
                    
                    //PEGA O USUÁRIO PELO ID
                    $user = get_user_by('id', $user_id);
                    $user_cupom_status = in_array($user_id, $coupon -> get_used_by()) ? 'usado' : 'disp';
                    if(isset($user) && $user !== false){
                        ?>
                            <li><span><?= $user -> first_name . ' ' . $user -> last_name; ?></span><?php if($user_cupom_status === 'usado') echo '<span class="dashicons dashicons-money-alt"></span>'; ?></li>
                        <?php
                    }
                }
              }else{
                echo 'Nenhum usuário habilitado ainda.<br />';
              } 
            ?>
          </ul>
        </div>
      </div>

      <?php
    }
}
add_action( 'woocommerce_coupon_options_usage_restriction', 'action_woocommerce_coupon_options_usage_restriction', 10, 2 );


//
//Salva as definições de cupom da página de edição/criação
function action_woocommerce_coupon_options_save( $post_id, $coupon ) {
  // Isset
  if ( isset ( $_POST['restrict_customers_coupon'] ) ) {
      update_post_meta( $coupon->get_id(), 'restrict_customers_coupon', $_POST['restrict_customers_coupon']);
      $coupon->save();
    } else update_post_meta( $coupon->get_id(), 'restrict_customers_coupon', '');
    
}
add_action( 'woocommerce_coupon_options_save', 'action_woocommerce_coupon_options_save', 10, 2 );


//
// Valida o cupom ao ser inserido no carrinho pelo usuário
function filter_woocommerce_coupon_is_valid( $valid, $coupon, $discount ) {
  // Get meta
  // $customer_user_id = $coupon->get_meta( 'customer_user_id' );


  $cupom_restrito = get_post_meta($coupon->get_id(), 'restrict_customers_coupon', true) == 'yes' ? true : false;
  $allowed_customers = get_post_meta($coupon->get_id(), 'allowed_customers', true);
  // $aa = json_encode($allowed_customers);
  // throw new Exception($aa, 109 );
  if($cupom_restrito){
    if($allowed_customers !== ''){
      $allowed_customers_obj = json_decode($allowed_customers);
      
      if(!in_array(wp_get_current_user() -> ID, $allowed_customers_obj)){
        $valid = false;
        if ( !$valid ) {
          throw new Exception('Parece que esse cupom não é válido.', 109 );
        }
      }
    } else throw new Exception('Parece que esse cupom não é válido.', 109 );
  }


  return $valid;
}
add_filter( 'woocommerce_coupon_is_valid', 'filter_woocommerce_coupon_is_valid', 10, 3 );


//
// Widget de cupom no painel WP
function manage_coupons_widget(){
  // update_option("qr_code_coupon_status", array(
  //   'status' => 'desativado',
  //   'code' => null,
  // ));
  ?>
  <div>
        <pre><?php print_r(get_user_by('ID', 1065)); ?></pre>
        <pre><?php print_r(get_user_meta(1065)); ?></pre>
    <form action="" method="POST">
      <fieldset>
        <label class="switch">
          <input type="checkbox" id="toggle_new_register_coupon"  class="<?= get_option('new_register_coupon_status')['status']; ?>" <?= get_option('new_register_coupon_status')['status'] === 'ativado' ? 'checked' : ''?>>
          <span class="slider round"></span>
          <span>Habilitar cupom de novo cadastro</span>
        </label>
        <?php
          if(get_option('new_register_coupon_status')['status'] === 'ativado'){
            global $wpdb;
            $coupon_codes = $wpdb->get_col("SELECT post_name FROM $wpdb->posts WHERE post_type = 'shop_coupon' AND post_status = 'publish' ORDER BY post_name ASC");
            ?>
              <select name="new_register_coupon" id="define_coupon_new_register" class="<?= get_option('new_register_coupon_status')['code'] === null ? 'pending' : 'complete'?>" onchange="">
                <option disabled value="none" <?= get_option('new_register_coupon_status')['code'] === null ? 'selected' : ''; ?>>Selecione o cupom</option>
                <?php
                  foreach($coupon_codes as $code){
                    ?>
                      <option value="<?= $code; ?>" <?= $code === get_option('new_register_coupon_status')['code'] ? 'selected' : ''?>><?= strtoupper($code); ?></option>
                    <?php
                  }
                ?>
              </select>
            <?php
          }
        ?>
      </fieldset>

      <fieldset>
      <label class="switch">
          <input type="checkbox" id="toggle_qr_coupon" class="<?= get_option('qr_code_coupon_status')['status']; ?>" <?= get_option('qr_code_coupon_status')['status'] === 'ativado' ? 'checked' : ''?>>
          <span class="slider round"></span>
          <span>Habilitar cupom por QR Code</span>
        </label>
        <?php
          if(get_option('qr_code_coupon_status')['status'] === 'ativado'){
            global $wpdb;
            $coupon_codes = $wpdb->get_col("SELECT post_name FROM $wpdb->posts WHERE post_type = 'shop_coupon' AND post_status = 'publish' ORDER BY post_name ASC");
            ?>
              <select name="qr_code_coupon" id="define_coupon_qr_code" class="<?= get_option('qr_code_coupon_status')['code'] === null ? 'pending' : 'complete'?>">
                <option disabled value="none" <?= get_option('qr_code_coupon_status')['code'] === null ? 'selected' : ''; ?>>Selecione o cupom</option>
                <?php
                  foreach($coupon_codes as $code){
                    ?>
                      <option value="<?= $code; ?>" <?= $code === get_option('qr_code_coupon_status')['code'] ? 'selected' : ''?>><?= strtoupper($code); ?></option>
                    <?php
                  }
                ?>
              </select>
            <?php
          }
        ?>
      </fieldset>


    </form>

    <script>
      const couponsQrSwitcherInput = document.querySelector("#toggle_qr_coupon");
      const couponsQrSelect = document.querySelector("#define_coupon_qr_code");
      const couponsNewRegisterInput = document.querySelector("#toggle_new_register_coupon");
      const couponsNewRegisterSelect = document.querySelector("#define_coupon_new_register");

      couponsQrSwitcherInput.addEventListener('change', couponsOptions);
      if(couponsQrSelect) addEventListener('change', couponsOptions);
      couponsNewRegisterInput.addEventListener('change', couponsOptions);
      if(couponsNewRegisterSelect) couponsNewRegisterSelect.addEventListener('change', couponsOptions);
      

      function couponsOptions(e){
        if(e.currentTarget.tagName === 'INPUT' && e.currentTarget.classList.contains('ativado')) e.currentTarget.classList.remove('ativado');
        console.log(e.target)

        const data_action = () => {
          if(e.target.tagName === 'SELECT') return 'define_coupon';
          else if(e.target.tagName === 'INPUT') return e.currentTarget.id;
        }
        const data_value = {'action': data_action()};
        if(data_action() === 'define_coupon'){
          data_value.define_coupon_type = e.target.id.replace('define_coupon_', '');
          data_value.coupon_code = e.target.value;
        } 
        jQuery(function($) {
          $.ajax({
            url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
            type: 'POST',
            data: data_value,
            success: async function(response) {
              if(response.data === 'definiu') console.log(response.data);
              else location.reload();
            },
            error: function(error) {
              console.log('response error:  ' + error);
            }
          });
        })
      }
    </script>
  </div>
  <?php
}

/**
 * Personaliza as mensagens de erro de cupons no WooCommerce
 */
add_filter('woocommerce_coupon_error', 'customizar_erros_de_cupom', 10, 3);
function customizar_erros_de_cupom($err, $err_code, $coupon) {
    
    switch ($err_code) {
        // Cenário 1: O cupom digitado simplesmente não existe ou expirou
        case WC_Coupon::E_WC_COUPON_NOT_EXIST:
            $err = __('Código de cupom inválido. Verifique se digitou corretamente ou se o cupom aindas está ativo.', 'woocommerce');
            break;

        // Cenário 2: O cupom expirou a data de validade
        case WC_Coupon::E_WC_COUPON_EXPIRED:
            $err = __('Este cupom já expirou e não pode mais ser utilizado.', 'woocommerce');
            break;

        // Cenário 3: O cupom já foi usado pelo cliente antes (limite por usuário)
        case WC_Coupon::E_WC_COUPON_ALREADY_APPLIED_THE_COUPON:
            $err = __('Você já aplicou esse cupom nesta reserva!', 'woocommerce');
            break;

        // Cenário 4: O cupom exige um valor mínimo de compra no carrinho
        case WC_Coupon::E_WC_COUPON_MIN_SPEND_LIMIT_NOT_MET:
            $err = sprintf(
                __('Este cupom só pode ser aplicado em reservas com o valor mínimo de %s.', 'woocommerce'),
                wc_price($coupon->get_minimum_amount())
            );
            break;

        // Cenário 5: Uso do cupom atingiu o limite global de utilizações da empresa
        case WC_Coupon::E_WC_COUPON_USAGE_LIMIT_REACHED:
            $err = __('Lamentamos, mas o limite máximo de utilizações deste cupom já foi atingido.', 'woocommerce');
            break;
    }

    return $err;
}
?>
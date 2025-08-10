<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); 

// update_user_meta(get_current_user_id(), 'cpf', '');
?>

<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >
  <div class="row fields-wrapper">

    <!-- ALTERAÇÃO DE SENHA -->
    <div class="muda-senha-container col-md-4">
      <fieldset class="muda-senha aer-box">
        <legend><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>
          <div class="muda-senha-box">
            <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            <input type="password" class="aer-text-input woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
          </p>
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
            <input type="password" class="aer-text-input woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
          </p>
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row">
            <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
            <input type="password" class="aer-text-input woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
          </p>
        </div>
      </fieldset>
    </div>

    <!-- FORMULÁRIO DE DETALHES DA CONTA -->
    <?php do_action( 'woocommerce_edit_account_form_start' ); ?>
    <div class="fields-container col-md-8">
      <div class="row">
        <div>
          <legend class="mb-4">Detalhes da conta</legend>
        </div>
        <div>
          <p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
            <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
          </p>
        </div>
        <div>
          <p class="woocommerce-form-row woocommerce-form-row--last form-row form-row-last">
            <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
          </p>
        </div>
        <!-- <div class="cpf-form"><p>Seu CPF: <?= cpf_mask($user->nickname); ?></p></div> -->

        <!-- INPUT DISPLAY NAME -->
        <div class="d-none">
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide d-none">
            <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="aer-text-input woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
            
          </p>
        </div>

        <!-- INPUT E-MAIL -->
        <div>
          <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="email" class="aer-text-input woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
          </p>
        </div>
      
      <?php do_action( 'woocommerce_edit_account_form' ); ?>
      </div>
    </div>


  </div>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
    
		<button type="submit" data-btn-reactive class="woocommerce-Button button btn btn-dark btn-lg<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
		<input type="hidden" name="action" value="save_account_details" />

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>
<script>
  	document.querySelector('input#billing_phone').addEventListener('keyup', (e) => celularMask(e));
</script>
<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

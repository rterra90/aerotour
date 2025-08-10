<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// após acesso por QR Code de usuário já LOGADO, atualiza o meta 'qr_event_coupon_control' para ativar o resgate de cupom
if(isset($_POST['qr_event_coupon_control']) && isset($_POST['logged_in_no_coupon'])){
	update_user_meta($current_user->ID, 'qr_event_coupon_control', $_POST['qr_event_coupon_control']);
};
// fim após acesso por QR Code de usuário já LOGADO, atualiza o meta 'qr_event_coupon_control' para ativar o resgate de cupom




$qr_event_coupon_control = get_user_meta($current_user->ID, 'qr_event_coupon_control', true);
$new_register_coupon_control = get_user_meta($current_user->ID, 'new_register_coupon_control', true);

$cupom_de_cadastro = $qr_event_coupon_control !== '' ? $qr_event_coupon_control : $new_register_coupon_control;
$status_cupom_query = null;

if(isset($cupom_de_cadastro) && $cupom_de_cadastro !== ''){
	$coupon_id = wc_get_coupon_id_by_code($cupom_de_cadastro);
	if(isset($coupon_id)){
		$coupon_customers_ids = get_post_meta($coupon_id, 'allowed_customers', true);
		$customer_cupons_meta = get_user_meta($current_user->ID, 'cupons', true);
		$coupon_customers_ids_a = array();
		$customer_cupons_meta_a = array();

		//verifica se o usuário já tem o cupom
		if($customer_cupons_meta !== '' && in_array($cupom_de_cadastro, json_decode($customer_cupons_meta))) $status_cupom_query = 'ja_resgatado';
		else{
			//se for um cupom restrito, atualiza a meta 'allowed_customers' do cupom
			if(get_post_meta($coupon_id, 'restrict_customers_coupon', true) === 'yes'){
				if($coupon_customers_ids === '') $coupon_customers_ids_a = [$current_user->ID];
				else {
					$coupon_customers_ids_a = json_decode($coupon_customers_ids);
					array_push($coupon_customers_ids_a, $current_user->ID);
				}
				$coupon_customers_ids_a_str = json_encode($coupon_customers_ids_a);
				update_post_meta($coupon_id, 'allowed_customers', $coupon_customers_ids_a_str);
			}
			


			//atualiza a usermeta 'cupons'
			if($customer_cupons_meta === '') $customer_cupons_meta_a = [$cupom_de_cadastro];
			else {
				$customer_cupons_meta_a = json_decode($customer_cupons_meta);
				array_push($customer_cupons_meta_a, $cupom_de_cadastro);
			}
			$customer_cupons_meta_a_str = json_encode($customer_cupons_meta_a);
			update_user_meta($current_user->ID, 'cupons', $customer_cupons_meta_a_str);

			$status_cupom_query = 'resgatado_com_sucesso';

		}
		//limpa as usermetas 'qr_event_coupon_control' e 'new_register_coupon_control'
		update_user_meta($current_user->ID, 'qr_event_coupon_control', '');
		update_user_meta($current_user->ID, 'new_register_coupon_control', '');

		//envia e-mail de confirmação para o usuário
		$wc_cupom = new WC_Coupon($cupom_de_cadastro);
		$cupom_desc = $wc_cupom->get_discount_type() === 'percent' ? $wc_cupom->get_amount() . '%' : 'R$ ' . $wc_cupom->get_amount();
		$email_to = $current_user -> user_email;
		$email_subject = "Cupom ". $cupom_de_cadastro . " resgatado com sucesso!";
		$email_message = "<html>
    <head>
      <title>Cupom ". strtoupper($cupom_de_cadastro) . " resgatado com sucesso!</title>
    </head>
    <body>
      <h1 style='margin-bottom: 20px; font-size: 2rem'>Cupom " . strtoupper($cupom_de_cadastro) . " resgatado com sucesso!</h1>
      <p>Olá, " . $current_user->display_name . "!</p>
      <p>Você acaba de garantir o seu cupom " . strtoupper($cupom_de_cadastro) . " para utlizar na sua próxima reserva na em excursão da Aerotour!</p>
      <p>Para utilizá-lo, basta inseri-lo no carrinho, conferir o desconto e prosseguir para o pagamento.</p>
			<p>Confira abaixo mais detalhes sobre seu cupom.</p>
      <div style='margin-bottom: 15px; border: 3px dotted #353535; padding: 5px 10px;	max-width: 400px; background-color: #d0d7df;' >
				<p style='margin-bottom: 0px'>" . strtoupper($cupom_de_cadastro) . "</p>
				<div style='display: flex; justify-content: space-between'>
					<span style='font-size: .925rem'>" . $cupom_desc . " de desconto</span>
					<span style='font-size: .925rem'>Valido até " . str_replace('-', '/', date("d-m-Y", strtotime($wc_cupom->get_date_expires()))) . "</span>
				</div>
      </div>
			<div>
				<span>Regras de utilização</span>
				<ul>
					<li>Não pode ser utilizado em conjunto com outros cupons;</li>
					<li>Não restituído em caso de cancelamento da reserva em que foi utilizado;</li>
					<li>Deve ser aplicado no carrinho, tendo efeito sobre o valor total do pedido;</li>
					<li>Esse cupom é intransferível e pode ser utilizado apenas pelo titular da conta que o possui.</li>
				</ul>
			</div>
      <img id='email-footer-logo' src='" . get_stylesheet_directory_uri() . "/assets/images/main.png' style='width:200px; display: block; margin: 40px auto 20px;'/>
			<p style='text-align: center; font-size: .775rem'><a href='https://www.aerotour.com.br' target='_blank'>www.aerotour.com.br</a></p>
    </body>
  </html>";
	$email_headers = "From: Aerotour Excursões <contato@aerotour.com.br>" . "\r\n";
  $email_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $email_headers .= "MIME-Version: 1.0" . "\r\n";
  mail($email_to, $email_subject, $email_message, $email_headers);

		//remove a key "aer_qr_event" do localStorage
		?> <script>window.localStorage.removeItem('aer_qr_event')</script> <?php
	}
}

?>
<script>
const redirect = window.sessionStorage.getItem('aer_redirect_after_login');
if(redirect){
	window.sessionStorage.removeItem('aer_redirect_after_login');

	window.location.href = JSON.parse(redirect).url;
}
</script>
<?php

if(isset($status_cupom_query)){
	if($status_cupom_query === 'ja_resgatado'){
		?>
			<div class="qr_event_inner_alert ja_resgatado mb-3">Parece que você já resgatou esse cupom.</div>
		<?php
	}else if($status_cupom_query === 'resgatado_com_sucesso'){
		?>
		<div class="qr_event_inner_alert mb-3">Parabéns! Você garantiu o seu cupom de 10% de desconto!</div>
		<?php
	}
}
?>

<p> Olá, <strong><?= $current_user->display_name; ?></strong></p>

<main id="painel-dashboard" class="py-sm-2 py-0">
<?php include 'user-cupons.php'; ?>

</main>


<?php
	do_action( 'woocommerce_account_dashboard' );
	do_action( 'woocommerce_before_my_account' );
	do_action( 'woocommerce_after_my_account' );
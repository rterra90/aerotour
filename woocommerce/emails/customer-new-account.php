<?php
defined('ABSPATH') || exit;

// Lógica de nome que definimos anteriormente
$nome_exibicao = '';
if (isset($email->object->display_name)) {
	$nome_exibicao = $email->object->display_name;
} elseif (isset($user_login)) {
	$nome_exibicao = $user_login;
}

do_action('woocommerce_email_header', $email_heading, $email); ?>

<div style="text-align: center; margin-bottom: 30px;">
	<h2 style="color: #400f0f; font-size: 22px; margin: 0 0 10px 0;">Olá, <?php echo esc_html($nome_exibicao); ?>!</h2>
	<p style="font-size: 16px; color: #555; margin: 0;">Ficamos felizes em ter você conosco na <strong>Aerotour Excursões</strong>.</p>
</div>

<p style="text-align: center; font-size: 15px; color: #666; margin-bottom: 30px;">
	Sua conta foi criada com sucesso! Agora você tem acesso a uma experiência completa para planejar sua próxima aventura.
</p>

<div style="margin-bottom: 40px; display: flex; flex-wrap: wrap; justify-content: space-evenly">

	<div style="padding: 10px; min-width: 200px">
		<a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>"
			style="display: block; background-color: #400f0f; color: #ffffff; padding: 15px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 14px; line-height: 1.1">
			🚌 Ver Todas as Excursões
		</a>
	</div>
	<div style="padding: 10px; min-width: 200px">
		<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
			style="display: block;background-color: #ffffff;color: #400f0f;padding: 15px 20px;text-decoration: none;border-radius: 6px;box-shadow: inset 0 0 0px 2px #400f0f;font-weight: bold;font-size: 14px;line-height: 1.1;">
			👤 Acessar Minha Conta
		</a>
	</div>

</div>

<div style="background-color: #f9f9f9; border-radius: 8px; padding: 20px; text-align: center;">
	<p style="font-size: 13px; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Siga-nos nas redes sociais</p>
	<div style="display:flex;flex-wrap: wrap;justify-content: space-evenly;row-gap: 12px;">
		<div style="flex: 1 1 150px">
			<a href="https://instagram.com/aerotourexcursoes" style="text-decoration: none; margin: 0 10px;">
				<img src="https://cdn-icons-png.flaticon.com/512/174/174855.png" width="30" alt="Instagram" style="vertical-align: middle;">
				<span style="color: #400f0f; font-weight: bold; font-size: 14px; margin-left: 5px;">Instagram</span>
			</a>
		</div>

		<div style="flex: 1 1 150px">
			<a href="https://facebook.com/aerotourexcursoes" style="text-decoration: none; margin: 0 10px;">
				<img src="https://cdn-icons-png.flaticon.com/512/174/174848.png" width="30" alt="Facebook" style="vertical-align: middle;">
				<span style="color: #400f0f; font-weight: bold; font-size: 14px; margin-left: 5px;">Facebook</span>
			</a>
		</div>
	</div>
</div>

<?php
if (isset($additional_content)) {
	echo wp_kses_post(wpautop(wptexturize($additional_content)));
}

do_action('woocommerce_email_footer', $email);

<?php

/**
 * Customer Completed Order email (Reserva Confirmada)
 */

if (! defined('ABSPATH')) {
    exit;
}

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action('woocommerce_email_header', $email_heading, $email);

$order = $email->object;
$customer_name = $order->get_billing_first_name();
?>

<div style="text-align: center; margin-bottom: 30px;">
    <h2 style="color: #400f0f; font-size: 24px; margin: 0 0 10px 0;">Reserva Confirmada!</h2>
    <p style="font-size: 16px; color: #555;">Olá, <strong><?php echo esc_html($customer_name); ?></strong>. Recebemos seu pagamento e sua vaga está garantida!</p>
</div>

<div style="margin-bottom: 30px; border: 1px solid #eee; border-radius: 8px; padding: 20px;">
    <h3 style="color: #400f0f; font-size: 18px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 0;">Resumo da sua reserva</h3>

    <?php do_action('woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email); ?>
</div>

<div style="background-color: #fcfcfc; border: 1px dashed #400f0f; border-radius: 12px; padding: 25px; margin: 30px 0;">
    <h3 style="text-align: center; color: #400f0f; margin-top: 0; font-size: 18px; text-transform: uppercase;">O que acontece agora?</h3>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 20px;">
        <tr>
            <td style="padding: 10px 0; vertical-align: top; width: 40px;">
                <span style="background: #400f0f; color: #fff; border-radius: 50%; width: 25px; height: 25px; display: block; text-align: center; font-weight: bold; line-height: 25px;">1</span>
            </td>
            <td style="padding: 10px 0; font-size: 14px; color: #444;">
                <strong>Confira o embarque:</strong> Verifique com atenção o horário e o endereço do local de embarque escolhido acima.
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span style="background: #400f0f; color: #fff; border-radius: 50%; width: 25px; height: 25px; display: block; text-align: center; font-weight: bold; line-height: 25px;">2</span>
            </td>
            <td style="padding: 10px 0; font-size: 14px; color: #444;">
                <strong>No dia da excursão:</strong> compareça no local de referência do seu embarque portando documento e a menor quantidade possível de pertences.
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span style="background: #400f0f; color: #fff; border-radius: 50%; width: 25px; height: 25px; display: block; text-align: center; font-weight: bold; line-height: 25px;">3</span>
            </td>
            <td style="padding: 10px 0; font-size: 14px; color: #444;">
                <strong>Grupo do WhatsApp:</strong> É criado 5 dias antes da viagem. Você recebe o link por e-mail e também pode acessar via <em>Minhas Reservas</em>.
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0; vertical-align: top;">
                <span style="background: #400f0f; color: #fff; border-radius: 50%; width: 25px; height: 25px; display: block; text-align: center; font-weight: bold; line-height: 25px;">3</span>
            </td>
            <td style="padding: 10px 0; font-size: 14px; color: #444;">
                <strong>Suporte:</strong> Se precisar alterar o ponto de embarque ou cancelar, utilize o painel do cliente, na página <em>Minhas reservas</em>. Para dúvidas adicionais, contate-nos por e-mail ou WhatsApp.
            </td>
        </tr>
    </table>
</div>

<div style="text-align: center; margin: 40px 0;">
    <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>minhas-reservas"
        style="background-color: #400f0f; color: #ffffff; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; font-size: 16px; display: inline-block;">
        Ver Minhas Reservas
    </a>
</div>

<?php
/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action('woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email);

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action('woocommerce_email_footer', $email);

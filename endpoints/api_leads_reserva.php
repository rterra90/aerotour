<?php
add_action('rest_api_init', function () {
  register_rest_route('aerotour/v1', '/save-lead', array(
    'methods' => WP_REST_SERVER::CREATABLE,
    'callback' => 'handle_save_lead',
    'permission_callback' => '__return_true', // Ajustar para nonce se necessário
  ));
});

function handle_save_lead($request)
{
  global $wpdb;
  $params = $request->get_json_params();
  $table_name = 'aer_reserva_leads';
  // $table_name = $wpdb->prefix . 'aer_reserva_leads';

  // prepara o variation_id do POST
  $variation_ids = isset($params['variation_id']) ? $params['variation_id'] : [];
  if (!is_array($variation_ids)) $variation_ids = array($variation_ids);
  $sanitized_variations = array_map('intval', $variation_ids);

  $sanitized_cpf = preg_replace('/[^0-9]/is', '', $params['cpf']);

  $data = array(
    'variation_id'       => json_encode($sanitized_variations),
    'embarque'     => sanitize_text_field($params['embarque']),
    'passenger_name'     => sanitize_text_field($params['nome_completo']),
    'passenger_cpf'      => $sanitized_cpf,
    'passenger_phone'    => sanitize_text_field($params['celular']),
    'session_id'         => sanitize_text_field($params['session_id']),
    'status'             => 'pendente'
  );

  // O REPLACE INTO garante que se o CPF já existir nessa sessão, ele apenas atualiza os dados
  // $wpdb->replace($table_name, $data);
  if ($wpdb->insert($table_name, $data)) {
    return new WP_REST_Response(array('success' => true, 'dataTeste' => $data['embarque']), 200);
  } else {
    //retornar erro específico do banco de dados
    return new WP_Error('db_error', 'Falha ao salvar lead: ' . $wpdb->last_error, array('status' => 500));
  }
}

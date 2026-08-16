<?php
add_action('rest_api_init', function () {
  register_rest_route('api/v1', '/edit-reserva', array(
    'methods' => WP_REST_SERVER::EDITABLE,
    'callback' => 'handle_edit_reserva',
    'permission_callback' => '__return_true',
  ));
});

function handle_edit_reserva($request){
  global $wpdb;
  $params = $request->get_json_params();
  $solic_edit_table = $wpdb->prefix . 'solic_edit_pax';
  $action_from = $params['action_from'];

  if($action_from === 'user'){
    // prepara os dados de edição recebidos
    $payload = array(
        'novo_nome'     => sanitize_text_field($params['novo_nome']),
        'novo_doc'      => preg_replace('/[^0-9]/', '', sanitize_text_field($params['novo_doc'])),
        'novo_telefone'    => sanitize_text_field($params['novo_telefone']),
        'nova_data_nasc'   => data_to_iso(sanitize_text_field($params['nova_data_nascimento'])),
        'reserva_id'   => sanitize_text_field($params['pax_id']),
        'status' => 'pendente',
        'status_nome' => isset($params['status_nome']) ? 'pendente': 'false',
        'status_doc' => isset($params['status_doc']) ? 'pendente': 'false',
        'status_telefone' => isset($params['status_telefone']) ? 'pendente': 'false',
        'status_data_nasc' => isset($params['status_data_nasc']) ? 'pendente': 'false'
    );

    // Insere os dados de edição na tabela 'solic_edit_pax'
    if($wpdb->insert($solic_edit_table, $payload)) {
        return new WP_REST_Response(array('success' => true, 'message' => 'Solicitação de edição salva com sucesso!'), 200);
    }else{
        return new WP_Error('db_error', 'Falha ao salvar solicitação de edição: ' . $wpdb->last_error, array('status' => 500));
    }   


  } else if ($action_from === 'admin'){
    return new WP_REST_Response(array('success' => true, 'dataTeste' => 'ação do administrador'), 200);

  } else{
    // retornar erro de tipo de usuário não identificado
    return new WP_Error('user_type_error', 'Tipo de usuário não identificado', array('status' => 400));
  }


}


?>
<?php
add_action('rest_api_init', function () {
  register_rest_route('api', '/contrato', array(
    [
      'methods' => WP_REST_SERVER::CREATABLE,
      'callback' => 'aer_salvar_contrato',
      'permission_callback' => '__return_true', // você pode restringir depois
    ]
  ));
});

function aer_salvar_contrato($request) {
  global $wpdb;

  $dados = $request->get_json_params();

  $resultado = $wpdb->insert('aer_contratos_part', [
    'c_tipo' => sanitize_text_field($dados['c_tipo']),
    'c_nome'             => sanitize_text_field($dados['c_nome']),
    'c_doc'         => sanitize_text_field($dados['c_doc']),
    'c_tel1'         => sanitize_text_field($dados['c_tel1']),
    'c_tel2'         => sanitize_text_field($dados['c_tel2']),
    'c_email'            => sanitize_email($dados['c_email']),
    'c_endereco'         => sanitize_text_field($dados['c_endereco']),
    'c_cidade'           => sanitize_text_field($dados['c_cidade']),
    'v_data_saida'       => sanitize_text_field($dados['c_data_saida']),
    'v_hora_saida'       => sanitize_text_field($dados['v_hora_saida']),
    'v_local_saida'      => sanitize_text_field($dados['v_local_saida']),
    'v_destino'          => sanitize_text_field($dados['v_destino']),
    'v_data_retorno'     => sanitize_text_field($dados['v_data_retorno']),
    'v_hora_retorno'     => sanitize_text_field($dados['v_hora_retorno']),
    'created_at'       => current_time('mysql'),
  ]);

  if ($resultado) {
    $novo_id = $wpdb->insert_id;
    return new WP_REST_Response([
      'success' => true,
      'novo_id' => $novo_id
    ], 200);
  } else {
    return new WP_REST_Response([
      'success' => false,
      'message' => 'Erro ao inserir contrato.'
    ], 500);
  }

}
?>
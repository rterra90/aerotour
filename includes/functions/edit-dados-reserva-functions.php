<?php
// 1. Processar Ação em um Único Campo
add_action('wp_ajax_avaliar_edit_reserva', 'processar_avaliar_edit_reserva');
function processar_avaliar_edit_reserva(){
  // Executa validações de nonce e permissões
  check_ajax_referer('avaliar_edit_reserva_nonce', 'nonce');
  if (!current_user_can('manage_options')) {
        wp_send_json_error('Sem permissão.');
    }

  global $wpdb;

  // Obtém os dados enviados na chamada
  $solic_id = intval($_POST['solicitacao_id']);
  $campo = sanitize_text_field($_POST['campo']);
  $acao = sanitize_text_field($_POST['acao']);
  $valor_original = sanitize_text_field($_POST['valor_original']);

  // Mapeamento de colunas da tabela de solicitações x tabela de reservas
    $mapa_colunas = [
        'nome'         => ['solic' => 'novo_nome', 'reserva' => 'p_nome', 'campo_status' => 'status_nome'],
        'doc'          => ['solic' => 'novo_doc', 'reserva' => 'p_cpf', 'campo_status' => 'status_doc'],
        'telefone'     => ['solic' => 'novo_telefone', 'reserva' => ' p_telefone', 'campo_status' => 'status_telefone'],
        'data_nasc'    => ['solic' => 'nova_data_nasc', 'reserva' => 'data_nasc', 'campo_status' => 'status_data_nasc'],
    ];

    if (!isset($mapa_colunas[$campo])) {
        wp_send_json_error('Campo inválido.');
    }


    $cols = $mapa_colunas[$campo];

    // Obtém a solicitação no banco de dados
    $solicitacoes_table = $wpdb->prefix . 'solic_edit_pax';
    $solicitacao = $wpdb->get_row($wpdb->prepare("SELECT * FROM $solicitacoes_table WHERE id = %d", $solic_id));

    if (!$solicitacao) {
        wp_send_json_error('Solicitação não encontrada.');
    }


    $novo_status = ($acao === 'aceitar') ? 'aprovado' : 'rejeitado';


    // Se a ação for ACEITAR, atualiza o registro na tabela reservas
    $reservas_table = $wpdb->prefix . 'reservas';
    if ($acao === 'aceitar') {
        $novo_valor = $solicitacao->{$cols['solic']};

        $wpdb->query("UPDATE $reservas_table SET {$cols['reserva']} = '$novo_valor' WHERE ID = $solicitacao->reserva_id");
    }

    // Atualiza o status do campo na tabela de solicitações
    $wpdb->update(
        $solicitacoes_table,
        [$cols['campo_status'] => $novo_status],
        ['id' => $solic_id]
    );

    // Verifica se todos os campos já foram avaliados para fechar a solicitação geral
    checar_e_fechar_solicitation_geral($solic_id);
    // wp_send_json_success(checar_e_fechar_solicitation_geral($solic_id));

    wp_send_json_success([
        'novo_valor'     => $solicitacao->{$cols['solic']},
        'valor_original' => $valor_original,
        'novo_status_campo'    => $novo_status,
        'novo_status_solic'    => checar_e_fechar_solicitation_geral($solic_id) ? 'concluido' : 'pendente'
    ]);

}

// 2. Processar "Aceitar Tudo" ou "Rejeitar Tudo" na Linha
add_action('wp_ajax_processar_alteracao_tudo', 'ajax_processar_alteracao_tudo');
function ajax_processar_alteracao_tudo() {
    check_ajax_referer('avaliar_edit_reserva_nonce', 'nonce');

    if (!current_user_can('manage_options')) {
        wp_send_json_error('Sem permissão.');
    }

    global $wpdb;
    $solic_id = intval($_POST['solic_id']);
    $acao            = sanitize_text_field($_POST['acao']); // 'aceitar' ou 'rejeitar'

    $solicitacoes_table = $wpdb->prefix . 'solic_edit_pax';
    $solicitation = $wpdb->get_row($wpdb->prepare("SELECT * FROM $solicitacoes_table WHERE id = %d", $solic_id));

    if (!$solicitation) {
        wp_send_json_error('Solicitação não encontrada.');
    }

    $update_reserva = [];

    // Mapeamento de dados
    $campos = [
        'status_nome'      => ['p_nome', 'novo_nome'],
        'status_doc'       => ['p_cpf',           'novo_doc'],
        'status_telefone'  => ['p_telefone',       'novo_telefone'],
        'status_data_nasc' => ['data_nasc',     'nova_data_nasc'],
    ];
    foreach ($campos as $statusAttr => [$chaveReserva, $propSolicitation]) {
        if ($solicitation->$statusAttr === 'pendente') {
            $update_reserva[$chaveReserva] = $solicitation->$propSolicitation;
        } 
    }

    foreach($update_reserva as $campo => $valor) {
        // Atualiza o status do campo na tabela de solicitações
        $statusAttr = '';
        if($campo === 'p_nome') $statusAttr = 'status_nome';
        else if($campo === 'p_cpf') $statusAttr = 'status_doc';
        else if($campo === 'p_telefone') $statusAttr = 'status_telefone';
        else if($campo === 'data_nasc') $statusAttr = 'status_data_nasc';

          if ($statusAttr !== false) {
            $wpdb->update(
                $solicitacoes_table,
                [$statusAttr => $acao === 'aceitar' ? 'aprovado' : 'rejeitado'],
                ['id' => $solic_id]
            );
        }

        // Atualiza os novos valores na tabela reservas
        $reservas_table = $wpdb->prefix . 'reservas'; 
        $wpdb->update(
            $reservas_table,
            [$campo => $valor],
            ['ID' => $solicitation->reserva_id]
        );
    }

    $wpdb->update(
        $solicitacoes_table,
        ['status' => $acao === 'concluido'],
        ['id' => $solic_id]
    );

    wp_send_json_success($update_reserva);
}

// Função auxiliar para verificar se todas solicitações estão concluídas
function checar_e_fechar_solicitation_geral($solic_id) {
  global $wpdb;

  $solicitacoes_table = $wpdb->prefix . 'solic_edit_pax';
  $s = $wpdb->get_row($wpdb->prepare("SELECT * FROM $solicitacoes_table WHERE id = %d", $solic_id));

  if ($s->status_nome !== 'pendente' && 
      $s->status_doc !== 'pendente' && 
      $s->status_telefone !== 'pendente' && 
      $s->status_data_nasc !== 'pendente') {

      $wpdb->query(
        $wpdb->prepare(
            "UPDATE $solicitacoes_table SET status = 'concluido' WHERE id = %d",
            $solic_id
        )
      );
      
      return true;
  }

  return false;
}

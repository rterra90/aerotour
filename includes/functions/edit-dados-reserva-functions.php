<?php

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

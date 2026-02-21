<?php
// RECEBE E PROCESSA PEDIDO DE CANCELAMENTO PELO CLIENTE
add_action('wp_ajax_solicitar_cancelamento_reserva', 'processar_solicitacao_cancelamento');
function processar_solicitacao_cancelamento()
{
  global $wpdb;

  // Sanitização básica
  $order_id     = intval($_POST['order_id']);
  $variation_id = intval($_POST['variation_id']);
  $user_id      = get_current_user_id();

  // Recebe a array de IDs (ex: ['1234', '1235'])
  $passageiros_ids = isset($_POST['passageiros']) ? $_POST['passageiros'] : [];

  if (empty($passageiros_ids)) {
    wp_send_json_error("Nenhum passageiro selecionado.");
  }
  $wpdb->query('START TRANSACTION');

  try {
    // 1. Inserir na tabela de cancelamentos para histórico e gestão admin
    $ins_cancel = $wpdb->insert('aer_cancelamentos', [
      'order_id'         => $order_id,
      'user_id'          => $user_id,
      'variation_id'     => $variation_id,
      'passageiros'      => json_encode($passageiros_ids), // Armazena os IDs
      'status'           => 'pendente'
    ]);

    if (!$ins_cancel) throw new Exception("Falha ao registrar solicitação.");

    // 2. Atualizar o status de cada reserva específica para 'pending_cancel'
    foreach ($passageiros_ids as $reserva_id) {
      $update = $wpdb->update(
        'aer_reservas',
        ['status' => 'pending_cancel'],
        ['id' => intval($reserva_id), 'order_id' => $order_id]
      );
      if ($update === false) throw new Exception("Erro ao atualizar reserva ID: $reserva_id");
    }

    $wpdb->query('COMMIT');

    // 3. Notificação por E-mail
    $to = get_option('admin_email');
    $subject = "⚠️ Pedido de Cancelamento - Pedido #$order_id";
    $message = "Uma nova solicitação de cancelamento foi aberta para $order_id.\n";
    $message .= "IDs das reservas: " . implode(', ', $passageiros_ids) . "\n";

    $sent = wp_mail($to, $subject, $message);
    if ($sent) wp_send_json_success('Enviou email com sucesso');
    else wp_send_json_error('Falha ao enviar o e-mail');
  } catch (Exception $e) {
    $wpdb->query('ROLLBACK');
    wp_send_json_error($e->getMessage());
  }
}

// FUNÇÕES DO PAINEL ADMINISTRATIVO DE CANCELAMENTOS
add_action('wp_ajax_processar_cancelamento_admin', 'processar_cancelamento_admin');
function processar_cancelamento_admin()
{
  global $wpdb;

  $id = intval($_POST['id']);
  $acao = sanitize_text_field($_POST['acao']);
  $novo_status_solicitacao = ($acao === 'aprovar') ? 'aprovado' : 'rejeitado';
  $novo_status_reserva = ($acao === 'aprovar') ? 'cancel' : 'normal';

  // 1. Busca a solicitação para saber quais passageiros afetar
  $solicitacao = $wpdb->get_row($wpdb->prepare("SELECT * FROM `aer_cancelamentos` WHERE id = %d", $id));

  if (!$solicitacao) wp_send_json_error("Solicitação não encontrada.");

  $ids_passageiros = json_decode($solicitacao->passageiros, true);

  // 2. Atualiza a tabela de cancelamentos
  $wpdb->update('aer_cancelamentos', ['status' => $novo_status_solicitacao], ['id' => $id]);

  // 3. Atualiza os passageiros na aer_reservas de volta para o status final
  foreach ($ids_passageiros as $reserva_id) {
    $wpdb->update(
      'aer_reservas',
      ['status' => $novo_status_reserva],
      ['id' => $reserva_id]
    );
  }

  wp_send_json_success();
}

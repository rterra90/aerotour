<?php
function cancelamentos_admin_page()
{
  global $wpdb;

  // 1. Busca todas as solicitações
  $solicitacoes = $wpdb->get_results("SELECT * FROM `aer_cancelamentos` ORDER BY data_solic DESC", ARRAY_A);

?>
  <div class="wrap">
    <h1 class="wp-heading-inline">Gerenciamento de Cancelamentos</h1>
    <p class="description">Analise e processe as solicitações de cancelamento enviadas pelos usuários.</p>

    <style>
      .column-status .badge-admin {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
      }

      .badge-pendente {
        background: #fcf0f1;
        color: #d63638;
        border: 1px solid #d63638;
      }

      .badge-aprovado {
        background: #edfaef;
        color: #008a20;
        border: 1px solid #008a20;
      }

      .badge-rejeitado {
        background: #f0f0f1;
        color: #50575e;
        border: 1px solid #c3c4c7;
      }

      .passenger-tag {
        display: inline-block;
        background: #f0f6fc;
        border: 1px solid #d2e3f7;
        color: #1d2327;
        padding: 2px 5px;
        border-radius: 4px;
        font-size: 11px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 124px;
        cursor: default;
      }

      .row-actions {
        margin-top: 8px;
      }
    </style>

    <table class="wp-list-table widefat fixed striped table-view-list mt-3">
      <thead>
        <tr>
          <th style="width: 70px;">Pedido</th>
          <th style="width: 120px;">Data/Hora</th>
          <th>Cliente (Dono)</th>
          <th>Excursão</th>
          <th>Passageiros Solicitados</th>
          <th>Motivo do Usuário</th>
          <th style="width: 130px;">Status</th>
          <th style="width: 160px;">Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($solicitacoes)) : ?>
          <tr>
            <td colspan="8">Nenhuma solicitação encontrada.</td>
          </tr>
          <?php else :
          foreach ($solicitacoes as $s) :
            $user = get_userdata($s['user_id']);
            $produto = wc_get_product($s['variation_id']);
            $ids_passageiros = json_decode($s['passageiros'], true);

            // OTIMIZAÇÃO: Busca os nomes dos passageiros em uma única query
            $nomes_passageiros = [];
            if (!empty($ids_passageiros)) {
              $placeholders = implode(',', array_fill(0, count($ids_passageiros), '%d'));
              $query = $wpdb->prepare("SELECT p_nome FROM `aer_reservas` WHERE id IN ($placeholders)", $ids_passageiros);
              $nomes_passageiros = $wpdb->get_col($query);
            }
          ?>
            <tr>
              <td><strong>#<?= $s['order_id']; ?></strong></td>
              <td>
                <span class="dashicons dashicons-calendar-alt" style="font-size:14px; vertical-align:middle;"></span>
                <?= date('d/m/y H:i', strtotime($s['data_solic'])); ?>
              </td>
              <td>
                <strong><?= $user ? $user->display_name : 'N/A'; ?></strong><br>
                <small class="description"><?= $user ? $user->user_email : ''; ?></small>
              </td>
              <td>
                <?php
                if ($produto) {
                ?>
                  <span style="dislpay: block"><?= substr($produto->get_name(), 0, -13); ?></span>
                  <span style="dislpay: block"><?= substr($produto->get_name(), -10); ?></span>
                <?php
                } else { ?> Produto Indisponível <?php } ?>
              </td>
              <td>
                <?php foreach ($nomes_passageiros as $nome): ?>
                  <span class="passenger-tag"><?= esc_html($nome); ?></span>
                <?php endforeach; ?>
              </td>
              <td>
                <div style="max-height: 60px; overflow-y: auto; font-style: italic; color: #646970;">
                  <?= $s['motivo'] ? '"' . esc_html($s['motivo']) . '"' : '—'; ?>
                </div>
              </td>
              <td class="column-status">
                <?php
                $status_class = 'badge-' . $s['status'];
                echo "<span class='badge-admin {$status_class}'>" . strtoupper($s['status']) . "</span>";
                ?>
              </td>
              <td>
                <?php if ($s['status'] === 'pendente') : ?>
                  <div class="row-actions">
                    <button class="button button-primary btn-processar"
                      data-id="<?= $s['ID']; ?>"
                      data-acao="aprovar"
                      style="background: #008a20; border-color: #008a20;">Aprovar</button>

                    <button class="button button-link-delete btn-processar"
                      data-id="<?= $s['ID']; ?>"
                      data-acao="rejeitar"
                      style="color: #d63638;">Recusar</button>
                  </div>
                <?php else : ?>
                  <span class="description">
                    <span class="dashicons dashicons-lock" style="font-size:16px;"></span>
                    Finalizado
                  </span>
                <?php endif; ?>
              </td>
            </tr>
        <?php endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
  <script>
    jQuery(document).ready(function($) {
      $('.btn-processar').on('click', function(e) {
        e.preventDefault(); // Garante que não haja comportamento padrão

        if (!confirm('Deseja realmente processar esta solicitação?')) return;

        const btn = $(this);
        const solicitacaoId = btn.data('id');
        const acaoSolicitada = btn.data('acao');

        // Log de depuração para o console
        console.log('Iniciando POST para:', themeLinks.ajaxUrl);
        console.log('Dados:', {
          id: solicitacaoId,
          acao: acaoSolicitada
        });

        // Bloqueia o botão
        btn.prop('disabled', true).text('Processando...');

        // Usamos a estrutura completa do $.ajax para ter mais controle e capturar erros de rede
        $.ajax({
          url: themeLinks.ajaxUrl,
          type: 'POST',
          data: {
            action: 'processar_cancelamento_admin',
            id: solicitacaoId,
            acao: acaoSolicitada
          },
          success: function(res) {
            console.log('Resposta recebida:', res);
            if (res.success) {
              location.reload();
            } else {
              alert('Erro no processamento: ' + (res.data || 'Erro desconhecido'));
              btn.prop('disabled', false).text('Tentar novamente');
            }
          },
          error: function(xhr, status, error) {
            console.error('Falha crítica na chamada AJAX:', status, error);
            console.log('Resposta do servidor:', xhr.responseText);
            alert('Falha na comunicação com o servidor. Verifique o console.');
            btn.prop('disabled', false).text('Erro de Conexão');
          }
        });
      });
    });
  </script>
<?php
}
?>
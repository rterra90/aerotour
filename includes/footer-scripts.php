<?php

/**
 * Injeta o Modal do Bootstrap em produtos antigos que possuem uma versão mais recente
 */
add_action('wp_footer', 'gerar_modal_bootstrap_excursao_atual');
function gerar_modal_bootstrap_excursao_atual()
{
  // 1. Verifica se é uma página de produto
  if (! is_product()) return;

  // 2. Busca o ID da excursão mais recente gravado neste produto
  $novo_evento_id = get_post_meta(get_the_ID(), 'more_recent_event_id', true);

  // 3. Se existir um vínculo, montamos o modal
  if ($novo_evento_id) {
    $data_limite = get_post_meta($novo_evento_id, 'data_limite_excursao', true);
    $hoje = date('Ymd');

    // Se o evento novo já passou (data_limite < hoje), interrompemos a função aqui
    if ($data_limite && $data_limite < $hoje) return;

    $link_novo = get_permalink($novo_evento_id);
    $nome_novo = get_the_title($novo_evento_id);
    $modal_id = 'modal_excursao_atual_' . $novo_evento_id;
?>

    <div class="modal fade" id="<?php echo $modal_id; ?>" tabindex="-1" aria-labelledby="label_<?php echo $modal_id; ?>" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="label_<?php echo $modal_id; ?>">⚠️ Excursão Encerrada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <p>Esta página é de uma excursão que já aconteceu.</p>
            <p><strong>A boa notícia é que já temos uma nova excursão confirmada para:</strong><br>
              <span style="font-size: 1.2em; font-weight: bold;"><?php echo esc_html($nome_novo); ?></span>
            </p>
          </div>
          <div class="modal-footer" style="justify-content: center;">
            <a href="<?php echo esc_url($link_novo); ?>" class="btn btn-primary" style="background-color: var(--aer-accent); border: none">Ver Excursão Atual</a>
          </div>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Inicializa o modal do Bootstrap (garantindo que o objeto bootstrap exista)
        setTimeout(function() {
          var myModal = new bootstrap.Modal(document.getElementById('<?php echo $modal_id; ?>'));
          myModal.show();
        }, 1000);
      });
    </script>

<?php
  }
}

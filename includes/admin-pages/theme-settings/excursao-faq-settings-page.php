<?php
add_action('admin_init', function () {
  register_setting('opt_excursao_faq', 'grupos_faq', [
    'sanitize_callback' => 'sanitize_faq_groups'
  ]);
  register_setting('opt_excursao_faq', 'faq_padrao');
});

function render_excursao_faq_settings_page()
{
  $grupos_faq = get_option('grupos_faq', []);
  $faq_padrao = get_option('faq_padrao', '');

  // Lista de ícones sugeridos (Travel & Support)
  $icons_sugeridos = ['dashicons-view', 'dashicons-info', 'dashicons-location', 'dashicons-clock', 'dashicons-tickets-alt', 'dashicons-shield', 'dashicons-warning', 'dashicons-money-alt'];
?>
  <div class="wrap theme-settings-wrapper">
    <?php render_settings_header('excursao-faq'); ?>

    <div class="settings-page-content">
      <div class="content-header flex">
        <?php $parent_url = menu_page_url('config-excursao', false); ?>
        <div>
          <h2><a href="<?= $parent_url; ?>">Excursão</a> > Principais Dúvidas (FAQ)</h2>
          <p class="description">Crie conjuntos de perguntas e respostas frequentes. Marque a estrela para definir o FAQ padrão.</p>
        </div>
        <div>
          <button type="button" id="add-novo-faq" class="button button-primary large"> + Criar Novo Set de FAQ </button>
        </div>

      </div>

      <form method="post" action="options.php" id="aerotour-faq-form">
        <?php settings_fields('opt_excursao_faq'); ?>
        <input type="hidden" name="faq_padrao" id="input_faq_padrao" value="<?php echo esc_attr($faq_padrao); ?>">

        <div id="container-faq">
          <?php if (!empty($grupos_faq)) : foreach ($grupos_faq as $id_grupo => $grupo_faq) :
              $count = isset($grupo_faq['itens']) ? count($grupo_faq['itens']) : 0;
              $is_default = ($id_grupo === $faq_padrao);
          ?>
              <div class="grupo-card collapsed" data-id="<?php echo esc_attr($id_grupo); ?>">
                <div class="grupo-header">
                  <div class="header-left toggle-accordion">
                    <span class="dashicons dashicons-arrow-right-alt2 toggle-icon"></span>
                    <button type="button" class="set-default-btn <?php echo $is_default ? 'is-default' : ''; ?>" onClick="event.stopPropagation(); window.setFaqDefault('<?php echo $id_grupo; ?>', this);">
                      <span class="dashicons dashicons-star-filled"></span>
                    </button>
                    <input type="text" name="grupos_faq[<?php echo $id_grupo; ?>][titulo]" value="<?php echo esc_attr($grupo_faq['titulo']); ?>" class="titulo-grupo" onClick="event.stopPropagation();" />
                    <span class="pax-counter"><?php echo $count; ?> perguntas</span>
                  </div>
                  <div class="header-right">
                    <button type="button" class="button button-small duplicate-faq">Duplicar</button>
                    <button type="button" class="button-remove remove-grupo">Excluir</button>
                  </div>
                </div>

                <div class="grupo-body">
                  <div class="faq-item-grid sortable-faq">
                    <?php if (!empty($grupo_faq['itens'])) : foreach ($grupo_faq['itens'] as $item) : ?>
                        <div class="faq-item-card">
                          <div class="card-handle"><span class="dashicons dashicons-menu"></span></div>
                          <div class="faq-fields">
                            <div class="faq-row-top">
                              <div class="icon-selector">
                                <span class="dashicons <?php echo esc_attr($item['icone']); ?> preview-icon"></span>
                                <input type="hidden" value="<?php echo esc_attr($item['icone']); ?>" class="icon-input" />
                                <div class="icon-dropdown">
                                  <?php foreach ($icons_sugeridos as $ic): ?>
                                    <span class="dashicons <?php echo $ic; ?>" data-icon="<?php echo $ic; ?>"></span>
                                  <?php endforeach; ?>
                                </div>
                              </div>
                              <input type="text" name="grupos_faq[<?php echo $id_grupo; ?>][itens][pergunta][]" value="<?php echo esc_attr($item['pergunta']); ?>" placeholder="Pergunta..." class="faq-pergunta" />
                            </div>
                            <textarea name="grupos_faq[<?php echo $id_grupo; ?>][itens][resposta][]" placeholder="Resposta..." rows="2"><?php echo esc_textarea($item['resposta']); ?></textarea>
                          </div>
                          <button type="button" class="button-remove remove-row"><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    <?php endforeach;
                    endif; ?>
                  </div>
                  <button type="button" class="button button-secondary add-faq-item"> + Adicionar Pergunta </button>
                </div>
              </div>
            <?php endforeach;
          else: ?>
            <div class="settings-empty-placeholder faq">
              <span class="dashicons dashicons-editor-help"></span>
              <h4>Seu Gerenciador de FAQ está vazio</h4>
              <p>Crie grupos de perguntas e respostas para automatizar o suporte das suas viagens e eventos.</p>
            </div>

          <?php
          endif; ?>
        </div>

        <div class="form-footer"><?php submit_button('Salvar Todos os FAQs'); ?></div>
      </form>
    </div>
  </div>

  <style>
    /* Estilos Específicos do FAQ */
    .faq-item-card {
      display: flex;
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      margin-bottom: 12px;
      padding: 15px;
      gap: 10px;
    }

    .faq-fields {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .faq-row-top {
      display: flex;
      gap: 10px;
      align-items: center;
    }

    /* Seletor de Ícones */
    .icon-selector {
      position: relative;
      width: 40px;
      height: 40px;
      border: 1px solid #ddd;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      background: #f8f9fa;
      display: none;
    }

    .preview-icon {
      font-size: 20px;
      color: #dc3545;
    }

    .icon-dropdown {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      background: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 10;
      width: 160px;
      padding: 5px;
      grid-template-columns: repeat(4, 1fr);
      gap: 5px;
    }

    .icon-selector:hover .icon-dropdown {
      display: grid;
    }

    .icon-dropdown span {
      padding: 5px;
      border-radius: 4px;
      transition: background 0.2s;
    }

    .icon-dropdown span:hover {
      background: #f0f0f0;
      color: #dc3545;
    }

    .faq-pergunta {
      flex-grow: 1;
      font-weight: 600 !important;
      border: none !important;
      border-bottom: 1px solid #eee !important;
      box-shadow: none !important;
    }

    textarea {
      width: 100%;
      border: 1px solid #eee !important;
      resize: vertical;
      font-size: 13px;
      padding: 8px;
    }

    /* Reutiliza os estilos de estrela e accordion do "Como Funciona" */
    .set-default-btn.is-default {
      color: #ffb900;
    }
  </style>

  <script>
    jQuery(document).ready(function($) {
      const uniqueId = () => 'faq_' + Math.random().toString(36).substr(2, 9);

      // Seleção de Ícone
      $(document).on('click', '.icon-dropdown span', function() {
        const icon = $(this).data('icon');
        const $selector = $(this).closest('.icon-selector');
        $selector.find('.preview-icon').attr('class', 'dashicons ' + icon + ' preview-icon');
        $selector.find('.icon-input').val(icon);
      });

      // Set Padrão
      window.setFaqDefault = function(id, btn) {
        $('#input_faq_padrao').val(id);
        $('.set-default-btn').removeClass('is-default');
        $(btn).addClass('is-default');
      };

      // Adicionar Item de FAQ
      $(document).on('click', '.add-faq-item', function() {
        const $grupo = $(this).closest('.grupo-card');
        const gid = $grupo.data('id');
        const itemHtml = `
                  <div class="faq-item-card">
                      <div class="card-handle"><span class="dashicons dashicons-menu"></span></div>
                      <div class="faq-fields">
                          <div class="faq-row-top">
                              <div class="icon-selector">
                                  <span class="dashicons dashicons-info preview-icon"></span>
                                  <input type="hidden" name="grupos_faq[${gid}][itens][icone][]" value="dashicons-info" class="icon-input" />
                                  <div class="icon-dropdown">
                                      <?php foreach ($icons_sugeridos as $ic): ?><span class="dashicons <?php echo $ic; ?>" data-icon="<?php echo $ic; ?>"></span><?php endforeach; ?>
                                  </div>
                              </div>
                              <input type="text" name="grupos_faq[${gid}][itens][pergunta][]" value="" placeholder="Pergunta..." class="faq-pergunta" />
                          </div>
                          <textarea name="grupos_faq[${gid}][itens][resposta][]" placeholder="Resposta..." rows="2"></textarea>
                      </div>
                      <button type="button" class="button-remove remove-row"><span class="dashicons dashicons-trash"></span></button>
                  </div>`;
        $grupo.find('.faq-item-grid').append(itemHtml);
      });

      // Remover Grupo de FAQ inteiro
      $(document).on('click', '.remove-grupo', function() {
        if (confirm('Tem certeza que deseja excluir este conjunto de FAQ?')) {
          $(this).closest('.grupo-card').remove();

          // Mostra o placeholder se o tamanho for 0, esconde se for maior que 0
          $('.settings-empty-placeholder').toggle($("#container-faq .grupo-card").length === 0);
        }
      });

      // Duplicar Grupo de FAQ
      $(document).on('click', '.duplicate-faq', function() {
        const $card = $(this).closest('.grupo-card');
        const $clone = $card.clone();
        const newId = uniqueId();

        // Atualiza o ID do data-attribute e remove classe de colapso para visualização
        $clone.attr('data-id', newId).removeClass('collapsed');

        // Atualiza os nomes dos inputs para o novo ID
        $clone.find('input, textarea').each(function() {
          const name = $(this).attr('name');
          if (name) {
            $(this).attr('name', name.replace(/grupos_faq\[.*?\]/, `grupos_faq[${newId}]`));
          }
        });

        // Reseta o estado de "Padrão" na cópia
        $clone.find('.set-default-btn').removeClass('is-default')
          .attr('onClick', `event.stopPropagation(); window.setFaqDefault('${newId}', this);`);

        // Adiciona o clone após o card original
        $card.after($clone);

        // Reinicializa o sortable na nova lista de itens
        $('.sortable-faq').sortable({
          handle: '.card-handle',
          axis: 'y'
        });
      });

      // Toggle Accordion e Remover (Mesma lógica do anterior)
      $(document).on('click', '.toggle-accordion', function() {
        $(this).closest('.grupo-card').toggleClass('collapsed');
      });
      $(document).on('click', '.remove-row', function() {
        $(this).closest('.faq-item-card').remove();
      });

      // Adicionar Novo Set de FAQ
      $('#add-novo-faq').on('click', function() {
        const id = uniqueId();
        const html = `
                  <div class="grupo-card" data-id="${id}">
                      <div class="grupo-header">
                          <div class="header-left toggle-accordion">
                              <span class="dashicons dashicons-arrow-right-alt2 toggle-icon"></span>
                              <button type="button" class="set-default-btn" onClick="event.stopPropagation(); window.setFaqDefault('${id}', this);"><span class="dashicons dashicons-star-filled"></span></button>
                              <input type="text" name="grupos_faq[${id}][titulo]" placeholder="Nome do Set (ex: FAQ Rio de Janeiro)" class="titulo-grupo" />
                          </div>
                          <div class="header-right"><button type="button" class="button-remove remove-grupo">Excluir</button></div>
                      </div>
                      <div class="grupo-body">
                          <div class="faq-item-grid sortable-faq"></div>
                          <button type="button" class="button button-secondary add-faq-item"> + Adicionar Pergunta </button>
                      </div>
                  </div>`;
        $('#container-faq').append(html);
        $('.settings-empty-placeholder')[0].style.display = 'none';
      });

      function initSortable() {
        $('.sortable-faq').sortable({
          handle: '.card-handle',
          axis: 'y'
        });
      }
      initSortable();

    });
  </script>
<?php

}


/**
 * Organiza a estrutura do FAQ de "colunas" para "linhas"
 */
function sanitize_faq_groups($input)
{
  if (!is_array($input)) return $input;

  foreach ($input as $id_grupo => $dados) {
    $novo_itens = [];

    // Verifica se existem itens e se a estrutura está no formato de colunas (conforme o problema relatado)
    if (isset($dados['itens']) && is_array($dados['itens']) && isset($dados['itens']['pergunta'])) {

      $total_itens = count($dados['itens']['pergunta']);

      for ($i = 0; $i < $total_itens; $i++) {
        // Só adiciona se a pergunta não estiver vazia
        if (!empty($dados['itens']['pergunta'][$i])) {
          $novo_itens[] = [
            'icone'    => isset($dados['itens']['icone'][$i]) ? sanitize_text_field($dados['itens']['icone'][$i]) : 'dashicons-info',
            'pergunta' => sanitize_text_field($dados['itens']['pergunta'][$i]),
            'resposta' => sanitize_textarea_field($dados['itens']['resposta'][$i]),
          ];
        }
      }
    }
    $input[$id_grupo]['itens'] = $novo_itens;
  }

  return $input;
}

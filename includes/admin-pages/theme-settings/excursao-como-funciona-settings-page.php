<?php

add_action('admin_init', function () {
  register_setting('opt_excursao_como_funciona', 'como_funciona_sets', [
    'sanitize_callback' => 'sanitize_como_funciona'
  ]);
  register_setting('opt_excursao_como_funciona', 'como_funciona_set_padrao');
});

add_action('admin_enqueue_scripts', function ($hook) {
  wp_enqueue_media();
});

/**
 * Renderiza a página de personalização da excursão
 */
function render_excursao_como_funciona_settings_page()
{
  // Agora pegamos os grupos (se não existir, inicia array vazio)
  $grupos_instrucoes = get_option('como_funciona_sets', []);
  $set_padrao = get_option('como_funciona_set_padrao', ''); // Armazena o ID do set padrão
?>
  <div class="wrap theme-settings-wrapper">
    <?php render_settings_header('excursao-como-funciona'); ?>

    <div class="settings-page-content">
      <div class="content-header flex">
        <?php $parent_url = menu_page_url('config-excursao', false); ?>
        <div>
          <h2><a href="<?= $parent_url; ?>">Excursão</a> > Como funciona</h2>
          <p class="description">Crie conjuntos de instruções sobre o funcionamento das excursões. Marque a estrela para definir o conjunto padrão.</p>
        </div>
        <div>
          <button type="button" id="add-novo-grupo" class="button button-primary large"> + Criar novo grupo de instruções </button>
        </div>
      </div>


      <form method="post" action="options.php" id="como-funciona-sets-form">
        <?php settings_fields('opt_excursao_como_funciona'); ?>
        <input type="hidden" name="como_funciona_set_padrao" id="input_set_padrao" value="<?php echo esc_attr($set_padrao); ?>">

        <div id="container-grupos">
          <?php if (!empty($grupos_instrucoes)) : foreach ($grupos_instrucoes as $id_grupo => $dados) :
              $count = isset($dados['frases']) ? count($dados['frases']) : 0;
          ?>
              <div class="grupo-card collapsed" data-id="<?php echo esc_attr($id_grupo); ?>">
                <div class="grupo-header">
                  <div class="header-left toggle-accordion">
                    <span class="dashicons dashicons-arrow-right-alt2 toggle-icon"></span>
                    <button type="button" class="set-default-btn <?php echo ($id_grupo === $set_padrao) ? 'is-default' : ''; ?>" onClick="event.stopPropagation(); window.setAsDefault('<?php echo $id_grupo; ?>', this);">
                      <span class="dashicons dashicons-star-filled"></span>
                    </button>
                    <input type="text" name="como_funciona_sets[<?php echo $id_grupo; ?>][titulo]" value="<?php echo esc_attr($dados['titulo']); ?>" class="titulo-grupo" onClick="event.stopPropagation();" />
                    <span class="pax-counter"><?php echo $count; ?> informações</span>
                  </div>
                  <div class="header-right">
                    <button type="button" class="button button-small duplicate-grupo">Duplicar</button>
                    <button type="button" class="button-remove remove-grupo">Excluir Set</button>
                  </div>
                </div>

                <div class="grupo-body">
                  <div class="instruction-grid sortable-instrucoes">
                    <?php if (!empty($dados['frases'])) : foreach ($dados['frases'] as $f) :
                        // Normaliza dados caso ainda existam frases no formato antigo (string)
                        $f = is_array($f) ? $f : ['texto' => $f, 'is_destaque' => '0', 'texto_secundario' => '', 'icone' => ''];
                        $is_destaque = ($f['is_destaque'] === '1');
                    ?>
                        <div class="instruction-card <?php echo $is_destaque ? 'has-highlight' : ''; ?>">
                          <div class="card-handle"><span class="dashicons dashicons-menu"></span></div>
                          <div class="card-content">
                            <div class="row-principal">
                              <input type="text" name="como_funciona_sets[<?php echo $id_grupo; ?>][frases][texto][]" value="<?php echo esc_attr($f['texto']); ?>" placeholder="Instrução principal..." />

                              <div class="card-actions">
                                <button type="button" class="btn-highlight <?php echo $is_destaque ? 'active' : ''; ?>" title="Tornar Destaque">
                                  <span class="dashicons dashicons-awards"></span>
                                  <input type="checkbox" name="como_funciona_sets[<?php echo $id_grupo; ?>][frases][is_destaque][]" value="1" <?php checked($is_destaque); ?> style="display:none;">
                                </button>
                                <button type="button" class="button-remove remove-row"><span class="dashicons dashicons-trash"></span></button>
                              </div>
                            </div>

                            <div class="row-extra" <?php echo $is_destaque ? '' : 'style="display:none;"'; ?>>
                              <input type="text" name="como_funciona_sets[<?php echo $id_grupo; ?>][frases][texto_secundario][]" value="<?php echo esc_attr($f['texto_secundario']); ?>" placeholder="Texto secundário / descrição..." />
                              <div class="media-upload-wrapper">
                                <input type="hidden" name="como_funciona_sets[<?php echo $id_grupo; ?>][frases][icone][]" class="icone-url" value="<?php echo esc_attr($f['icone']); ?>" />
                                <div class="media-actions" style="display: flex; gap: 5px; align-items: center;">
                                  <button type="button" class="button select-media-btn">Selecionar Ícone</button>
                                  <button type="button" class="button-link custom-remove-media" style="color: #a00; text-decoration: none; <?php echo empty($f['icone']) ? 'display:none;' : ''; ?>">
                                    Remover
                                  </button>
                                </div>

                                <div class="icone-preview" style="margin-top:5px; max-width:30px;">
                                  <?php if (!empty($f['icone'])) : ?>
                                    <img src="<?php echo esc_url($f['icone']); ?>" style="width:100%; height:auto; display:block;">
                                  <?php endif; ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    <?php endforeach;
                    endif; ?>
                  </div>
                  <button type="button" class="button button-secondary add-frase"> + Adicionar Frase </button>
                </div>
              </div>
            <?php endforeach;
          else: ?>
            <div class="settings-empty-placeholder como-funciona">
              <span class="dashicons dashicons-format-aside"></span>
              <h4>Nenhum set de orientações encontrado</h4>
              <p>Organize as instruções da sua excursão em grupos. Comece criando o seu primeiro conjunto no botão abaixo.</p>
            </div>

          <?php
          endif; ?>
        </div>

        <div class="form-footer"><?php submit_button('Salvar Alterações'); ?></div>
      </form>
    </div>
  </div>

  <style>
    /* Grid de Instruções */
    .instruction-grid {
      margin-bottom: 20px;
    }

    .instruction-card {
      display: flex;
      align-items: center;
      background: #fdfdfd;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      margin-bottom: 8px;
      transition: all 0.2s ease;
      padding: 6px;
    }

    .instruction-card:hover {
      border-color: #dc3545;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }


    /* Ações */
    .add-new-button {
      margin-top: 10px !important;
      height: 40px !important;
      line-height: 38px !important;
      padding: 0 20px !important;
      display: inline-flex !important;
      align-items: center;
      gap: 5px;
    }

    .form-footer {
      margin-top: 40px;
      padding-top: 20px;
      border-top: 2px solid #f0f0f1;
    }

    .instruction-card {
      flex-wrap: wrap;
      padding: 12px !important;
      transition: border-color 0.3s;
    }

    .instruction-card.has-highlight {
      border-left: 4px solid #dc3545 !important;
      background: #fffcfc !important;
    }

    .card-content {
      flex-grow: 1;
    }

    .row-principal {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 5px;
    }

    .row-principal input {
      flex-grow: 1;
      font-weight: 600;
    }

    .row-extra {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      margin-top: 10px;
      padding-top: 10px;
      border-top: 1px dashed #eee;
    }

    .row-extra input {
      font-size: 12px !important;
    }

    .code-input {
      font-family: monospace;
      color: #666;
    }

    .btn-highlight {
      background: none;
      border: none;
      cursor: pointer;
      color: #ccc;
      transition: color 0.2s;
      padding: 0 5px;
    }

    .btn-highlight.active {
      color: #dc3545;
    }

    .btn-highlight:hover {
      color: #dc3545;
    }

    .media-upload-wrapper {
      display: flex;
      flex-direction: row-reverse;
      justify-content: flex-end;
      margin-left: 14px;
      gap: 14px;
    }

    /* Responsividade Básica */
    @media (max-width: 782px) {
      .instruction-card {
        flex-wrap: wrap;
      }
    }
  </style>

  <script>
    jQuery(document).ready(function($) {
      const uniqueId = () => 'set_' + Math.random().toString(36).substr(2, 9);

      // Função Global para definir padrão
      window.setAsDefault = function(id, btn) {
        $('#input_set_padrao').val(id);
        $('.set-default-btn').removeClass('is-default');
        $(btn).addClass('is-default');
        alert('Este set foi marcado como padrão (salve para confirmar).');
      };

      // Duplicar Set
      $(document).on('click', '.duplicate-grupo', function(e) {
        e.stopPropagation();
        const $card = $(this).closest('.grupo-card');
        const newId = uniqueId();

        // Clona o card
        const $clone = $card.clone();

        // Limpa estados e atualiza IDs nos campos
        $clone.addClass('collapsed');
        $clone.attr('data-id', newId);
        $clone.removeClass('is-default-card');
        $clone.find('.set-default-btn').removeClass('is-default').attr('onClick', `event.stopPropagation(); window.setAsDefault('${newId}', this);`);

        // Atualiza os atributos 'name' dos inputs clonados
        $clone.find('input').each(function() {
          const oldName = $(this).attr('name');
          if (oldName) {
            const newName = oldName.replace(/como_funciona_sets\[.*?\]/, `como_funciona_sets[${newId}]`);
            $(this).attr('name', newName);
          }
        });

        $clone.find('.titulo-grupo').val($clone.find('.titulo-grupo').val() + ' (Cópia)');
        $('#container-grupos').append($clone);
        initSortable();
      });

      // Atualiza o contador de frases
      function updateCounter($grupo) {
        const count = $grupo.find('.instruction-card').length;
        $grupo.find('.pax-counter').text(count + ' informações registradas');
      }

      // Toggle Accordion
      $(document).on('click', '.toggle-accordion', function(e) {
        $(this).closest('.grupo-card').toggleClass('collapsed');
      });

      // Adicionar Novo Grupo
      $('#add-novo-grupo').on('click', function() {
        const id = uniqueId();
        const html = `
                <div class="grupo-card" data-id="${id}">
                    <div class="grupo-header">
                        <div class="header-left toggle-accordion">
                            <span class="dashicons dashicons-arrow-right-alt2 toggle-icon"></span>
                            <input type="text" name="como_funciona_sets[${id}][titulo]" placeholder="Nome do Novo Set..." class="titulo-grupo" onClick="event.stopPropagation();" />
                            <span class="pax-counter">0 informações registradas</span>
                        </div>
                        <div class="header-right">
                            <button type="button" class="button-remove remove-grupo">Excluir Set</button>
                        </div>
                    </div>
                    <div class="grupo-body">
                        <div class="instruction-grid sortable-instrucoes"></div>
                        <button type="button" class="button button-secondary add-frase"> + Adicionar Frase </button>
                    </div>
                </div>`;
        $('#container-grupos').append(html);

        $('.settings-empty-placeholder')[0].style.display = 'none';
        initSortable();
      });

      // Adicionar Frase
      $(document).on('click', '.add-frase', function() {
        const $grupo = $(this).closest('.grupo-card');
        const gid = $grupo.data('id');
        const html = `
                <div class="instruction-card">
                    <div class="card-handle"><span class="dashicons dashicons-menu"></span></div>
                    <div class="card-content">
                        <div class="row-principal">
                            <input type="text" name="como_funciona_sets[${gid}][frases][texto][]" placeholder="Instrução principal..." />
                            <div class="card-actions">
                                <button type="button" class="btn-highlight" title="Tornar Destaque">
                                    <span class="dashicons dashicons-awards"></span>
                                    <input type="checkbox" name="como_funciona_sets[${gid}][frases][is_destaque][]" value="1" style="display:none;">
                                </button>
                                <button type="button" class="button-remove remove-row"><span class="dashicons dashicons-trash"></span></button>
                            </div>
                        </div>
                        <div class="row-extra" style="display:none;">
                            <input type="text" name="como_funciona_sets[${gid}][frases][texto_secundario][]" placeholder="Texto secundário..." />
                            <div class="media-upload-wrapper"> <input type="hidden" name="como_funciona_sets[${gid}][frases][icone][]" class="icone-url" value="" /> <div class="media-actions" style="display: flex; gap: 5px; align-items: center;"> <button type="button" class="button select-media-btn">Selecionar Ícone</button> <button type="button" class="button-link custom-remove-media" style="color: #a00; text-decoration: none;"> Remover </button> </div>
                        </div>
                    </div>
                </div>`;
        $grupo.find('.instruction-grid').append(html);
      });

      // Remover Frase
      $(document).on('click', '.remove-row', function() {
        const $grupo = $(this).closest('.grupo-card');
        $(this).closest('.instruction-card').remove();
        updateCounter($grupo);
      });

      // Remover Grupo
      $(document).on('click', '.remove-grupo', function(e) {
        e.stopPropagation();
        if (confirm('Excluir este set de orientações?')) {
          $(this).closest('.grupo-card').remove();

          // Mostra o placeholder se o tamanho for 0, esconde se for maior que 0
          $('.settings-empty-placeholder').toggle($("#container-grupos .grupo-card").length === 0);
        }


      });

      // Toggle Destaque
      $(document).on('click', '.btn-highlight', function() {
        const $btn = $(this);
        const $card = $btn.closest('.instruction-card');
        const $rowExtra = $card.find('.row-extra');
        const $checkbox = $btn.find('input[type="checkbox"]');

        $btn.toggleClass('active');
        $card.toggleClass('has-highlight');
        $rowExtra.slideToggle(200);

        // Sincroniza o checkbox (para o PHP receber o valor)
        $checkbox.prop('checked', $btn.hasClass('active'));
      });

      // Seletor de mídia para ícones de itens destaque
      $(document).on('click', '.select-media-btn', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const $wrapper = $btn.closest('.media-upload-wrapper');

        const image = wp.media({
          title: 'Selecionar Ícone',
          multiple: false,
          library: {
            type: 'image'
          }
        }).open().on('select', function() {
          const uploaded_image = image.state().get('selection').first().toJSON();
          $wrapper.find('.icone-url').val(uploaded_image.url);
          $wrapper.find('.icone-preview').html(`<img src="${uploaded_image.url}" style="width:100%; height:auto; display:block;">`);

          // Mostra o botão remover
          $wrapper.find('.custom-remove-media').show();
        });
      });

      // Ação de Remover ícone de itens destaque
      $(document).on('click', '.custom-remove-media', function(e) {
        e.preventDefault();
        const $btn = $(this);
        const $wrapper = $btn.closest('.media-upload-wrapper');

        // Limpa o input hidden e o preview
        $wrapper.find('.icone-url').val('');
        $wrapper.find('.icone-preview').empty();

        // Esconde o próprio botão
        $btn.hide();
      });

      function initSortable() {
        $('.sortable-instrucoes').sortable({
          handle: '.card-handle',
          axis: 'y'
        });
      }
      initSortable();
    });
  </script>
<?php
  wp_enqueue_script('jquery-ui-sortable');
}

function sanitize_como_funciona($input)
{
  if (!is_array($input)) return $input;

  foreach ($input as $id_grupo => $dados) {
    $novas_frases = [];
    if (isset($dados['frases']) && is_array($dados['frases'])) {
      // Se os dados vierem do formulário (paralelos), organizamos em objetos
      if (isset($dados['frases']['texto'])) {
        foreach ($dados['frases']['texto'] as $i => $txt) {
          if (!empty($txt)) {
            $novas_frases[] = [
              'texto' => sanitize_text_field($txt),
              'is_destaque' => isset($dados['frases']['is_destaque'][$i]) ? '1' : '0',
              'texto_secundario' => sanitize_text_field($dados['frases']['texto_secundario'][$i] ?? ''),
              'icone' => sanitize_textarea_field($dados['frases']['icone'][$i] ?? '')
            ];
          }
        }
      } else {
        // Se já for a estrutura de objeto (vinda do banco), apenas limpamos
        foreach ($dados['frases'] as $f) {
          $novas_frases[] = [
            'texto' => sanitize_text_field($f['texto'] ?? $f), // fallback para strings antigas
            'is_destaque' => ($f['is_destaque'] ?? '0'),
            'texto_secundario' => sanitize_text_field($f['texto_secundario'] ?? ''),
            'icone' => sanitize_textarea_field($f['icone'] ?? '')
          ];
        }
      }
    }
    $input[$id_grupo]['frases'] = $novas_frases;
  }
  return $input;
}

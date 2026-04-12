<?php

/**
 * Renderiza a página de personalização da excursão
 */

add_action('admin_init', function () {
  register_setting('opt_excursao_geral', 'galeria_excursao');
  register_setting('opt_excursao_geral', 'exibir_galeria_excursao');
});

function render_excursao_settings_page()
{
  $galeria = get_option('galeria_excursao', []);
  $galeria = array_values($galeria);
  // wp_enqueue_media(); // Garante o seletor de mídia do WP
?>
  <div class="wrap aerotour-admin-wrapper">

    <!-- Adiciona o cabeçalho de navegação das configurações do tema -->
    <?php render_settings_header('excursao-geral'); ?>

    <div class="settings-page-content">

      <div class="content-header">
        <h2>Configurações Gerais da Excursão</h2>
        <p>Nesta seção você poderá configurar elementos globais, como cores das tabs, layouts de cards, etc.</p>
      </div>

      <form method="post" action="options.php">
        <?php
        // Deve corresponder ao grupo registrado no register_setting
        settings_fields('opt_excursao_geral');
        ?>
        <div class="notice notice-info inline">
          <p>Em desenvolvimento.</p>
        </div>

        <!-- Submenu para opções da excursão (Como Funciona e FAQ) -->
        <div class="admin-sub-nav">
          <a href="admin.php?page=config-excursao-como-funciona" class="sub-nav-card">
            <span class="dashicons dashicons-format-aside"></span>
            <div>
              <strong>Como Funciona</strong>
              <small>Gerencie os conjuntos de instruções</small>
            </div>
          </a>
          <a href="admin.php?page=config-excursao-faq" class="sub-nav-card">
            <span class="dashicons dashicons-editor-help"></span>
            <div>
              <strong>FAQ</strong>
              <small>Perguntas e respostas frequentes</small>
            </div>
          </a>
        </div>

        <!-- Seção Galeria de Fotos -->
        <div class="settings-section">
          <h3>Galeria de Fotos do Produto</h3>

          <div class="exibicao-controle-wrapper" style="margin-bottom: 20px; background: #fff; padding: 15px; border-radius: 8px; border: 1px solid #ccd0d4;">
            <label for="exibir_galeria_excursao" style="display: flex; align-items: center; cursor: pointer; font-weight: 600;">
              <?php $exibir_galeria = get_option('exibir_galeria_excursao', '1'); // '1' por padrão 
              ?>
              <input type="checkbox" name="exibir_galeria_excursao" id="exibir_galeria_excursao" value="1" <?php checked('1', $exibir_galeria); ?> style="margin-right: 10px; width: 18px; height: 18px;">
              Exibir galeria de fotos na página do produto
            </label>
          </div>

          <div class="grupo-card galeria-retratil collapsed">
            <div class="grupo-header">
              <div class="header-main">
                <span class="dashicons dashicons-images-alt2"></span>

                <span class="count-badge"><?= count($galeria); ?> fotos</span>
              </div>
              <div class="header-actions">
                <span class="dashicons dashicons-arrow-down-alt2 toggle-icon"></span>
              </div>
            </div>

            <div class="grupo-body" style="display: none;">
              <div class="guidelines-box">
                <strong>💡 Orientações Rápidas:</strong>
                <ul style="margin: 5px 0 0 15px; font-size: 12px;">
                  <li>Use formato <strong>.webp</strong> | Proporção <strong>3:2</strong> | Máx <strong>200kb</strong>.</li>
                </ul>
              </div>

              <div id="gallery-container" class="gallery-grid sortable-gallery">
                <?php if (!empty($galeria)) : foreach ($galeria as $index => $item) : ?>
                    <div class="gallery-item-card">
                      <div class="item-handle"><span class="dashicons dashicons-menu"></span></div>
                      <img src="<?= esc_url($item['url']); ?>" class="preview-img">
                      <input type="hidden" name="galeria_excursao[<?= $index; ?>][url]" value="<?= esc_attr($item['url']); ?>">
                      <div class="item-details">
                        <input type="text" name="galeria_excursao[<?= $index; ?>][legenda]"
                          value="<?= esc_attr($item['legenda']); ?>" placeholder="Legenda da foto...">
                        <button type="button" class="remove-gallery-item"><span class="dashicons dashicons-trash"></span></button>
                      </div>
                    </div>
                <?php endforeach;
                endif; ?>
              </div>

              <button type="button" id="add-gallery-images" class="button button-secondary">
                <span class="dashicons dashicons-insert"></span> Adicionar Fotos
              </button>
            </div>
          </div>
        </div>

        <div class="form-footer" style="margin-top: 40px; padding-top: 20px; border-top: 2px solid #f0f0f1;">
          <?php submit_button('Salvar Todas as Configurações'); ?>
        </div>
      </form>



    </div>
  </div>

  <script>
    jQuery(document).ready(function($) {
      // Inicializa Drag and Drop
      $('.sortable-gallery').sortable({
        handle: '.item-handle',
        axis: 'y',
        opacity: 0.7
      });

      // Seletor de Mídia Múltiplo
      $('#add-gallery-images').on('click', function(e) {
        e.preventDefault();
        const frame = wp.media({
          title: 'Selecionar Fotos para Galeria',
          multiple: true,
          library: {
            type: 'image'
          }
        }).open().on('select', function() {
          const selections = frame.state().get('selection');
          selections.map(function(attachment) {
            attachment = attachment.toJSON();
            const index = $('.gallery-item-card').length;
            const html = `
                    <div class="gallery-item-card">
                        <div class="item-handle"><span class="dashicons dashicons-menu"></span></div>
                        <img src="${attachment.url}" class="preview-img">
                        <input type="hidden" name="galeria_excursao[${index}][url]" value="${attachment.url}">
                        <div class="item-details">
                            <input type="text" name="galeria_excursao[${index}][legenda]" placeholder="Legenda da foto...">
                            <button type="button" class="remove-gallery-item"><span class="dashicons dashicons-trash"></span></button>
                        </div>
                    </div>`;
            $('#gallery-container').append(html);
          });
        });
      });

      // Remove imagem da galeria
      $(document).on('click', '.remove-gallery-item', function() {
        $(this).closest('.gallery-item-card').fadeOut(function() {
          $(this).remove();
        });
      });
      // 1. Toggle do Accordion
      $(document).on('click', '.galeria-retratil .grupo-header', function() {
        const $card = $(this).closest('.grupo-card');
        $card.find('.grupo-body').slideToggle();
        $card.toggleClass('is-open');
      });

      // 2. Atualizar contador de fotos
      function updatePhotoCount() {
        const count = $('.gallery-item-card').length;
        $('.galeria-retratil .count-badge').text(count + (count === 1 ? ' foto' : ' fotos'));
      }

      // 3. Ajuste no upload para abrir a seção se estiver fechada e atualizar contador
      $('#add-gallery-images').on('click', function(e) {
        // ... (seu código de upload atual) ...
        // Após o append das imagens:
        updatePhotoCount();
      });

      // 4. Ajuste na remoção para atualizar contador
      $(document).on('click', '.remove-gallery-item', function() {
        $(this).closest('.gallery-item-card').fadeOut(function() {
          $(this).remove();
          updatePhotoCount();
        });
      });

    });
  </script>

  <style>
    /* Estilos do Menu de Sub-navegação */
    .admin-sub-nav {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 15px;
      margin-bottom: 40px;
    }

    .sub-nav-card {
      background: #fff;
      border: 1px solid #ccd0d4;
      padding: 15px;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 15px;
      text-decoration: none;
      color: #2c3338;
      transition: all 0.2s;
    }

    .sub-nav-card:hover {
      border-color: #dc3545;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      transform: translateY(-2px);
    }

    .sub-nav-card .dashicons {
      font-size: 30px;
      width: 30px;
      height: 30px;
      color: #dc3545;
    }

    .sub-nav-card small {
      display: block;
      color: #646970;
    }

    /* Estilos da Galeria */
    .guidelines-box {
      background: #f0f6fb;
      border-left: 4px solid #2271b1;
      padding: 15px;
      margin: 20px 0;
      border-radius: 4px;
    }

    .guidelines-box ul li {
      font-size: .775rem;
      margin-bottom: 2px;
    }

    .gallery-grid {
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin-bottom: 20px;
    }

    .gallery-item-card {
      background: #fff;
      border: 1px solid #ccd0d4;
      display: flex;
      align-items: center;
      padding: 10px;
      border-radius: 6px;
      gap: 15px;
    }

    .preview-img {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
    }

    .item-details {
      flex-grow: 1;
      display: flex;
      gap: 10px;
    }

    .item-details input {
      flex-grow: 1;
    }

    .item-handle {
      cursor: grab;
      color: #ccd0d4;
    }

    .galeria-retratil .grupo-header {
      cursor: pointer;
      background: #f8f9fa;
      padding: 15px;
      border-radius: 6px;
      border: 1px solid #ccd0d4;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .galeria-retratil.is-open .grupo-header {
      border-bottom: none;
      border-radius: 6px 6px 0 0;
    }

    .galeria-retratil .grupo-body {
      border: 1px solid #ccd0d4;
      border-top: none;
      padding: 20px;
      background: #fff;
      border-radius: 0 0 6px 6px;
    }

    .galeria-retratil .toggle-icon {
      transition: transform 0.3s;
    }

    .galeria-retratil.is-open .toggle-icon {
      transform: rotate(180deg);
    }

    .header-main {
      display: flex
    }

    .count-badge {
      background: #eee;
      padding: 2px 8px;
      border-radius: 10px;
      font-size: 11px;
      margin-left: 10px;
      display: block;
      width: fit-content;
    }
  </style>
<?php
  wp_enqueue_script('jquery-ui-sortable');
}

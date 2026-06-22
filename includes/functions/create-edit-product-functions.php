<?php
/* Cria e salva as opções personalizadas das excursões */
add_action('woocommerce_product_options_advanced', 'exc_advanced_details');
function exc_advanced_details()
{
?>
  <!-- Eventos anteriores -->
  <div class="options_group options_group_anteriores">
    <p class="form-field">
      <label for="previous_event_ids">
        <p>Excursões anteriores para direcionar tráfego</p>
      </label>
      <select id="meta_previous_event_ids" name="meta_previous_event_ids[]" class="wc-product-search" multiple="multiple" style="width: 50%;" data-placeholder="<?php esc_attr_e('Busque pelas excursões passadas...', 'woocommerce'); ?>" data-action="woocommerce_json_search_products_and_variations">
        <?php
        $product_ids = get_post_meta(get_the_ID(), 'previous_event_ids', true);

        if (! empty($product_ids)) {
          foreach ($product_ids as $product_id) {
            $product = wc_get_product($product_id);
            if (is_object($product)) {
              echo '<option value="' . esc_attr($product_id) . '" selected="selected">' . wp_kses_post($product->get_formatted_name()) . '</option>';
            }
          }
        }
        ?>
      </select>
      <?= wc_help_tip('Selecione os produtos antigos. Nestes produtos, um aviso será exibido redirecionando para esta página atual.'); ?>
    </p>
  </div>
  <!-- Local do evento -->
  <div class="options_group options_group_local_evento">
    <?php woocommerce_wp_text_input([
      'id' => 'meta_local_evento',
      'value' => get_post_meta(get_the_ID(), 'local_evento', true),
      'label' => 'Local do evento',
      'desc_tip' => true,
      'description' => 'Ex.: Allianz Park/SP'
    ]); ?>
  </div>
  <!-- Previsão de chegada -->
  <div class="options_group">
    <?php woocommerce_wp_text_input([
      'id' => 'meta_previsao_chegada',
      'value' => get_post_meta(get_the_ID(), 'previsao_chegada', true),
      'label' => 'Previsão de chegada',
      'desc_tip' => true,
      'description' => 'Ex.: 15h / Entre 14:30 e 15h'
    ]); ?>
  </div>
  <!-- informações sobre ingressos -->
  <div class="options_group options_group_ingressos">
    <p>Informações sobre ingressos</p>
    <?php
    woocommerce_wp_text_input([
      'id' => 'meta_ingressos_label',
      'value' => get_post_meta(get_the_ID(), 'ingressos_label', true),
      'label' => 'Label'
    ]);
    woocommerce_wp_text_input([
      'id' => 'meta_ingressos_link',
      'value' => get_post_meta(get_the_ID(), 'ingressos_link', true),
      'label' => 'Link'
    ]);
    ?>
  </div>
  <!-- Seleciona set de orientaçõa para tab Como Funciona -->
  <div class="options_group options_group_sets">
    <?php
    $sets = get_option('como_funciona_sets', []);
    woocommerce_wp_select([
      'id'      => 'meta_como_funciona_set',
      'label'   => 'Orientações da seção Como Funciona',
      'value' => get_post_meta(get_the_ID(), 'como_funciona_set', true),
      'options' => array_merge(['' => 'Selecione um set...'], wp_list_pluck($sets, 'titulo'))
    ]);

    ?>
  </div>
  <!-- Seleciona grupo de FAQ para Principais Dúvidas -->
  <div class="options_group options_group_sets">
    <?php
    $grupos = get_option('grupos_faq', []);
    woocommerce_wp_select([
      'id'      => 'meta_grupo_faq',
      'label'   => 'Grupo de Perguntas frequentes',
      'value' => get_post_meta(get_the_ID(), 'grupo_faq', true),
      'options' => array_merge(['' => 'Selecione um grupo...'], wp_list_pluck($grupos, 'titulo'))
    ]);

    ?>
  </div>
  <!-- Define se será destaque na home -->
  <div class="options_group options_group_destaque">
    <?php woocommerce_wp_checkbox([
      'id' => 'meta_destaque',
      'value' => get_post_meta(get_the_ID(), 'destaque', true),
      'label' => 'Destaque',
      'desc_tip' => true,
      'description' => 'A excursão aparecerá no banner principal do site'
    ]); ?>
    <div class="destaque-imagens-select">
      <div class="dest-img-1">
        <a href="#" class="button media-selector" data-target="image_1">Selecionar Imagem de fundo</a>
        <?php if (get_post_meta(get_the_ID(), 'dest_img_1_id', true)) { ?>
          <input type="hidden" id="image_1_id" name="meta_dest_img_1_id" value="<?= get_post_meta(
                                                                                  get_the_ID(),
                                                                                  'dest_img_1_id',
                                                                                  true
                                                                                ) ?>">
          <img id="image_1_preview" src="<?= wp_get_attachment_url(
                                            get_post_meta(get_the_ID(), 'dest_img_1_id', true)
                                          ) ?>" style="max-width:50px" />

        <?php } else { ?>
          <input type="hidden" id="image_1_id" name="meta_dest_img_1_id" value="">
          <img id="image_1_preview" src="" style="max-width:50px" />
        <?php } ?>
      </div>

      <div class="dest-img-2">
        <a href="#" class="button media-selector" data-target="image_2">Selecionar Imagem destaque</a>

        <?php if (get_post_meta(get_the_ID(), 'dest_img_2_id', true)) { ?>
          <input type="hidden" id="image_2_id" name="meta_dest_img_2_id" value="<?= get_post_meta(
                                                                                  get_the_ID(),
                                                                                  'dest_img_2_id',
                                                                                  true
                                                                                ) ?>">
          <img id="image_2_preview" src="<?= wp_get_attachment_url(
                                            get_post_meta(get_the_ID(), 'dest_img_2_id', true)
                                          ) ?>" style="max-width:50px" />
        <?php } else { ?>
          <input type="hidden" id="image_2_id" name="meta_dest_img_2_id" value="">
          <img id="image_2_preview" src="" style="max-width:50px" />
        <?php } ?>
      </div>
    </div>
  </div>

  <!-- Define se exibirá lugares vendidos -->
  <div class="options_group options_group_vendidos">
    <?php
    woocommerce_wp_checkbox([
      'id' => 'meta_show_vendidos',
      'value' => get_post_meta(get_the_ID(), 'show_vendidos', true),
      'label' => 'Mostrar lugares vendidos',
      'desc_tip' => true,
      'description' => 'O número de lugares vendidos será exibido na página'
    ]);

    woocommerce_wp_text_input([
      'id' => 'meta_vendidos_inc',
      'value' => get_post_meta(get_the_ID(), 'vendidos_inc', true),
      'label' => 'Incremento',
      'desc_tip' => 'true',
      'description' => 'Digite apenas números.',
      'type' => 'number',
      'custom_attributes' => [
        'min' => '0', // valor mínimo permitido
        'step' => '1', // incrementos permitidos
        'pattern' => '\d*', // regex para números
        'inputmode' => 'numeric' // sugere teclado numérico em dispositivos móveis
      ]
    ]);
    ?>
  </div>
  <!-- Redirecionamento para excursões passadas -->
  <div class="options_group options_group_redirect">
    <?php if (false) {
      // 1. Obter a instância do objeto do produto
      $product = wc_get_product(get_the_ID());

      // 2. Obter o valor do atributo
      $valor_atributo_string = $product->get_attribute('Dia');

      // 3. Transforma em array de datas "dd/mm/yyyy"
      $dates_array = array_map(
        'trim',
        explode('|', $valor_atributo_string)
      );

      // 4. Itera sobre as datas para encontrar a mais recente em Unix
      $latest_date_object = null;
      foreach ($dates_array as $date_str) {
        $current_date = DateTime::createFromFormat('d/m/Y', $date_str);

        if ($current_date instanceof DateTime) {
          if (
            $latest_date_object === null ||
            $current_date > $latest_date_object
          ) {
            $latest_date_object = $current_date;
          }
        }
      }

      // 5. Compara se a data atual é maior do que a última data da excursão
      if ($latest_date_object->getTimestamp() < time()) { ?>
        <div>
          <p>Redirecionar para...</p>
          <?php woocommerce_wp_text_input([
            'id' => 'meta_redirect_link',
            'value' => get_post_meta(get_the_ID(), 'redirect_link', true),
            'label' => 'Link'
          ]); ?>
        </div>
    <?php }
    } ?>
  </div>
<?php
}

//SALVA AS METAS PERSONALIZADAS
add_action('woocommerce_process_product_meta', 'process_product_meta_optimized');

function process_product_meta_optimized($id)
{
  // 1. Campos que devem ser limpos/deletados se não estiverem no $_POST
  if (!isset($_POST['meta_previous_event_ids'])) {
    delete_post_meta($id, 'previous_event_ids');
  }

  if (!isset($_POST['meta_destaque'])) {
    update_post_meta($id, 'destaque', '');
  }

  // 2. Itera sobre o POST apenas uma vez
  foreach ($_POST as $post_key => $post_value) {
    // Filtra apenas chaves que começam com 'meta_'
    if (!str_starts_with($post_key, 'meta_')) {
      continue;
    }

    // Remove o prefixo 'meta_' para obter a chave real
    $clean_key = str_replace('meta_', '', $post_key);

    /**
     * LÓGICA PARA PRODUTOS FILHOS (IDs NUMÉRICOS NO FINAL)
     * Ex: meta_campo_customizado_123 -> extrai 'campo_customizado' e '123'
     */
    if (preg_match('/(.+)_(\d+)$/', $clean_key, $matches)) {
      $meta_key = $matches[1];
      $child_id = $matches[2];

      if (!empty($post_value)) {
        update_post_meta($child_id, $meta_key, $post_value);
      }
      continue; // Pula para a próxima iteração
    }

    /**
     * LÓGICA PARA EVENTOS PASSADOS (Sincronização de IDs)
     */
    if ($clean_key === 'previous_event_ids') {
      $new_event_ids = array_map('intval', (array) $post_value);

      // Limpa vínculos antigos de quem apontava para este produto [cite: 7, 8]
      $old_links = get_posts([
        'post_type'  => 'product',
        'meta_query' => [['key' => 'more_recent_event_id', 'value' => $id]],
        'fields'     => 'ids',
        'posts_per_page' => -1
      ]);

      foreach ($old_links as $old_id) {
        delete_post_meta($old_id, 'more_recent_event_id');
      }

      // Injeta o vínculo nos novos produtos selecionados [cite: 9, 10]
      foreach ($new_event_ids as $event_id) {
        update_post_meta($event_id, 'more_recent_event_id', $id);
      }

      // Salva a lista no próprio produto [cite: 11]
      update_post_meta($id, 'previous_event_ids', $new_event_ids);
      
    } elseif ($clean_key === 'embarques_data'){ // Salva os embarques da excursão

      $product = wc_get_product($id);
      if (!$product || !$product->is_type('variable')) {
          return;
      }



      // Obtém todas as variações ligadas a esse produto pai
      $variation_ids = $product->get_children();

      if(empty($post_value)){
        delete_post_meta($v_id, '_embarques_config');
        continue;
      }

      $data_json = stripslashes($post_value);
      $data_por_variacao = json_decode($data_json, true);

      foreach ($variation_ids as $v_id) {
            // Se houver configuração ativa para essa variação específica, salva
            if (isset($data_por_variacao[$v_id]) && !empty($data_por_variacao[$v_id])) {
                update_post_meta($v_id, '_embarques_config', json_encode($data_por_variacao[$v_id], JSON_UNESCAPED_UNICODE));
            } else {
                // Caso contrário, remove o metadado (evita lixo no banco se o ponto for desativado)
                delete_post_meta($v_id, '_embarques_config');
            }
        }



    }else {
      // SALVAMENTO PADRÃO para outros campos meta_ 
      // Certifique-se de sanitizar conforme o tipo de dado
      $sanitized_value = is_array($post_value) ? array_map('sanitize_text_field', $post_value) : sanitize_text_field($post_value);
      update_post_meta($id, $clean_key, $sanitized_value);
    }
  }
}

// Atualiza o meta '_dia_iso' automaticamente quando uma variação é salva
add_action(
  'woocommerce_save_product_variation',
  'aer_save_dia_iso_meta',
  10,
  2
);

function aer_save_dia_iso_meta($variation_id, $i)
{
  // Obtém o valor do atributo 'dia' enviado no formulário da variação
  $dia_dmy = $_POST['attribute_dia'][$i] ?? '';

  if (!$dia_dmy) {
    return;
  }

  // Converte para ISO (yyyy-mm-dd)
  $dia_iso = int_data_to_iso($dia_dmy);

  // Salva como meta para consulta otimizada
  update_post_meta($variation_id, '_dia_iso', $dia_iso);
}

// Função auxiliar para converter dd/mm/yyyy → yyyy-mm-dd
function int_data_to_iso($data_dmy)
{
  $partes = explode('/', $data_dmy);
  if (count($partes) !== 3) {
    return null;
  }
  [$dia, $mes, $ano] = $partes;
  return sprintf('%04d-%02d-%02d', $ano, $mes, $dia);
}
?>
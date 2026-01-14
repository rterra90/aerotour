<?php
/* Cria e salva as opções personalizadas das excursões */
add_action('woocommerce_product_options_advanced', 'exc_advanced_details');
function exc_advanced_details()
{
  ?>
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

add_action('woocommerce_process_product_meta', 'process_product_meta');
function process_product_meta($id)
{
  foreach ($_POST as $post_key => $post_value) {
    if (str_starts_with($post_key, 'meta_')) {
      //filtra a chave que será atalizada
      $meta_key = str_replace('meta_', '', $post_key);

      // filtra o último termo do nome da chave
      $last_key_word = explode('_', $meta_key)[
        sizeof(explode('_', $meta_key)) - 1
      ];

      if (is_numeric($last_key_word)) {
        $_to_remove = '_' . $last_key_word;
        $_var_id = $last_key_word;
        $meta_key = str_replace($_to_remove, '', $meta_key);
        if (!empty($post_value)) {
          update_post_meta($_var_id, $meta_key, $post_value);
        }
      } else {
        if (!empty($post_value)) {
          update_post_meta($id, $meta_key, $post_value);

          /* ************** */
          // if($meta_key === 'exc_embarques'){
          //   // $obj_post_value = json_decode($post_value);
          //   // $obj_post_value['novo'] = 'testando';
          //   // $final_obj_post_value = json_encode($obj_post_value);

          //   // foreach($post_value as $_i => $_embarque){
          //   //   array_push($exc_emb_post_value, 'testes');
          //   //   // array_push($exc_emb_post_value, $_embarque);
          //   //   // $emb_opcoes = array();
          //   //   // $_final = array();
          //   //   // foreach($_embarque -> horarios as $hor_obj){
          //   //   //   $_hor = $hor_obj -> horario;
          //   //   //   foreach($hor_obj -> disponibilidade as $_dispon){
          //   //   //     $_status = $_dispon -> status == 'disponivel' ? 'ativo' : 'inativo';
          //   //   //     $_dia = $_dispon -> disp_dia;
          //   //   //     $_final = [dia => $_dia, horario => $_hor, status => $_status];
          //   //   //     array_push($emb_opcoes, $_final);
          //   //   //   }

          //   //   //   $exc_emb_post_value[$_i]['opcoes'] = $emb_opcoes;
          //   //   // }
          //   // }

          //   // update_post_meta($id, $meta_key, $aa);
          //   // update_post_meta($id, $meta_key, json_encode($obj_post_value, JSON_UNESCAPED_UNICODE));
          //   update_post_meta($id, $meta_key, $meta_key);

          // }else{
          //   update_post_meta($id, $meta_key, $post_value);

          // }

          /* ************** */
        }
      }
    }

    if (str_starts_with($post_key, 'passageiros_var_')) {
      $var_id = str_replace(
        '_',
        '/',
        str_replace('passageiros_var_', '', $post_key)
      );
      update_post_meta($var_id, 'passageiros', $post_value);
    }

    if (!isset($_POST['meta_destaque'])) {
      update_post_meta($id, 'destaque', '');
    }
  }

  // $embarques_exc_string = json_encode($embarques_exc, JSON_UNESCAPED_UNICODE);
  // if(sizeof($embarques_exc) > 0) update_post_meta($id, 'exc_embarques', $embarques_exc_string);
}

// Atualiza o meta '_dia_iso' automaticamente quando uma variação é salva
add_action(
  'woocommerce_save_product_variation',
  'aer_save_dia_iso_meta',
  10,
  2
);

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

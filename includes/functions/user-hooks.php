<?php

add_action('wp_ajax_clear_user_data', 'ajax_clear_user_data');
function ajax_clear_user_data()
{
  $target_data = $_POST['type'];
  $target_user_id = $_POST['user_id'];

  $clear = update_user_meta($target_user_id, $target_data, '');

  if ($clear) {
    wp_send_json_success('Dado apagado com sucesso.');
  } else {
    wp_send_json_error("Falha ao limpar as informações.");
  }
}

<?php

function api_participantes_roleta_put($request){
  global $wpdb;
  $camp_id = $request['camp_id'];
  $user_id = $request['user_id'];
  $cupom_obtido = $request['cupom_obtido'];
  $timestamp = $request['timestamp'];

  //obtém array de participantes da campanha
  $participantes_query = $wpdb -> get_results($wpdb -> prepare("SELECT `participantes` from `aer_camp_premios` WHERE id = $camp_id"));
  $participantes = json_decode($participantes_query[0] -> participantes);

  //verifica se o usuário já participou
  $ja_participou = array_filter($participantes, function($_participante) use($user_id){
    if((int)$_participante -> user_id == (int)$user_id) return $_participante;
  });

  if(sizeof($ja_participou) > 0){
    return rest_ensure_response('JaParticipou');
  }else{
    $participantes[] = array(
      "user_id" => $user_id,
      "cupom_obtido" => $cupom_obtido,
      "timestamp" => $timestamp
    );
    $novos_dados = array(
      'participantes' => json_encode($participantes, JSON_UNESCAPED_UNICODE),
    );
    $res = $wpdb->update("aer_camp_premios", $novos_dados, array("id" => $camp_id));

    return rest_ensure_response($res);
  }
}

function registrar_api_participantes_roleta_put(){
  register_rest_route('api', '/db', array(
    array(
      'methods' => WP_REST_SERVER::EDITABLE,
      'callback' => 'api_participantes_roleta_put',
    )
  ));
}

add_action('rest_api_init', 'registrar_api_participantes_roleta_put')
?>
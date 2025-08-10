<?php

function api_campanhas_get($request){
  global $wpdb;
  $camp_id = (int) $request -> get_param('camp_id');
  $only_data = $request -> get_param('only_data');

  if(isset($camp_id)){
    $res = $wpdb -> get_results($wpdb -> prepare("SELECT * from `aer_camp_premios` WHERE id = $camp_id"));
    $res = json_encode($res, JSON_UNESCAPED_UNICODE);

  }else{
    if($only_data == 'true'){
      $res = $wpdb -> get_results($wpdb -> prepare("SELECT `id`,`nome_campanha`,`valido_de`, `valido_ate`, `status` from `aer_camp_premios`"));
    }else{
      $res = $wpdb -> get_results($wpdb -> prepare("SELECT * from `aer_camp_premios`"));
    }

  }

  return rest_ensure_response($res);
}

function registrar_api_campanhas_get(){
  register_rest_route('api', '/db', array(
    array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'api_campanhas_get',
      'args'     => [
        'camp_id' => [
          'required' => false,
          'validate_callback' => function ($param, $request, $key){
            return is_numeric($param);
          }
        ],
        'only_data' => [
          'required' => false,
        ]
      ]

    )
  ));
}

add_action('rest_api_init', 'registrar_api_campanhas_get')
?>
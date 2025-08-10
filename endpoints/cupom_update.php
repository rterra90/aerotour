<?php

function api_cupom_update($request){
  $user_id = $request['user_id'];
  $cupom_code = $request['cupom_code'];
  $cupom_id = wc_get_coupon_id_by_code($cupom_code);

  // update_post_meta(2902, 'allowed_customers', '');
  // update_post_meta(2903, 'allowed_customers', '');
  // update_post_meta(2904, 'allowed_customers', '');
  // update_post_meta(2905, 'allowed_customers', '');

  if($cupom_id != 0){
    $allowed_customers = get_post_meta($cupom_id, 'allowed_customers', true);
    $user_cupons_meta = get_user_meta($user_id, 'cupons', true);

  //   // Se não houver usuários adicionados ainda, inicializa um array
  //   if (!is_array($allowed_customers)) {
  //     $allowed_customers = array();
  // }
  if ($allowed_customers == '') {
    $allowed_customers = array();
} else{
  $allowed_customers = json_decode($allowed_customers);
}


  //   // Adiciona o novo ID do usuário se ainda não estiver na lista
    if (!in_array($user_id, $allowed_customers)) {
      array_push($allowed_customers, $user_id);
      $allowed_customers = json_encode($allowed_customers);
      update_post_meta($cupom_id, 'allowed_customers', $allowed_customers);

      if($user_cupons_meta == '')$user_cupons_meta = array();
      else $user_cupons_meta = json_decode($user_cupons_meta);

      // $user_cupons_meta = array(); //APAGAR

      if(!in_array($cupom_id, $user_cupons_meta)) array_push($user_cupons_meta, $cupom_id);
      $user_cupons_meta2 = json_encode($user_cupons_meta);
      $rr = update_user_meta($user_id, 'cupons', $user_cupons_meta2);

      // return rest_ensure_response( $rr );

      $response = 'Cupom obtido com sucesso!';
    }else{
      $response = 'Parece que você já tem esse cupom...';
    }

    return rest_ensure_response( $response );

  }else{
    return rest_ensure_response( 'Cupom inexistente' );
  }


}

function registrar_api_cupom_update(){
  register_rest_route('api', '/cupom', array(
    array(
      // 'methods' => WP_REST_Server::READABLE,
      'methods' => WP_REST_SERVER::EDITABLE,
      'callback' => 'api_cupom_update'

    )
  ));
}

add_action('rest_api_init', 'registrar_api_cupom_update')
?>
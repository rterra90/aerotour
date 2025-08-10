<?php

function api_user_get($request){
  global $wpdb;
  $users_ids = $request -> get_param('users_ids');
  $fields = $request -> get_param('fields');

  if(isset($users_ids) && isset($fields)){
    // DESNEVOLVER

  }else if(isset($users_ids) && !isset($fields)){
    $ids = explode(',', $users_ids);
    $users = array();

    foreach ($ids as $id) {
      $user = get_userdata($id);
      if ($user) {
        $users[] = array(
            'ID'       => $user->ID,
            'name'     => $user->display_name,
            'email'    => $user->user_email,
        );
      };
    };
    
    return rest_ensure_response($users);

  }else if(!isset($users_ids) && isset($fields)){
    // DESNEVOLVER

  } else if(!isset($users_ids) && !isset($fields)){
    // DESNEVOLVER

  };




  $res = $wpdb -> get_results($wpdb -> prepare("SELECT * from `aer_camp_premios` WHERE id = $camp_id"));
  $res = json_encode($res, JSON_UNESCAPED_UNICODE);

}

function registrar_api_user_get(){
  register_rest_route('api', '/db', array(
    array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'api_user_get',
      'args'     => [
        'user_id' => [
          'required' => false,
          'validate_callback' => function ($param, $request, $key){
            return is_numeric($param);
          }
        ],
        'fields' => [
          'required' => false,
        ]
      ]

    )
  ));
}

add_action('rest_api_init', 'registrar_api_user_get')
?>
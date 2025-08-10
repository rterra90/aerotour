<?php
function aer_proximas_excursoes($excursoes, $filter = null){
  $proximas = array();
  $proximas_exc = array();
  foreach($excursoes as $excursao_prox){
    $exc_id = $excursao_prox -> get_id();
    $variacoes = $excursao_prox -> get_available_variations();

    if(count($variacoes) > 0){
      $data_final = $variacoes[count($variacoes) - 1]['attributes']['attribute_dia'];
      $data_final = count(explode('/', $data_final)) == 3 ? $data_final : $data_final . "/" .date("Y");
      $data_final_std = explode('/', $data_final)[2] . '-' . explode('/', $data_final)[1] . '-' . explode('/', $data_final)[0];
      $status = (int)strtotime('now') >= ((int)strtotime($data_final_std) + (3600 * 27)) ? 'arquivada' : 'exibe';
    }else{
      $data_final_std = '31-12-2999';
      $status = 'exibe';
    }



    if($filter === 'destaque'){
      if(get_post_meta($exc_id)['destaque'][0] === 'yes' && $status == 'exibe') $proximas[$exc_id] = strtotime($data_final_std);
    }else if($filter === 'variacoes'){
      foreach($variacoes as $var){
        $dia_var = $var['attributes']['attribute_dia'];
        $dia_var = count(explode('/', $dia_var)) == 3 ? $dia_var : $dia_var . "/" .date("Y");
        $dia_var_std = explode('/', $dia_var)[2] . '-' . explode('/', $dia_var)[1] . '-' . explode('/', $dia_var)[0];

        //48 horas para sumir da lista de próximas excursões no check in
        if((int)strtotime('now') < strtotime($dia_var_std) + (3600 * 48)) $proximas[$var['variation_id']] = strtotime($dia_var_std);

      }
    }else if($filter === 'arquivadas' && $status === 'arquivada'){
      $proximas[$exc_id] = strtotime($data_final_std);
    }else if($filter === 'em-breve'){
      if(get_post_meta($exc_id, 'exc_embarques', true) === '') $proximas[$exc_id] = strtotime($data_final_std);
    }else if($filter === 'mais-esperados'){
        console.log('mais esperado');
        
        
    }else if(($filter === 'galeria' || $filter === null) && $status === 'exibe'){
       $proximas[$exc_id] = strtotime($data_final_std);
    }

  }
  asort($proximas);


  $i=0;
  foreach($proximas as $key => $p){
    if($filter === 'destaque' || $filter === 'galeria') array_push($proximas_exc, wc_get_products(array('include' => array($key)))[0]);
    else if($filter === 'variacoes' || $filter === 'arquivadas') array_push($proximas_exc, wc_get_product($key));
    else if($filter === 'em-breve' && $i < 8) array_push($proximas_exc, wc_get_products(array('include' => array($key)))[0]);
    else if($filter === null && $i < 8) array_push($proximas_exc, wc_get_products(array('include' => array($key)))[0]);
    $i++;
  }
  return $proximas_exc;
}


function aer_excursoes_apos_data($excursoes, $data_ref){
  $excs = array();
  $final_excs = array();
  foreach($excursoes as $excursao){
    $exc_id = $excursao -> get_id();
    $variacoes = $excursao -> get_available_variations();
    $data_inicial = $variacoes[0]['attributes']['attribute_dia'];
    $data_inicial = count(explode('/', $data_inicial)) == 3 ? $data_inicial : $data_inicial . "/" .date("Y");
    $data_inicial_std = explode('/', $data_inicial)[2] . '-' . explode('/', $data_inicial)[1] . '-' . explode('/', $data_inicial)[0];
    if(strtotime($data_inicial_std) > strtotime(date($data_ref))) $excs[$exc_id] = strtotime($data_inicial_std);
  }
  asort($excs);
  $i=0;
  foreach($excs as $key => $exc){
    if($i < 8) array_push($final_excs, wc_get_products(array('include' => array($key)))[0]);
    $i++;
  }
  return $final_excs;
}
?>
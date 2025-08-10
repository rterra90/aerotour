<?php

$currentDisplays = get_option('aer_home_displays');
if($currentDisplays === false){
  add_option('aer_home_displays', array(
    array(
      'nome' => 'Próximas excursões',
      'type' => 'proximas',
      'type_value' => null,
      'active' => true
    )
  ));
} 

?>
<?php
function cpf_mask($value){
  $_cpf = preg_replace("/\D/", '', $value);
  return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $_cpf);
}

function formatar_local_embarque($embarque_element, $_i){
  if(gettype($embarque_element) === 'string') return $embarque_element;
  else return $embarque_element[$_i];
}

function preco_item_cancel($order_id, $variation_id){
  $_order = wc_get_order($order_id);
  $_order_items = $_order->get_items();
  if(wc_get_order($order_id)->get_item_count() > 1){
    foreach($_order_items as $item){
      if($item -> get_variation_id() == $variation_id) return $item -> get_total();
    }
  }else{
    foreach($_order_items as $item){
      return $item -> get_total();
    }
  } 
}

function aer_icons($name, $_w, $_h ,$extensao = '.svg'){
  return '<i class="aer-icon ' . $name .'">
            <img width="' . $_w .'" height="' . $_h .'" src="' . get_stylesheet_directory_uri() . '/assets/icons/' . $name . $extensao .' " alt="Ícone ' . $name .'">
          </i>';
}

function registration_error_messages( $error ){
  return str_replace('Já existe uma conta com este nome de usuário. Escolha outro.','CPF já cadastrado! Faça o login ou <a href='.wp_lostpassword_url().'>recupere sua senha</a>.',$error);  
}
 /* Cor das badges de data das caravanas */
 function badge_color($qtd){
  if((int)$qtd > 10){
    return '';
  } elseif((int)$qtd === 0){
    return 'disp-red';
  } else {
    return 'disp-yellow';
  }; 
}

/* Retorna array com horários de um ponto de embarque de uma excursão */
function horarios_embarque($_emb_dias){
  $horarios_embarque = array();
  foreach($_emb_dias as $_emb_dia){
    foreach($_emb_dia as $horario => $status){
      if(!in_array($horario, $horarios_embarque)) array_push($horarios_embarque, $horario);
    }
  }
  return $horarios_embarque;
}

add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );
function custom_override_checkout_fields( $fields ) {
  unset($fields['billing']['billing_company']); //remover empresa
  unset($fields['billing']['billing_address_1']); //remover endereço 1
  unset($fields['billing']['billing_address_2']); //remover endereço 2
  unset($fields['billing']['billing_city']); //remover cidade
  unset($fields['billing']['billing_postcode']); //remover cep
  unset($fields['billing']['billing_country']); //remover país 
  unset($fields['billing']['billing_state']); //remover estado

  return $fields;
}
 


add_action( 'woocommerce_account_menu_items', 'custom_account_menu' );
function custom_account_menu($menu_links){
  unset( $menu_links[ 'downloads' ] );
  $menu_links[ 'customer-logout' ] = 'Sair';
	$menu_links = array_slice( $menu_links, 0, 5, true ) 
	+ array( 'minhas-reservas' => 'Minhas reservas' )
	+ array_slice( $menu_links, 5, NULL, true );
	
	return $menu_links;
}

add_action( 'init', 'add_endpoints' );
function add_endpoints(){
  add_rewrite_endpoint( 'minhas-reservas', EP_PAGES );
}

add_action('woocommerce_account_minhas-reservas_endpoint', 'minhas_reservas_endpoint_page_create');
function minhas_reservas_endpoint_page_create(){
   wc_get_template( 'myaccount/minhas-reservas.php' ); 
}

function validaCPF($cpf) {
 
  // $cpf = str_replace('.', '',$cpf_raw);
  // $cpf = str_replace('-', '',$cpf);
  // Extrai somente os números
  $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
   
  // Verifica se foi informado todos os digitos corretamente
  if (strlen($cpf) != 11) {
      return false;
  }

  // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
  if (preg_match('/(\d)\1{10}/', $cpf)) {
      return false;
  }

  // Faz o calculo para validar o CPF
  for ($t = 9; $t < 11; $t++) {
      for ($d = 0, $c = 0; $c < $t; $c++) {
          $d += $cpf[$c] * (($t + 1) - $c);
      }
      $d = ((10 * $d) % 11) % 10;
      if ($cpf[$c] != $d) {
          return false;
      }
  }
  return true;

}

//Datas formatadas para cards de excursão
function card_datas($datas){
  foreach($datas as $i => $data) {
    if($i===0){
      echo substr($data, 0, 5);
    } elseif($i === sizeof($datas) - 1){
      echo ' e ' . substr($data, 0, 5);
    } else{
      echo ', ' . substr($data, 0, 5);
    }
  };
}

//Converte data DMY para ISO
function data_to_iso($data_raw){ //$data_raw = dd/mm/YYYY
  return explode('/', $data_raw)[2] . '-' . explode('/', $data_raw)[1] . '-' . explode('/', $data_raw)[0];
}

//Converte data ISO para DMY
function data_to_dmy($data_raw){ //$data_raw = YYYY-mm-dd
  return explode('-', $data_raw)[2] . '/' . explode('-', $data_raw)[1] . '/' . explode('-', $data_raw)[0];
} 

function horario_formatado($_order, $index){
  $passageiro = json_decode(get_post_meta($_order -> get_id(), 'passageiro', true));
  if(gettype($passageiro -> embarque) === 'string') return substr($passageiro -> embarque, -6, -1);
  else return substr($passageiro -> embarque[$index], -6, -1);
}

function unicode_filter($str){
  $values = [['u00e1', 'á'], ['u00fa', 'ú'], ['u00ed', 'í'], ['u00e3', 'ã'], ['u00e7', 'ç'], ['u00e9', 'é'], ['u00ea', 'ê'], ['u00c1', 'Á'], ['u00c7', 'Ç'], ['u00c9', 'É'], ['u00f4', 'ô'], ['u00f4', 'ó']];
  foreach($values as $value){
    if(str_contains( $str, $value[0] )) $str = str_replace($value[0], $value[1], $str);
  };
  return $str;
}

function filter_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
  // Change text
  $coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( '<i class="bi bi-trash"></i>', 'woocommerce' ) . '</a>';

  return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3 );


// Adicionar o filtro ao texto de "obrigado pelo pedido"
add_filter('woocommerce_thankyou_order_received_text', 'customizar_texto_obrigado', 10, 2);
function customizar_texto_obrigado($texto, $pedido) {
    $novo_texto = "Confira os detalhes do pedido"; // Substitua pelo texto desejado
    return $novo_texto;
}

//Obtém informações de um embarque pelo ID
function get_embarque_by_id($emb_id, $value = 'nome'){
  global $wpdb;
  $return = $wpdb -> get_results("SELECT $value from aer_embarques WHERE id = $emb_id");
  $return = $return[0] -> {$value};
  return $return;
}

?>
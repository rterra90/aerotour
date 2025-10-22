<?php
add_action('wp_ajax_update_reserva', 'ajax_update_reserva');

add_action( 'wp_ajax_add_variation_to_cart', 'ajax_add_variation_to_cart' );
add_action( 'wp_ajax_nopriv_add_variation_to_cart', 'ajax_add_variation_to_cart' );
function ajax_add_variation_to_cart() {
    $product_id   = absint( $_POST['product_id'] );
    $variation_id = absint( $_POST['variation_id'] );
    $quantity     = absint( $_POST['quantity'] );
    $taxa     = $_POST['taxa'];
    $embarque     = $_POST['embarque'];
    $horario     = $_POST['horario'];
    $passageiros     = $_POST['passageiros'];

    $cart_item_data = array(
        'desconto_antecipado' => $_POST['desconto_antecipado'], //false ou string de data
    );

    WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, array(), $cart_item_data );

    // Retorna os fragments para atualizar o mini-carrinho
    WC_AJAX::get_refreshed_fragments();
    wp_die();
}




function ajax_update_reserva(){
  global $wpdb;
  $acao = $_POST['to'];
  $res_id = (int)$_POST['res_id'];
  
  //Define e executa a ação
  if($acao === 'cancelar'){
    $wpdb -> get_results("UPDATE `aer_reservas` SET `status`= 'cancel' WHERE ID = $res_id");
  } else {
    $wpdb -> get_results("UPDATE `aer_reservas` SET `status`= 'normal' WHERE ID = $res_id");
  }

  //Retorna a reserva atualizada
  $response = $wpdb -> get_results("SELECT * from aer_reservas WHERE ID = $res_id");
  wp_send_json_success($response);

}

// add_action('wp_ajax_get_reservas_excs', 'ajax_get_reservas_excs');
// function ajax_get_reservas_excs(){

//   $_ids = json_decode(str_replace('\\', '', $_GET['ids']));
//   $_excs = wc_get_products(array('include' => ['611']));

//   wp_send_json_success($_excs);
// }

add_action('wp_ajax_get_reservas', 'ajax_get_reservas');
function ajax_get_reservas(){
   global $wpdb;

   //Define o ID da variaçõo, se houver
   $variation_id = isset($_GET['variation_id']) ? sanitize_text_field($_GET['variation_id']) : null;

   //GET nas reservas
   if($variation_id){
    $response_r = $wpdb -> get_results("SELECT * FROM aer_reservas WHERE variation_id = $variation_id");
   } else {
    $response_r = $wpdb -> get_results("SELECT * FROM aer_reservas");
   }

   //Cria array com ID das excursões (variações) que têm passageiros
   $variations_ids = array_map(function ($r) {
    return $r -> variation_id;
   }, $response_r);
   $variations_ids = array_unique($variations_ids);
  
   //Armazena o objeto das excursões (variações) que têm passageiros
    $variacoes_com_passageiros_raw = get_posts(array('post_type' => 'product_variation', 'numberposts' => -1, 'include' => $variations_ids));

    //Formata as excursões e insere na array final
   $variacoes_com_passageiros_f = array();
   foreach($variacoes_com_passageiros_raw as $variacao){
    $key = 'id_' . $variacao -> ID;
    $nome_exc = substr($variacao -> post_title, 0, -13);
    $dia_exc = substr($variacao -> post_title, -10);
    $variacoes_com_passageiros_f[$key] = array($nome_exc, $dia_exc, $variacao -> ID);
   }


   $response = array($response_r, $variacoes_com_passageiros_f);

   wp_send_json_success($response);
}

// BUSCA USUÁRIOS COM OU SEM PARÂMETRO
add_action('wp_ajax_get_customers', 'ajax_get_customers');
function ajax_get_customers(){

  //Busca múltiplos IDS
  $users_ids = isset($_GET['data']['users_ids']) ? $_GET['data']['users_ids'] : null;
  if(isset($users_ids)){
    $users = array();
    if(!is_array($users_ids)) json_decode($users_ids);

    foreach($users_ids as $id) {
      $user = get_userdata($id);
      if ($user) {
          $users[] = array(
              'ID'       => $user->ID,
              'nome'     => $user->display_name,
              'email'    => $user->user_email,
          );
      }
    }

    wp_send_json_success($users);
  }

  //Verifica se há algum parâmetro e busca exclusivamente esse valor
  $param = isset($_GET['param']) ? sanitize_text_field($_GET['param']) : null;

  if($param){
    switch ($param) {
      case 'e-mail':
        $_ids = $_GET['ids'];

        // Array para armazenar os e-mails dos usuários
        $user_emails = array();
        foreach ($_ids as $_id) {
            $user_data = get_userdata($_id);
            if ($user_data) {
                $user_emails[] = $user_data->user_email ? $user_data->user_email : $user_data->user_login;
            }
        }
        wp_send_json_success($user_emails);
        break;
      default:
        # code...
        break;
    }
  }else{

    wp_send_json_success('Informe um parâmetro');
  }
}

// ENVIA EMAIL
// Alterar o nome do remetente
add_filter('wp_mail_from_name', 'personalizar_remetente_nome');
function personalizar_remetente_nome($default) {
    return get_bloginfo('name'); 
}

// Alterar o e-mail do remetente
add_filter('wp_mail_from', 'personalizar_remetente_email');
function personalizar_remetente_email($default) {
    return 'contato@aerotour.com.br';
}

add_action('wp_ajax_send_email', 'ajax_send_email');
function ajax_send_email(){
  if(isset($_GET['template'])) {
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $template = sanitize_text_field(($_GET['template']));

    if($template === "convite-grupo-wpp"){
      $variation_id = $_GET['variation_id'];
      $variation = get_post($variation_id);

      if($variation){
        $emails = obter_emails_por_produto($variation_id);
        // $emails = [''];

        //para ser consumido no template do e-mail
        $email_params = array(
          'nome_exc' => substr($variation -> post_title, 0, -13), 
          'dia_exc' => substr($variation -> post_title, -10), 
          'link' => get_post_meta($variation_id, 'link_wpp', true)
        );
        $subject = 'Grupo de WhatsApp - Excursão ' . $email_params['nome_exc'] . ' (' . $email_params['dia_exc'] . ') - Aerotour';
        $email_body = get_email_body('email-convite-grupo-wpp', $email_params);


        $resultado_dos_envios = [];
        foreach($emails as $_i => $email){
          if($_i !== 0){
            if($_i % 10 === 0) sleep(10); //10 seg de pausa a cada 10 e-mails enviados
          }
          $resultado_dos_envios[] = array(
            'e-mail' => $email,
            'resultado' => wp_mail($email, $subject, $email_body, $headers),
            'timestamp' => time(),
          );

        }

        wp_send_json_success($resultado_dos_envios);

      } else{
        wp_send_json_error( 'Excursão não encontrada' );
      }
    }else if($template = "follow-up-cupom"){
      $codes = explode(',', $_GET['codes']);
      
      function verificar_pedidos_user_cupom($cliente_id, $cupons_codigos) {
        // Obter todos os pedidos do cliente
        $args = array(
            'customer_id' => $cliente_id,
            'post_type'   => 'shop_order',
            'post_status' => array('wc-completed', 'wc-processing', 'wc-on-hold') // Status relevantes
        );
        $pedidos = wc_get_orders($args);
    
        // Verificar se algum pedido utilizou os cupons especificados
        foreach ($pedidos as $pedido) {
            $cupons_utilizados = $pedido->get_coupon_codes(); // Obter códigos de cupons usados no pedido
    
            // Checar se algum dos códigos corresponde aos fornecidos
            foreach ($cupons_utilizados as $cupom) {
                if (in_array($cupom, $cupons_codigos)) {
                    return $pedido->get_id(); // Retorna o ID do pedido que usou um dos cupons
                }
            }
        }
    
        return null; // Retorna null se nenhum pedido usou os cupons
      }

      $participantes = [];
      foreach($codes as $_code){
        $coupon = new WC_Coupon($_code);
        $coupon_id = $coupon->get_id();
        $allowed_customers = get_post_meta($coupon_id, 'allowed_customers', true);
        if($allowed_customers !== '') $allowed_customers_obj = json_decode($allowed_customers);
        if(isset($allowed_customers_obj)) $participantes = array_merge($participantes, $allowed_customers_obj);
      }

      $participantes_emails_query= array_map(function($_user_id){
        $usou_cupom = verificar_pedidos_user_cupom($_user_id, ["roleta5", "roleta10", "roleta15", "roleta20"]);
        if($usou_cupom) return $usou_cupom;
        else{
          $dados_usuario = get_userdata((int)$_user_id );
          if($dados_usuario) return $dados_usuario -> user_email;
          else return 'Usuário não encontrado';
        };
      }, $participantes);

      $participantes_emails = array_values(array_filter($participantes_emails_query, function($_v) {
        return !is_numeric($_v);
      }));
      // $participantes_emails = ['rterragd@hotmail.com'];

      foreach($participantes_emails as $_i => $_email){
              //para ser consumido no template do e-mail
              $user_destinatario = get_user_by('email', $_email);
              $user_destinatario_cupons = get_user_meta($user_destinatario -> ID, 'cupons', true);
              $user_destinatario_cupons = json_decode($user_destinatario_cupons);

              $cupons_da_campanha = ['3772', '3773', '3774', '3775'];
              $interseccao = array_intersect($user_destinatario_cupons, $cupons_da_campanha);

              if(is_array($interseccao) && sizeof($interseccao) > 0){
                $cupom_cliente = new WC_Coupon($interseccao[0]);
                $cod_cupom_cliente = $cupom_cliente->get_code();
              } else {
                $cod_cupom_cliente = ' ';
              }

              $email_params = array(
                'nome_cliente' => $user_destinatario->first_name, 
                'cupom_cliente' => $cod_cupom_cliente,
              );
              $subject = 'Seu cupom da Aerotur está esperando por você!';
              $email_body = get_email_body('email-follow-up-cupom', $email_params);
      
              $resultado_dos_envios = [];
              if($_i !== 0){
                if($_i % 10 === 0) sleep(10); //10 seg de pausa a cada 10 e-mails enviados
              }
              $resultado_dos_envios[] = array(
                'e-mail' => $_email,
                'resultado' => wp_mail($_email, $subject, $email_body, $headers),
                'timestamp' => time(),
              );
              
      }


      
      wp_send_json_success( $resultado_dos_envios );
    }


    // $conteudo_email = get_email_body($template);
  } else {
    wp_send_json_error( 'Erro ao localizar template' );
  }
  wp_die();
}

function get_email_body($email_template, $email_params) {
  $arquivo_email = __DIR__ . "/emails/". $email_template . ".php";

  if (file_exists($arquivo_email)) {
      ob_start(); // Inicia o buffer para capturar a saída do arquivo
      include $arquivo_email;
      return ob_get_clean(); // Retorna o conteúdo como string e limpa o buffer
  } else {
      return "Template não encontrado.";
  }
}

function obter_emails_por_produto($produto_id) {
  global $wpdb; 

  // Array para armazenar os e-mails
  $emails = [];

  // Passo 1: Consultar a tabela 'aer_reservas' para obter os user_ids
  $user_ids = $wpdb->get_col(
      $wpdb->prepare(
          "SELECT user_id FROM aer_reservas WHERE variation_id = %d", 
          $produto_id
      )
  );

  // Filtrar user_ids para ignorar valores iguais a 0
  $user_ids = array_values(array_filter($user_ids, function($user_id) {
      return $user_id != 0;
  }));

  // Passo 2: Obter os e-mails dos usuários correspondentes
  if (!empty($user_ids)) {
      // Transformar a array de user_ids em uma lista separada por vírgulas para usar na consulta IN()
      // $placeholders = implode(',', array_fill(0, count($user_ids), '%d'));
      // $query = "SELECT user_email FROM wp_users WHERE ID IN ($placeholders)";
      // $emails = $wpdb->get_col($wpdb->prepare($query, $user_ids));

      foreach($user_ids as $_id){
        $user = get_userdata($_id);
        $emails[] = $user -> user_email;
      }
  }

  // $emails = array_filter($emails, function($_email){
  //   return is_email($_email);
  // });
  return $emails;
}

// add_action('wp_ajax_get_customers', 'ajax_get_customers');


/* SALVA DEFINIÇÕES DOS DISPLAYS DA PÁGINA INICIAL */
add_action('wp_ajax_save_home_cards', 'ajax_save_home_cards');
function ajax_save_home_cards(){
  $submitData = $_POST['submitData'];
wp_send_json_success(update_option('aer_home_displays', $submitData));
}

/* SALVA PADRÕES DE HORÁRIOS */
add_action('wp_ajax_save_padroes_horarios', 'ajax_save_padroes_horarios');
function ajax_save_padroes_horarios(){
  $data = $_POST['data'];
  if(update_option('padroes_horarios', $data)) wp_send_json_success($data);
  else wp_send_json_error('Erro ao salvar padrão de embarque!');
}

/* BUSCA USUÁRIO */
add_action('wp_ajax_busca_usuario', 'ajax_busca_usuario');
function ajax_busca_usuario(){
  //  wp_send_json_success($_POST['value']);
  $user = get_user_by($_POST['type'], $_POST['value']);
  $user_nome_completo = $user -> first_name . ' ' . $user -> last_name;
  $user_return = array(
    'nome_completo' => $user_nome_completo,
    'cpf' => $user -> nickname,
    'rg' => get_user_meta($user -> ID, 'rg', true),
    'rg_orgao_exp' => get_user_meta($user -> ID, 'rg_orgao_exp', true),
    'telefone' => get_user_meta($user->ID)['billing_phone'][0],
    'id' => $user -> ID,
    'cupons' => json_decode(get_user_meta($user -> ID, 'cupons', true))
  );
 wp_send_json_success($user_return);
}

/* ATRIBUI/REMOVE CUPOM DE UM USUÁRIO */
add_action('wp_ajax_atribuir_cupom', 'ajax_atribuir_cupom');
function ajax_atribuir_cupom(){
  $coupon_id = wc_get_coupon_id_by_code($_POST['code']);
  if(isset($coupon_id)){
    $coupon_customers_ids = get_post_meta($coupon_id, 'allowed_customers', true);
		$customer_cupons_meta = get_user_meta($_POST['user_id'], 'cupons', true);
    $return_value;

    //atualiza a usermeta 'cupons'
    if($customer_cupons_meta === '') $customer_cupons_meta_obj = [$_POST['code']];
    else {
      $customer_cupons_meta_obj = json_decode($customer_cupons_meta);
      $return_value = in_array($_POST['code'], $customer_cupons_meta_obj) ? 'Removido com sucesso' : 'Adicionado com sucesso';

      //verifica de usuário já tem o cupom
      if(in_array($_POST['code'], $customer_cupons_meta_obj)){
        foreach($customer_cupons_meta_obj as $i => $_code){
          if(strtoupper($_code) === strtoupper($_POST['code'])) array_splice($customer_cupons_meta_obj, $i, 1);
        }
      }else array_push($customer_cupons_meta_obj, $_POST['code']);
      
    }
    $customer_cupons_meta_a_str = json_encode($customer_cupons_meta_obj);
    update_user_meta($_POST['user_id'], 'cupons', $customer_cupons_meta_a_str);

    //se for um cupom restrito, atualiza a meta 'allowed_customers' do cupom
    if(get_post_meta($coupon_id, 'restrict_customers_coupon', true) === 'yes'){

      if($coupon_customers_ids === '') $coupon_customers_ids_obj = [$_POST['user_id']];
      else{
        $coupon_customers_ids_obj = json_decode($coupon_customers_ids);

        //verifica se já está na array 'allowed_customers'
        if(in_array($_POST['user_id'], $coupon_customers_ids_obj)){
          foreach($coupon_customers_ids_obj as $i => $_user_id){
            if($_user_id === +$_POST['user_id']) array_splice($coupon_customers_ids_obj, $i, 1);
          }
        }else array_push($coupon_customers_ids_obj, +$_POST['user_id']);
      }
      $coupon_customers_ids_a_str = json_encode($coupon_customers_ids_obj);
      update_post_meta($coupon_id, 'allowed_customers', $coupon_customers_ids_a_str);
    }

    wp_send_json_success($return_value);
  }
}

/* DEFINE LINHA DE UM PASSAGEIRO */
add_action('wp_ajax_define_linha_passageiro', 'ajax_save_define_linha_passageiro');
function ajax_save_define_linha_passageiro(){
  $variacao_id = $_POST['variacao_id'];
  $linha = $_POST['linha'];
  $ref = $_POST['passageiro_ref'];
  $dia = get_post_meta($variacao_id)['attribute_dia'][0];
  $passageiros_variacao = json_decode(get_post_meta($variacao_id, 'passageiros', true));
  foreach($passageiros_variacao as $pv){
    if($pv -> cpf === $ref) $pv -> linha = $linha;
  }
  $passageiros_variacao_final_string = json_encode($passageiros_variacao);
  update_post_meta($variacao_id, 'passageiros', $passageiros_variacao_final_string);

  $obj_passageiros = array();
  foreach(wc_get_product(wp_get_post_parent_id($variacao_id))->get_available_variations() as $var){
    $_key = 'id'.$var['variation_id'].'__'.str_replace('/', '_', $var['attributes']['attribute_dia']);
    $obj_passageiros[$_key] = json_decode(get_post_meta($var['variation_id'], 'passageiros', true));
  }
  wp_send_json_success($obj_passageiros);
}

/* SALVA DEFINIÇÕES DE UMA VARIAÇÃO */
add_action('wp_ajax_save_definicoes_variacao', 'ajax_save_definicoes_variacao');
function ajax_save_definicoes_variacao(){
  $linhas_sort_rule = $_POST['definicoes_a']; //'definicoes_a' tem apenas as linhas no momento
  $excursao_id = $_POST['excursao_id'];
  $variacao_id = $_POST['variacao_id'];
  $passageiros_variacao = json_decode(get_post_meta($variacao_id, 'passageiros', true));


  foreach($linhas_sort_rule as $key => $locais_embarque){
    foreach($locais_embarque as $local_embarque){
      foreach($passageiros_variacao as $passageiro){
        if(unicode_filter(substr($passageiro -> embarque, 0, -8)) === unicode_filter(substr($local_embarque, 0, -8))) $passageiro -> linha = $key;
      }

    }
  }

  $passageiros_a_string = json_encode($passageiros_variacao);
  update_post_meta($variacao_id, 'passageiros', $passageiros_a_string);
  wp_send_json_success($passageiros_variacao);
}

/* ATIVA/DESATIVA LINHAS NA VARIAÇÃO */
add_action('wp_ajax_toggle_linhas', 'ajax_toggle_linhas');
function ajax_toggle_linhas() {
  $meta_var_linhas = get_post_meta($_POST['variacao_id'], 'tem_linhas', true);
  $meta_var_linhas_qtd = $meta_var_linhas === '' ? 1 : (int) $meta_var_linhas;
  $variacao_id = $_POST['variacao_id'];

  if($meta_var_linhas_qtd === 1) update_post_meta($variacao_id, 'tem_linhas', 2);
  elseif ($meta_var_linhas_qtd > 1){
    $passageiros_var = json_decode(get_post_meta($variacao_id, 'passageiros', true));
    foreach($passageiros_var as $pv){
          $pv -> linha = '';
      }
      $new_passageiros_string = json_encode($passageiros_var);
      update_post_meta($_POST['variacao_id'], 'tem_linhas', '');
      update_post_meta($_POST['variacao_id'], 'passageiros', $new_passageiros_string);
    }

    wp_send_json_success('desativou');

  wp_die(); // Exit silently (Always at the end to avoid an Error 500)
}

/* LIDA COM OPCÕES DO WORDPRESS */
add_action('wp_ajax_handle_wp_option', 'handle_wp_option');
function handle_wp_option(){
  global $wpdb;
  $key = $_POST['data']['key'];

  if(isset($_POST['data']['newValue'])){
    $response = update_option( $_POST['data']['key'], $_POST['data']['newValue'], true );
    if($response) wp_send_json_success('Valor atualizado');
    else wp_send_json_error('Erro ao atualizar');
  }


}

/* ADICIONA/REMOVE PONTOS DE EMBARQUE */
add_action('wp_ajax_excluir_embarque', 'excluir_embarque');
function excluir_embarque(){
  global $wpdb;
  $id_para_remover = $_POST['data']['id'];
  $tabela_embarques = $wpdb->prefix . 'embarques';

  $response = $wpdb->delete($tabela_embarques, array('id' => $id_para_remover));

  if($response > 0){
    wp_send_json_success('Embarque excluído com sucesso!');
  }else{
    wp_send_json_error('Erro ao excluir o embarque.');
  }
}

add_action('wp_ajax_add_embarque', 'add_embarque');
function add_embarque(){
  global $wpdb;
  $data = $_POST['data'];
  $nome_embarque = $data['nome'];
  $endereco_embarque = $data['endereco'];
  $obs_embarque = $data['obs'];
  $link_embarque = $data['link_mapa'];
  $id_embarque = isset($data['id']) ? $data['id'] : false; //apenas haverá ID se estiver editando um embarque já existente

  if(empty($nome_embarque) || empty($endereco_embarque)){
    wp_send_json_error('Dados incompletos. Nenhum dado foi salvo.');
  }else{
    $tabela_embarques = $wpdb->prefix . 'embarques';
    $novos_dados = array(
      'nome' => $nome_embarque,
      'endereco' => $endereco_embarque,
      'obs' => $obs_embarque,
      'link_mapa' => $link_embarque,
    );
    
    if($id_embarque){
      //Atualiza no banco de dados
      $res = $wpdb->update($tabela_embarques, $novos_dados, array('id' => $id_embarque));

      if($res) wp_send_json_success('Informações atualizadas com sucesso!');
      else wp_send_json_error('Erro ao salvar. Tente novamente.');

    }else{
      //Insere no banco de dados
      $wpdb->insert($tabela_embarques, $novos_dados);

      //Obtém o ID do registro inserido
      $new_id = $wpdb->insert_id;
      if($new_id) {

        //Insere o ID do novo embarque na option 'preset_ordem_embarques'
        if(get_option('preset_ordem_embarques')){
          $current_value = get_option('preset_ordem_embarques');
          array_unshift($current_value, $new_id);
          update_option('preset_ordem_embarques', $current_value );
        }else{
          update_option('preset_ordem_embarques', array($new_id));
        }

        wp_send_json_success(array('new_id' => $new_id, 'message' => 'Embarque adicionado com sucesso!'));

      }else wp_send_json_error('Erro ao salvar. Tente novamente.');

    }


  }
}


/* ATIVA/DESATIVA CUPONS POR QR CODE */
add_action('wp_ajax_toggle_qr_coupon', 'ajax_toggle_qr_coupon');
function ajax_toggle_qr_coupon(){
  $current_value = get_option('qr_code_coupon_status');
  $new_value = array(
    'status' => $current_value['status'] === 'desativado' || $current_value === false ? 'ativado' : 'desativado',
    'code' => null,
  );
  update_option('qr_code_coupon_status', $new_value);
}
add_action('wp_ajax_define_coupon', 'ajax_define_coupon');
function ajax_define_coupon(){
  $coupon_code = $_POST['coupon_code'];
  $type = $_POST['define_coupon_type'];

  if($type === 'qr_code'){
    $new_option_value = get_option("qr_code_coupon_status");
    $new_option_value['code'] = $coupon_code;
    update_option("qr_code_coupon_status", $new_option_value);
  }else if($type === 'new_register'){
    $new_option_value = get_option("new_register_coupon_status");
    $new_option_value['code'] = $coupon_code;
    update_option("new_register_coupon_status", $new_option_value);
  }
  wp_send_json_success('definiu');

}

/* ATIVA/DESATIVA CUPONS PARA NOVO CADASTRO */
add_action('wp_ajax_toggle_new_register_coupon', 'ajax_toggle_new_register_coupon');
function ajax_toggle_new_register_coupon(){
  $current_value = get_option('new_register_coupon_status');
  $new_value = array(
    'status' =>  $current_value === '' || $current_value['status'] === 'desativado' ? 'ativado' : 'desativado',
    'code' => null,
  );
  update_option('new_register_coupon_status', $new_value);
}

/* CHECK-IN */
add_action('wp_ajax_check_in', 'ajax_check_in');
function ajax_check_in(){
  // $passageiros = json_decode(get_post_meta($_POST['variation_id'], 'passageiros', true));
  global $wpdb;
  $variation_id = $_POST['variation_id'];
  $passageiros = $wpdb->get_results("SELECT * FROM aer_reservas WHERE variation_id = $variation_id");

  if($_POST['nome'] === ''){
    $response = [$passageiros, $tem_linhas === '' ? false : $tem_linhas, $_POST['variation_id']];
    wp_send_json_success($response);
  }else{
    //tem nome, faz check-in
    $key = $_POST['sentido'];
    $response = '';
    foreach($passageiros as $passageiro){

      if($passageiro -> p_cpf == $_POST['doc']){
        $new_check_in_status = $passageiro -> $key == 0 ? 1 : 0;
        $p_cpf = $passageiro -> p_cpf;
        $wpdb->query("UPDATE `aer_reservas` SET $key = $new_check_in_status WHERE p_cpf = $p_cpf AND variation_id = $variation_id");

        $check_in_saida = $wpdb->get_results("SELECT saida from aer_reservas WHERE p_cpf = $p_cpf AND variation_id = $variation_id")[0] -> saida == 1 ? true : false;
        $check_in_volta = $wpdb->get_results("SELECT volta from aer_reservas WHERE p_cpf = $p_cpf AND variation_id = $variation_id")[0] -> volta == 1 ? true : false;
        
        $response = array('saida' => $check_in_saida, 'volta' => $check_in_volta);
        wp_send_json_success($response);
      }
    }    
    wp_send_json_success([$response, [$passageiros]]);
  }
}

add_action('wp_ajax_criar_campanha_cupons', 'criar_campanha_cupons');
function criar_campanha_cupons(){
  global $wpdb;
  $tabela_camp_premios = $wpdb->prefix . 'camp_premios';

  $novos_dados = array(
    'nome_campanha' => $_POST['data']['nome_campanha'],
    'tipo' => $_POST['data']['tipo'],
    'valido_de' => $_POST['data']['valido_de'],
    'valido_ate' => $_POST['data']['valido_ate'],
  );
  if($wpdb->insert($tabela_camp_premios, $novos_dados)){
    wp_send_json_success('Campanha criada com sucesso!');
  }else{
    wp_send_json_error('Erro na criação da campanha...');
  }
  


}

?>
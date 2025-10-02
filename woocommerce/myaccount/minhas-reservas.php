<?php
defined( 'ABSPATH' ) || exit;
global $wpdb;
$current_user_id = wp_get_current_user()->ID;

$customer_orders = wc_get_orders(array(
  'customer_id' => $current_user_id,
));

//Função relacionada à forma antiga de gerar as reservas
function reserva_status($_order_id, $_variation_id, $_dia_evento){
  global $wpdb;
  $db_cancelamento = $wpdb->get_results("SELECT * FROM aer_cancelamentos WHERE `order_id` = $_order_id AND `variation_id` = $_variation_id");
  $dia_evento_std = explode('/', $_dia_evento)[2] . '-' . explode('/', $_dia_evento)[1] . '-' . explode('/', $_dia_evento)[0];
  $timestamp_dia_evento = strtotime($dia_evento_std);
  $timestamp_dia_atual = strtotime(date('Y-m-d'));
  if(sizeof($db_cancelamento) > 0) return 'cancelamento_' . $db_cancelamento[0] -> status;
  else if($timestamp_dia_atual > $timestamp_dia_evento + 43200) return 'passada';
  else return 'normal';
}

if(isset($_POST['to'])){
  $variation_id = isset($_POST['variation_id']) ? $_POST['variation_id'] : null;
  $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : null;
  if($_POST['to'] === 'cancel'){
    //POST - solicitação de cancelamento de reserva
    $motivo = isset($_POST['motivo']) ? sanitize_text_field($_POST['motivo']) : null;
    $dia_event = wc_get_product($variation_id)->get_attribute('dia');
    $cancelamento_db_save = array(
      'variation_id' => $variation_id,
      'order_id' => $order_id,
      'motivo' => $motivo,
      'data_solic' => date('Y/m/d'),
      'status' => 'pending',
      'taxa' => 90,
    );
    $wpdb->insert('aer_cancelamentos', $cancelamento_db_save);


    $passageiros_var = json_decode(get_post_meta($variation_id, 'passageiros', true));
    foreach($passageiros_var as $pv){
      if($pv -> cpf === wp_get_current_user() -> nickname && $pv -> status === 'normal') $pv -> status = 'Cancelado pelo usuário';    
    }

    $passageiros_var_str = json_encode($passageiros_var, JSON_UNESCAPED_UNICODE);
    update_post_meta($variation_id, 'passageiros', $passageiros_var_str);
  
  }else if($_POST['to'] === 'alterar_embarque'){
    $order_index = isset($_POST['order_index']) ? $_POST['order_index'] : null;
    $p_cpf = isset($_POST['p_cpf']) ? $_POST['p_cpf'] : null;
    $p_novo_embarque = isset($_POST['novo_local_embarque']) ? $_POST['novo_local_embarque'] : null;
    $passageiros_var = json_decode(get_post_meta($variation_id, 'passageiros', true));
    foreach($passageiros_var as $pv){
      if($pv -> cpf === $p_cpf){
        $pv -> embarque = $p_novo_embarque;
        $pv -> linha = '';
      } 
    }
    $passageiros_var_str = json_encode($passageiros_var);
    update_post_meta($variation_id, 'passageiros', $passageiros_var_str);

    $order_passageiro = json_decode(wc_get_order($order_id) -> get_meta('passageiro'));

    if(gettype($order_passageiro -> embarque) === 'string') $order_passageiro -> embarque = $p_novo_embarque;
    else $order_passageiro -> embarque[order_index] = $p_novo_embarque;

    $passageiro_a = json_encode($order_passageiro);
    update_post_meta($order_id, 'passageiro', $passageiro_a);
  }
}

// $todas_reservas_db = $wpdb -> get_results("SELECT * FROM `aer_reservas` WHERE order_user_id = $current_user_id");
// $proprias_reservas_db = $wpdb -> get_results("SELECT * FROM `aer_reservas` WHERE user_id = $current_user_id");

$reservas_db = $wpdb -> get_results("SELECT * FROM `aer_reservas` WHERE user_id = $current_user_id OR order_user_id = $current_user_id");

global $customer_reservas;
$customer_reservas = array();

function ordenar_por_data_proxima($a, $b) {
  $data_atual = new DateTime();
  $data_a = new DateTime($a['data_std']);
  $data_b = new DateTime($b['data_std']);
  
  // Calcula a diferença em dias entre a data atual e cada data
  $diferenca_a = abs($data_atual->diff($data_a)->days);
  $diferenca_b = abs($data_atual->diff($data_b)->days);
  
  // Compara as diferenças
  return $diferenca_a - $diferenca_b;
}

// função que formata as reservas, tanto as vindas da order (antigo) quanto as vindas do DB (novo), e as insere em uma array final
function formatar_reserva($_reserva, $order_id = null){
  $variacao = wc_get_product($_reserva['variation_id']);
  $reserva = array(
    'variation_id' => $_reserva['variation_id'],
    'order_id' => isset($_reserva['order_id']) ? $_reserva['order_id'] : null,
    'user_id' => isset($_reserva['user_id']) ? $_reserva['user_id'] : null,
    'order_user_id' => isset($_reserva['order_user_id']) ? $_reserva['order_user_id'] : null,
    'img' => $variacao->get_image('thumb'),
    'local_evento' => get_post_meta(get_post_parent($_reserva['variation_id']) -> ID, 'local_evento', true),
    'nome' => $variacao->get_title(),
    'data' => $variacao->get_attribute('dia'),
    'data_std' => explode('/', $variacao->get_attribute('dia'))[2] . '-' . explode('/', $variacao->get_attribute('dia'))[1] . '-' . explode('/', $variacao->get_attribute('dia'))[0],
    'passageiro' => array(
      'nome_completo' => isset($_reserva['p_nome']) ? $_reserva['p_nome'] : '',
      'doc' => isset($_reserva['p_cpf']) ? $_reserva['p_cpf'] : '',
      'telefone' => isset($_reserva['p_telefone']) ? $_reserva['p_telefone'] : '',
    ),
    'horario' => isset($_reserva['horario']) ? $_reserva['horario'] : '00:00',
    'url' => get_permalink(get_post_parent($_reserva['variation_id']) -> ID),
    'horario' => isset($_reserva['horario']) ? $_reserva['horario'] : '00:00',
    'local_embarque' => isset($_reserva['embarque']) ? $_reserva['embarque'] : '',
  );
  if(isset($order_id)) $reserva['status'] = reserva_status($order_id, $_reserva['variation_id'], $variacao->get_attribute('dia'));
  else $reserva['status'] = $_reserva['status'];

  return $reserva;
}

// Insere na array as reservas antigas, obtidas pela order
foreach($customer_orders as $order){
  if('' !== $order -> get_meta('passageiro') && $order -> get_status() === 'completed'){

    foreach($order -> get_items() as $key => $order_item){
      array_push($customer_reservas, formatar_reserva($order_item, $order -> get_id()));
    }
  }
}

// Insere na array as reservas novas, obtidas pelo DB
foreach($reservas_db as $reserva_db){
  $reserva_formatada = formatar_reserva(json_decode(json_encode($reserva_db, JSON_UNESCAPED_UNICODE), true));


  array_push($customer_reservas, $reserva_formatada);
}



$customer_reservas_final = array();
foreach($customer_reservas as $index => $customer_reserva){

  if($customer_reserva['local_embarque'] !== ''){

    $reserva_dep = ($customer_reserva['user_id'] == get_current_user_id()) && ($customer_reserva['order_user_id'] != get_current_user_id()) ? true : false;
    $reserva_comprada_global = get_current_user_id() == $customer_reserva['order_user_id'];

    if($reserva_dep){
        
      array_push($customer_reservas_final, $customer_reserva);

    }else if($reserva_comprada_global){
      if($customer_reserva['user_id'] == get_current_user_id()){
          $variation_id = $customer_reserva['variation_id'];
        $dependentes = array_filter($customer_reservas, function($r) use ($variation_id){
          if (($r['order_user_id'] == get_current_user_id()) && ($r['user_id'] != get_current_user_id()) && ($r['variation_id'] == $variation_id)) return $r;
        });

        $customer_reserva['dependentes'] = $dependentes;
        array_push($customer_reservas_final, $customer_reserva);

      }else{
        // reserva comprada PARA OUTRO USER ID em que o user comprador não tem reserva para si próprio;
        $reservas_matrizes_ids = array_map(function($r){
          if(($r['user_id'] == get_current_user_id()) && ($r['user_id'] == $r['order_user_id'])) return $r['variation_id']; 
        }, $customer_reservas);
        if(!in_array($customer_reserva['variation_id'], $reservas_matrizes_ids)) array_push($customer_reservas_final, $customer_reserva);

      }
    }
  } else array_push($customer_reservas_final, $customer_reserva);
}

usort($customer_reservas_final, 'ordenar_por_data_proxima');


$customer_reservas_ativas = array();
$customer_reservas_passadas = array();

foreach($customer_reservas_final as $c_res){
    if($c_res['status'] === 'passada'){
        array_push($customer_reservas_passadas, $c_res);
    }else if($c_res['status'] === 'normal'){
        $data_std = explode('/', $c_res['data'])[2] . '-' . explode('/', $c_res['data'])[1] . '-' . explode('/', $c_res['data'])[0];
        if((strtotime($data_std) + 360000) < strtotime('now')) array_push($customer_reservas_passadas, $c_res);
        else array_push($customer_reservas_ativas, $c_res);
    }
}

$customer_reservas_cancel = array_filter($customer_reservas_final, function($c_res){
    if(str_starts_with($c_res['status'], "cancel")) return $c_res;
});

?>
<section id="minhas-reservas">
  <h1>Minhas reservas</h1>
  <p>Aqui você pode visualizar e gerenciar cada uma de suas reservas nas excursões da Aerotour.</p>
  
  <?php 
    if(isset($_POST['to'])){
      ?>
        <div class="aer-toast">
          <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <div class="toast-inner p-3">
            <p class="mb-0"><?= $_POST['to'] === 'alterar_embarque' ? "Local de embarque alterado com sucesso!" : "Cancelamento de reserva solicitado com sucesso!"; ?></p>
          </div>
        </div>
      <?php
    }
  ?>

  <div class="reservas py-3 reservas-wrapper">
    <h2>Proximas</h2>
    <?php
      if(sizeof($customer_reservas_ativas) > 0){
        ?>
          <div class="proximas reservas-inner">
            
            <div class="row">
              <?php
                foreach($customer_reservas_ativas as $reserva){


if ( $reserva['variation_id'] == 5302 ) : //5302
?>
<style>
  #avisoModal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #avisoModalContent {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    max-width: 500px;
    text-align: center;
    position: relative;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  #avisoModalContent h2 {
    color: #c00;
    margin-bottom: 20px;
  }
  #avisoModalContent p {
    margin-bottom: 25px;
    font-size: 1.075rem!important;
    line-height: 1.5;
  }
  #avisoModalContent a.whatsapp-btn {
    background-color: #25D366;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
  }
  #closeModalBtn {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: #999;
  }
  #closeModalBtn:hover {
    color: #333;
  }
</style>

<div id="avisoModal">
  <div id="avisoModalContent">
    <button id="closeModalBtn" aria-label="Fechar modal">&times;</button>
    <h2>Atenção</h2>
    <p class="mb-3">As reservas para a excursão Avenged Sevenfold em SP permanecem válidas e serão automaticamente transferidas para a nova data assim que for divulgada.</p>
    <p class="mb-3">Não é necessário realizar nenhuma ação para manter sua reserva ativa.</p>
    
    <a class="whatsapp-btn main-close-btn" href="#"">Fechar</a>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("avisoModal");
  const closeBtn = document.getElementById("closeModalBtn");
  const closeMainBtn = document.querySelector(".main-close-btn");

  // Exibe o modal com pequeno delay
  setTimeout(() => {
    modal.style.display = "flex";
  }, 500);

  // Fecha ao clicar no botão
  closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  closeMainBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  // Fecha ao clicar fora do conteúdo
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.style.display = "none";
    }
  });
});
</script>
<?php endif;



                  ?>
                  <div class="card-wrapper col-md-4 col-8">
                  <?php
                    if($reserva['status'] === 'normal'){
                      // include 'modals/cancelar-reserva-modal.php';
                      include 'modals/passageiros-reserva-modal.php';
                    }
                  ?>
                    <div class="card <?= $reserva['status']; ?>">
                      <div class="card-header"><?= substr($reserva['nome'], 0, -5); ?></div>
                      <div class="card-img"><?= $reserva['img']; ?></div>
                      
                      <div class="card-body">
                        <p>Data: <?= $reserva['data'] === "31/12/2026" ? "A definir..." : $reserva['data']; ?></p>
                        <p>Embarque: <?= $reserva['local_embarque']; ?></p>
                        <p>Horário: <?= substr($reserva['horario'], 0, -3); ?></p>
                        <p>Local do evento: <?= $reserva['local_evento']; ?></p>

                        <div class="reserva-options-wrapper">
                          <span class="options-btn" onclick="openModalBox('reservaOptions<?= $reserva['variation_id']; ?>')">•••</span>
                          <div class="options-menu d-none" id="reservaOptions<?= $reserva['variation_id']; ?>">
                            <nav>
                              <ul data-variation-id="<?= $reserva['variation_id']; ?>">
                                <li><a href="<?= $reserva['url']; ?>">Ver página da excursão</a></li>
                                <?php
                                  if($reserva['status'] === 'normal'){
                                    ?>
                                      <li data-bs-toggle="modal" data-bs-target="#passageiros-reserva-<?= $reserva['variation_id']; ?>">Ver passageiros</li>
                                      <li class="cancelar" data-bs-toggle="modal" data-bs-target="#cancelar-reserva-<?= $reserva['variation_id']; ?>">Cancelar reserva</li>
                                    <?php
                                  }
                                ?>
                                
                              </ul>
                            </nav>
                          </div>
                        </div>

                        <?php
                          $qtd_passageiros = isset($reserva['dependentes']) ? sizeof($reserva['dependentes']) + 1 : 1;
                          if($qtd_passageiros > 1){
                            ?>
                              <div class="reserva-passageiros-icone" data-qtd="<?= $qtd_passageiros; ?>">
                                <?= aer_icons('person', 24, 24); ?>
                              </div>
                            <?php
                          }

                          $link_grupo_wpp = get_post_meta($reserva['variation_id'], 'link_wpp', true);

                          if($link_grupo_wpp){
                            ?>
                            <div class="wpp-link">
                              <a href="<?= $link_grupo_wpp; ?>" target="_blank"><?= aer_icons('whatsapp', 14, 14);?>Acesse o grupo</a>
                            </div>
                            <?php
                          }
                        ?>

                        

                        
                      </div>
                    </div>
                  </div>
                <?php
                }
              ?>
            </div>
          </div>
        <?php
      } else echo '<p>Nada aqui por enquanto...</p>';
    ?>
  </div>

  <?php
    if(sizeof($customer_reservas_passadas) > 0){
      ?>
    <div id="reservas_passadas_container" class="reservas mt-3">
      <h2>Anteriores</h2>
      <ul>
        <?php
          foreach(array_reverse($customer_reservas_passadas) as $reserva_passada){
            ?>
            <li class="d-flex">
              <div class="p_imagem"><?= $reserva_passada['img']; ?></div> <div class="p_nome"><p><?= substr($reserva_passada['nome'], 0, -5); ?></p><i><?= $reserva_passada['data'] . ' - ' . $reserva_passada['local_evento']; ?></i></div>
            </li>
          <?php
          }
        ?>
      </ul>
    </div>
    <?php
      }

    if(sizeof($customer_reservas_cancel) > 0){
  ?>
    <div id="reservas_canceladas_container" class="mt-5">
      <h2>Reservas canceladas</h2>
      <ul>
        <?php
          foreach(array_reverse($customer_reservas_cancel) as $reserva_cancelada){
            ?>
            <li class="d-flex">
              <div class="p_nome"><p><?= substr($reserva_cancelada['nome'], 0, -5); ?></p><i><?= $reserva_cancelada['data'] . ' - ' . $reserva_cancelada['local_evento']; ?></i></div>
            </li>
          <?php
          }
        ?>
      </ul>





      <!-- <ul> -->
        <?php
            foreach($customer_reservas_cancel as $reserva_cancel){
              // $reserva_cancel_oid = $reserva_cancel['order_id'];
              // $reserva_cancel_vid = $reserva_cancel['variation_id'];
              // $cancel_data_solic_db = $wpdb->get_results("SELECT data_solic FROM aer_cancelamentos WHERE `order_id` = $reserva_cancel_oid AND `variation_id` = $reserva_cancel_vid")[0] -> data_solic;
              // $cancel_data_solic = date("d-m-Y", strtotime($cancel_data_solic_db));
              // $cancel_taxa = 10;
        ?>
              <!-- <li class="py-2">
                <span class="cancel_status <?= $reserva_cancel['status']; ?>"><?= $reserva_cancel['status'] === 'cancelamento_pending' ? 'Reembolso pendente' : 'Concluído'; ?></span>
                <span class="cancel_nome"><?= $reserva_cancel['nome'] . '&nbsp; ('.$reserva_cancel['data'].')'; ?></span>
                <span class="cancel_data_solic">
                  <i>Data da solicitação</i><?= str_replace('-', '/', $cancel_data_solic); ?>
                </span>
                <span class="cancel_preco">
                  <i>Valor reembolsável</i>R$ <?= (int)preco_item_cancel($reserva_cancel['order_id'], $reserva_cancel['variation_id']) * (9/10); ?>,00
                </span>
              </li> -->
        <?php
            }
        ?>
      <!-- </ul> -->
    </div>
  <?php
    }
  ?>  
</section>
<script src="<?php echo get_stylesheet_directory_uri() ?>/js/minhas-reservas.js"></script>

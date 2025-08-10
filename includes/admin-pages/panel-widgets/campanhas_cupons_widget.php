<?php
function campanhas_cupons_widget(){
  global $wpdb;
  $campanhas = $wpdb->get_results("SELECT * FROM aer_camp_premios");
?>
<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/includes/campanhas-cupons-widget.css">
<div id="campanhas_cupons_widget">
  <?php
    if(sizeof($campanhas) > 0){
      function verificar_pedidos_do_user_com_cupom($cliente_id, $cupons_codigos) {
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
    
      ?>
        <ul id="campanhasLista">
          <?php
            foreach($campanhas as $campanha){
              $participantes = json_decode($campanha -> participantes);
              // $participantes_emails_query = array_map(function($_p){
              //   $usou_cupom = verificar_pedidos_do_user_com_cupom($_p -> user_id, ["roleta5", "roleta10", "roleta15", "roleta20"]);
              //   if($usou_cupom) return $usou_cupom;
              //   else{
              //     $dados_usuario = get_userdata((int)$_p -> user_id );
              //     if($dados_usuario) return $dados_usuario -> user_email;
              //     else return 'Usuário não encontrado';
              //   };
              // }, $participantes);
              // $participantes_emails = array_values(array_filter($participantes_emails_query, function($_v) {
              //   return !is_numeric($_v);
              // }));

              ?>
                <li class="campanha-container">
                  <div class="campanha-info">
                    <p class="nome-campanha"><?= $campanha -> nome_campanha; ?></p>
                    <div class="validade-campanha">
                      <div class="valido-de"><span>Válido de</span><?= $campanha -> valido_de; ?></div>
                      <div class="valido-ate"><span>Válido até</span><?= $campanha -> valido_ate; ?></div>
                    </div>
                  </div>
                  <div class="contador-participantes" data-role="button" data-camp-id="<?= $campanha -> id; ?>">
                    <span>Participantes</span>
                    <div class="contador"><?= sizeof($participantes); ?></div>
                    
                  </div>

                  <dialog id="modal-participantes-camp-<?= $campanha -> id; ?>" class="modal-participantes" data-camp-id="<?= $campanha -> id; ?>" data-participantes=<?= $campanha -> participantes; ?>>
                      <span class="close-modal" id="close-modal-particpantes-camp<?= $campanha -> id; ?>">FECHAR</span>
                      <div>
                        <p>Participantes da campanha</p>
                        <div>
                          <span class="follow-up-email-btn dashicons dashicons-email" data-codes="off5,off10,off15,off20"></span>
                        </div>
                      </div>
                      <ul class="lista-participantes">

                      </ul>
                    </dialog>
                </li>
              <?php
            }
          ?>
        </ul>
      <?php
    } else {
      ?>
        <p class="empty-placeholder">Nenhuma campanha cadastrada ainda...</p>
      <?php
    }
  ?>
  <div class="configurar-nova-campanha">
    <div class="content-section">
      <label class="novo-nome-label">
        Nome da nova campanha
        <input type="text" name="nome_nova_campanha">
      </label>
      <div class="tipos-flex">
        <div class="tipo-select">
          <span>Tipo de campanha</span>
          <select>
            <option value="roleta">Roleta</option>
          </select>
        </div>
        <div class="datas-select">
          <div>
            <label>
              Data de início
              <input type="date" name="data_inicio_camp">
            </label>
          </div>
          <div>
            <label>
              Data final
              <input type="date" name="data_final_camp">
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="submit-btn-section">
      <span class="dashicons dashicons-insert" onclick="submitNovaCampanha(this)"></span>
    </div>

  </div>
  <button class="button button-primary button-hero">Iniciar campanha</button>
</div>

<script>
  const participantesDialogs = document.querySelectorAll('.modal-participantes');
  participantesDialogs.forEach((_dialog) => {
    const closeBtn = _dialog.querySelector('span.close-modal');
    closeBtn.addEventListener('click', () => _dialog.close());
    
    const openBtn = document.querySelector(`.contador-participantes[data-camp-id="${_dialog.dataset.campId}"]`);
    openBtn.addEventListener('click', () => {
      _dialog.showModal();

    const part_c_cupom = JSON.parse(_dialog.dataset.participantes);
    const usersIds = part_c_cupom.map((_part) => _part.user_id);
    const listaParticipantes = _dialog.querySelector('.lista-participantes');

    listaParticipantes.innerHTML = '';

    fetchAdminAPI('get_customers', {users_ids: usersIds}, (status, data) => {
      if(status === true){
        if(data.length > 0){
          data.reverse().forEach((_user) => {
            const _part = part_c_cupom.filter((_pc) =>{
              if(+_pc.user_id === +_user.ID) return _pc;
            })
            const participanteLi = document.createElement('li'); 
            participanteLi.innerHTML = `<p>${_user.nome}</p><div><span class="cupom-data">${formatUnixTimestamp(_part[0].timestamp)}</span><span class="cupom-icon ${_part[0].cupom_obtido}">${_part[0].cupom_obtido}</span></div>`;
            listaParticipantes.appendChild(participanteLi);
          })
        }
      }

    }, 'GET')

    _dialog.querySelector('.follow-up-email-btn').addEventListener('click', ({target}) => {
      jQuery(function($) {
        $.ajax({
          url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'GET',
          data: {
              'action': 'send_email',
              'template': 'follow-up-cupom',
              'codes': target.dataset.codes,
          },
          success: async function({success, data}) {
            console.log(success)

            const envioSucesso = data.filter((_result) => _result.resultado === true);
                  const envioErro = data.filter((_result) => _result.resultado === false);
            const _text = `${data.length} `
            alert(`${envioSucesso.length} e-mail enviado com sucesso / ${envioErro.length} falharam.`)
          },
          error: function(error) {
           console.log('response error:  ' + error);
        }
      });

      })
      
    })
  })





  })

  function formatUnixTimestamp(unixTimestamp){
    // Cria um objeto Date a partir da timestamp Unix (em segundos, multiplique por 1000)
    const date = new Date(unixTimestamp);

    // Obtém os valores individuais
    const day = String(date.getDate()).padStart(2, '0'); // Dia com 2 dígitos
    const month = String(date.getMonth() + 1).padStart(2, '0'); // Mês com 2 dígitos (0 baseado)
    const year = String(date.getFullYear()).slice(-2); // Últimos 2 dígitos do ano
    const hours = String(date.getHours()).padStart(2, '0'); // Hora com 2 dígitos
    const minutes = String(date.getMinutes()).padStart(2, '0'); // Minutos com 2 dígitos

    // Monta a string no formato desejado
    return `${day}/${month}/${year} ${hours}:${minutes}`;
  }
function submitNovaCampanha(_target){
  const wrapper = _target.parentElement.parentElement;

  const resp = {
    nome_campanha: wrapper.querySelector('.novo-nome-label input[type="text').value,
    tipo: wrapper.querySelector('.tipo-select select').value,
    valido_de: wrapper.querySelector('.datas-select div:nth-child(1) input').value,
    valido_ate: wrapper.querySelector('.datas-select div:nth-child(2) input').value,
  }
  
  fetchAdminAPI('criar_campanha_cupons', resp, function(_success, _data){
    if(_success){
      console.log(_success)
    }
  })
}
</script>

<?php
}



?>
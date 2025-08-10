<?php
function aer_sorteios_widget(){
	global $wpdb;
	$aer_sorteios = $wpdb -> get_results("SELECT * from aer_sorteios");
    //print_r($aer_sorteios);
  ?>

  <div>
    <ul id="sorteios_widget_list">
      <?php
      	foreach($aer_sorteios as $sorteio){
            $participantes = json_decode($sorteio -> participantes);
            $vencedores = json_decode($sorteio -> vencedores);
        ?>
       		<li data-sorteio-ref="<?= $sorteio -> ref; ?>">
            	<span><?= $sorteio -> titulo; ?></span>
                <div class="sorteio-acc-body">
                	<p>Participantes: <?= sizeof($participantes); ?></p>
                    <span class="sortear-btn" onclick="realizarSorteio('<?= $sorteio -> ref ?>', <?= $sorteio -> participantes; ?>, this)">Sortear!</span>
                    <div class="sorteio-area"></div>
                    <div class="vencedores <?= sizeof($vencedores) === 0 ? 'd-none' : ''; ?>">
                      <p>Vencedores</p>
                      <ul>
                        <?php
                          foreach($vencedores as $vencedor_id){
                            $vencedor = get_user_by( 'ID', $vencedor_id );
                            $vencedor_cpf = $vencedor -> user_login;
                            $vencedor_nome = $vencedor -> first_name . ' ' . $vencedor -> last_name;
                            ?>
                            <li data-user-id="<?= $sorteio -> ref; ?>"></li>
                            <span><?= $vencedor_nome; ?></span><span><?= $vencedor_cpf; ?></span>

                            <?php
                          }
                        ?>
                      </ul>
                    </div>
                </div>
            </li>        
        <?php
        }
      ?>

    </ul>
          
          <script>
          	function realizarSorteio(ref, participantes, sortearBtn){
                if(!sortearBtn.classList.contains('disabled')){
                  sortearBtn.classList.add('disabled')
                  index_sorteado = Math.floor(Math.random() * (+participantes.length));
                  participante_sorteado = participantes[index_sorteado];
                  areaSorteio = sortearBtn.nextElementSibling; 
                  console.log(participante_sorteado);
                  areaSorteio.innerText = "Aguarde...";
                  
                  jQuery(function($) {
                      $.ajax({
                        url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                        type: 'POST',
                        data: {
                            'action': 'busca_usuario',
                            'type': 'id',
                            'value': participante_sorteado,
                        },
                        success: async function(response) {
                          console.log(response)
                          areaSorteio.innerHTML = `<span></span> <i>Resultado em <span class="dynamicCounter">3</span>...</i>`
                          const timerInterval = setInterval(() => {
                            const dynamicCounter = sortearBtn.nextElementSibling.querySelector('.dynamicCounter');
                            if(+dynamicCounter.innerText !== 1) dynamicCounter.innerText -= 1;
                            else {
                              clearInterval(timerInterval);
                              areaSorteio.style.opacity = 0
                                
                              setTimeout(() => {
                                  areaSorteio.innerHTML = `<div class="resultado-sorteio">
                                                            <span></span>
                                                            <span></span>
                                                            <span class="confirmar-vencedor-btn" onclick="confirmarVencedor('${ref}', ${response.data.id}, '${response.data.nome_completo}', '${response.data.cpf}')">Confirmar vencedor</span>
                                                          </div>`;
                                  areaSorteio.children[0].children[0].innerText = response.data.nome_completo;
                                  areaSorteio.children[0].children[1].innerText = response.data.cpf;
                                areaSorteio.style.opacity = 1;
                                sortearBtn.classList.remove('disabled');
                              }, 500)
                            }
                          }, 1200);
                        },
                        error: function(error) {
                          console.dir(error);
                        }
                    });
                  })
                }
            }

            function confirmarVencedor(sorteio_ref, user_id, nome_completo, cpf){
              jQuery(function($) {
                $.ajax({
                  url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                  type: 'POST',
                  data: {
                      'action': 'aer_sorteios',
                      'to': 'confirmar_vencedor',
                      'user_id': user_id,
                      'ref': sorteio_ref
                  },
                  success: async function(response) {
                    if(response.data===1){
                      const vLi = document.createElement('li');
                      vLi.innerHTML = `<span>${nome_completo}</span><span>${cpf}</span>`;
                      vLi.dataset.userId = user_id;
                      document.querySelector(`li[data-sorteio-ref="${sorteio_ref}"] .vencedores`).classList.remove('d-none');
                      const vencedoresUl = document.querySelector(`li[data-sorteio-ref="${sorteio_ref}"] .vencedores ul`);
                      document.querySelector(`li[data-sorteio-ref="${sorteio_ref}"] .resultado-sorteio`).innerText = '';
                      vencedoresUl.appendChild(vLi);
                    }
                  },
                  error: function(error) {
                    console.dir(error);
                  }
                });
              })
            }
          </script>
    
  </div>
<?php
}
?>
<?php

// COLOCAR UMA MENSAGEM QUANDO NÃO HÁ NENHUM PADRAO DE HORARIOS DEFINIDO 


add_action( 'woocommerce_product_data_panels', 'painel_exc_embarques' );
function painel_exc_embarques() {
  global $post;
  global $wpdb;
  $nome_tabela = $wpdb->prefix . 'embarques'; 
  $embarques_db = $wpdb -> get_results("SELECT * from $nome_tabela");
  $embarques_exc = json_decode(get_post_meta($post -> ID, 'embarques', true));
  $embarques_exc_bot = json_decode(get_post_meta($post -> ID, 'exc_embarques', true));

  $exc_variacoes = wc_get_product($post -> ID) -> status !== 'auto-draft' ? wc_get_product($post -> ID)->get_available_variations() : null;

  if(isset($exc_variacoes)){
    $dias_exc = array_map(function($_var){
      return $_var['attributes']['attribute_dia'];
    }, $exc_variacoes);
  }
  
  $padroes_horarios_salvos = get_option('padroes_horarios');
?>
  <div class="panel woocommerce_options_panel wc_metaboxes_wrapper hidden px-4" id="exc_embarques_meta">
    <div class="section-show" data-dias=<?= isset($exc_variacoes) ? json_encode($dias_exc) : ''?>>
      <dialog id="refHorarioModal">
        <p>Defina o horário de embarque no ponto</p>
        <p class="ref-nome-emb"></p>
        <input autofocus type="time">
        <button>Definir</button>
      </dialog>
      <p>Selecione os embarques da excursão</p>
      <div class="main-embarques-header">
        <div id="padraoSelector">
          <?php
            if($padroes_horarios_salvos){
              ?>
                <p>Selecione um padrão de horários</p>
                <select name="padraoSelect" id="padraoSelect">
                  <option value="none" selected>Selecione...</option>
                  <?php
                    foreach($padroes_horarios_salvos as $_padrao){
                      $nome_emb_ref = '';
                      foreach($embarques_db as $_emb_db){
                        if((int)$_emb_db -> id == (int)$_padrao['referencia']){
                          $nome_emb_ref = $_emb_db -> nome;
                        }
                      }
                      ?>
                      <option data-ref="<?= $nome_emb_ref; ?>" value="<?= $_padrao['nome']; ?>" data-json='<?= json_encode([$_padrao], JSON_UNESCAPED_UNICODE)?>'><?= $_padrao['nome']; ?></option>
                      <?php
                    }
                  ?>
                </select>
              <?php
            }
          ?>
        </div>
      </div>

      <ul class="main-embarques-list">
        <?php
          $ordem_dos_embarques = get_option('preset_ordem_embarques');
          foreach($ordem_dos_embarques as $_ordem){
            $embarque_db = array_filter($embarques_db, function($_emb_db) use($_ordem){
              return $_emb_db -> id == $_ordem;
            });
            $embarque_db = array_values($embarque_db)[0];
            if($embarques_exc){
              $meta_embarque_exc = array_values(array_filter($embarques_exc, function($_emb_exc) use($embarque_db){
                if($embarque_db -> id == $_emb_exc -> embarqueId) return $_emb_exc;
              }));
              $meta_embarque_exc = $meta_embarque_exc[0] ?? null;
            }else{
              $meta_embarque_exc = null;
            }
          ?>
            <li data-embarque-id="<?= $embarque_db -> id; ?>" data-status="<?= $meta_embarque_exc ? 'ativo' : 'inativo' ?>" data-endereco="<?= $embarque_db -> endereco; ?>" data-referencia="<?= $embarque_db -> obs; ?>">
              <div class="emb-item-head">
                <p class="emb-title"><?= $embarque_db -> nome; ?></p>
                <div class="emb-ativo-check"><span class="dashicons dashicons-yes-alt" data-embarque-id="<?= $embarque_db -> id; ?>"></span></div>
              </div>
              <div class="emb-item-body">
                <ul class="lista-horarios" data-embarque-id="<?= $embarque_db -> id; ?>">
                  <?php
                    $horariosIndex = 1;
                    if($meta_embarque_exc){
                      foreach($meta_embarque_exc -> horarios as $horarioObj){
                        ?>
                          <li data-order="<?= $horariosIndex; ?>">
                            <div class="horario">
                              <input type="time" data-order="<?= $horariosIndex; ?>" value="<?= $horarioObj -> horario; ?>" onchange="salvaEmbarques()">
                            </div>
                            <div class="disponibilidade" data-embarque-id="<?= $embarque_db -> id; ?>" data-order="<?= $horariosIndex; ?>">
                              <?php

                                $_status = '';
                                if(isset($dias_exc)){
                                  foreach($dias_exc as $_dia){
                                    foreach($horarioObj -> disponibilidade as $_disp){
                                      if($_disp -> disp_dia === $_dia){
                                        $_status = $_disp -> status === 'disponivel' ? true : false;
                                      }
                                    }


                                    ?>
                                      <label>
                                        <?= $_status ? '<input checked onchange="salvaEmbarques()" type="checkbox" data-content="'.substr($_dia, 0, -5).'" data-dia="'.$_dia.'">' : '<input onchange="salvaEmbarques()" type="checkbox" data-content="'.substr($_dia, 0, -5).'" data-dia="'.$_dia.'">' ?>
                                      </label>
                                    <?php
                                  }
                                }
                                
                              ?>
                            </div>
                            <div class="opcoes">
                              <?php
                                if($horariosIndex > 1){
                                  ?> 
                                  <span onclick="excluirHorario(this.dataset.embarqueId, this.dataset.order)" class="dashicons dashicons-trash" data-embarque-id="<?= $embarque_db -> id; ?>" data-order="<?= $horariosIndex; ?>"></span>
                                  <?php
                                }
                              ?>
                            </div>
                          </li>
                        <?php
                        $horariosIndex++;
                      }
                    }else{
                      ?>
                        <li data-order="<?= $horariosIndex; ?>">
                          <div class="horario">
                            <input type="time" onchange="salvaEmbarques()" data-order="<?= $horariosIndex; ?>" value="">
                          </div>
                          <div class="disponibilidade" data-embarque-id="<?= $embarque_db -> id; ?>" data-order="<?= $horariosIndex; ?>">
                            <?php
                              foreach($dias_exc as $_dia){
                                ?>
                                  <label><input type="checkbox" onchange="salvaEmbarques()" data-content="<?= substr($_dia, 0, -5); ?>" data-dia="<?= $_dia; ?>" checked></label>
                                <?php
                              }
                            ?>
                          </div>
                          <div class="opcoes"></div>
                        </li>
                      <?php
                    }
                  ?>
                </ul>
                <div class="emb-item-footer">
                  <span class="add-horario-btn" onclick="adicionarHorario(<?= $embarque_db -> id; ?>)">Adicionar horário</span>
                  <div class="switch taxa">
                  <?php
                      if($meta_embarque_exc){
                        ?>
                          <label>
                            Adicionar taxa
                            <input type="checkbox" 
                            <?= ((int)$meta_embarque_exc -> taxa !== 0) ? 'checked' : ''; ?> 
                            data-embarque-id="<?= $embarque_db -> id; ?>" 
                            onchange="toggleTaxa(<?= $embarque_db -> id; ?>, this)">
                            <span class="slider"></span>
                          </label>
                          <input type="number" 
                          onchange="salvaEmbarques()"
                          class="<?= ((int)$meta_embarque_exc -> taxa !== 0) ? 'ativo' : ''; ?>" 
                          value="<?= ((int)$meta_embarque_exc -> taxa !== 0) ? $meta_embarque_exc -> taxa : ''; ?>">
                        <?php
                      }else{
                        ?>
                          <label>
                            Adicionar taxa
                            <input type="checkbox" data-embarque-id="<?= $embarque_db -> id; ?>" onchange="toggleTaxa(<?= $embarque_db -> id; ?>, this)">
                            <span class="slider"></span>
                          </label>
                          <input type="number" onchange="salvaEmbarques()">
                        <?php
                      }
                    ?>
                  </div>
                </div>
              </div>
            </li>

        <?php
          }
        ?>
        
      </ul>
      <?php 
        woocommerce_wp_hidden_input(array(
          'id'      => 'meta_embarques',
          'value'   => $embarques_exc ? json_encode($embarques_exc, JSON_UNESCAPED_UNICODE) : '',
        ));

        // METAFIELD PARA LEITURA DO BOT
        woocommerce_wp_hidden_input(array(
          'id'      => 'meta_exc_embarques',
          'value'   => $embarques_exc_bot ? json_encode($embarques_exc_bot, JSON_UNESCAPED_UNICODE) : '',
        ));
      ?>
        
      <script>
        const embsLisHeads = document.querySelectorAll('ul.main-embarques-list > li .emb-item-head');
        embsLisHeads.forEach(_li => _li.addEventListener('click', ({target}) => cliqueHeaderEmbarque(target)));

        //Listener e callback para o select de padrão de horários
        const padraoSelect = document.querySelector("#exc_embarques_meta select#padraoSelect")
        const setHorarioRefModal = document.querySelector('dialog#refHorarioModal');
        const closeModalBtn = document.querySelector('dialog#refHorarioModal button');


        //Impede o submit ao apertar Enter
        function handleEnterKey(event){
          if (event.key === 'Enter' || event.keyCode === 13) { 
            event.preventDefault();
            if(setHorarioRefModal.hasAttribute('open')){
              closePadraoModal(setHorarioRefModal.querySelector('input[type="time"]'));
            }
          } 
        }


        function closePadraoModal(_e){
          let refHour;
          let padraoAtivoEmbarques;
          
          if(_e.dataset){
            refHour = _e.value;
            padraoAtivoEmbarques = JSON.parse(_e.dataset.embarques);
          }else{
            _e.preventDefault()
            refHour = _e.target.parentElement.querySelector('input[type="time"]').value
            padraoAtivoEmbarques = JSON.parse(_e.target.parentElement.querySelector('input[type="time"]').dataset.embarques);
          }
          const refHourTimestamp = +getTimestampFromZero(refHour) + 270000000;

          // console.log(padraoAtivoEmbarques);

          document.querySelectorAll('ul.main-embarques-list > li').forEach(_li => {

            // console.log(padraoAtivoEmbarques)

            const _liTimeInput = _li.querySelector('ul.lista-horarios > li:first-child input[type="time"]');
            const _padrao = padraoAtivoEmbarques.flatMap(_padrao_emb => _padrao_emb.embarque == _li.dataset.embarqueId ? _padrao_emb : [])
        console.log(_padrao)
            //adicionar embarque de ref no obj _padrao





            if(_padrao.length > 0){
              let diffHourTimestamp = Number(_padrao[0].timestamp)
              diffHourTimestamp = _padrao[0].rel == 'minus' ? diffHourTimestamp * (-1) : diffHourTimestamp;

              let timestampToConvertToHour = refHourTimestamp + diffHourTimestamp;

              timestampToConvertToHour = new Date(timestampToConvertToHour);

              let _hh = timestampToConvertToHour.getHours();
              _hh = _hh.toString().length == 1 ? '0' + _hh : _hh;

              let _mm = timestampToConvertToHour.getMinutes();
              _mm = _mm.toString().length == 1 ? '0' + _mm : _mm;

              _liTimeInput.setAttribute('value', _hh + ":" + _mm);
              _liTimeInput.value = _hh + ":" + _mm;

              _li.dataset.status = 'ativo';
              }
          })
          salvaEmbarques();
          setHorarioRefModal.close()
        }

        // ABRE MODAL DE PADRÃO
        padraoSelect.addEventListener('change', ({target}) => {
          if(target.value === 'none'){
            document.querySelectorAll('ul.main-embarques-list > li').forEach(_li => {
              _li.dataset.status = 'inativo';
              _li.querySelectorAll('ul.lista-horarios > li').forEach((_li_hor, _ind) => _ind > 0 ? _li_hor.remove() : null)
              _li.querySelector('input[type="time"]').value = null;
            })
          }else{
            const padrao_array = JSON.parse(target.options[target.options.selectedIndex].dataset.json)[0];
            padrao_array.embarques.push({embarque: padrao_array.referencia, rel: 'minus', timestamp: '0000000'}); //horário do embarque de referência - ajuste OK
            setHorarioRefModal.querySelector('.ref-nome-emb').innerText = target.options[target.options.selectedIndex].dataset.ref;
            setHorarioRefModal.querySelector('input[type="time"]').dataset.embarques = JSON.stringify(padrao_array.embarques);
            document.addEventListener('keydown', handleEnterKey);
            setHorarioRefModal.showModal();
          }
        })

        closeModalBtn.addEventListener('click', closePadraoModal);

        function adicionarHorario(_embId){
          const listaHorariosRef = document.querySelector(`ul.main-embarques-list > li[data-embarque-id='${_embId}'] ul.lista-horarios`)
          let cloneLi = listaHorariosRef.children[0].cloneNode(true);
          let order = +listaHorariosRef.children[listaHorariosRef.children.length - 1].dataset.order + 1;
          cloneLi.dataset.order = order;
          cloneLi.querySelector('input[type="time"]').value = '';
          cloneLi.querySelector('input[type="time"]').dataset.order = order;
          cloneLi.querySelectorAll('.disponibilidade input').forEach(_inp => _inp.checked = true);
          let spanExcluir = document.createElement('span');
          spanExcluir.classList.add("dashicons", "dashicons-trash");
          spanExcluir.dataset.order = order;
          spanExcluir.dataset.embarqueId = _embId;
          spanExcluir.addEventListener('click', () => excluirHorario(_embId, order))
          cloneLi.querySelector('.opcoes').appendChild(spanExcluir);
          listaHorariosRef.appendChild(cloneLi);
          salvaEmbarques();
        }
        function excluirHorario(_embId, _order){
          const listaHorariosRef = document.querySelector(`ul.lista-horarios[data-embarque-id='${_embId}'`)
          if(window.confirm('Excluir esse horário?')){
            listaHorariosRef.querySelector(`li[data-order="${_order}"]`).remove();
          }
          salvaEmbarques();
        }
        function toggleTaxa(_embId, _el){
          const embLiRef = document.querySelector(`ul.main-embarques-list > li[data-embarque-id='${_embId}']`);
          const taxaNumberInput = embLiRef.querySelector('.switch.taxa input[type="number"]');
          if(_el.checked){
            taxaNumberInput.classList.add('ativo');
            taxaNumberInput.focus();
          }else{
            taxaNumberInput.classList.remove('ativo');
          }
          salvaEmbarques();
        }
        function cliqueHeaderEmbarque(_target){
          const embId = _target.dataset.embarqueId;
          if(_target.classList.contains('dashicons')){
            const _li = document.querySelector(`ul.main-embarques-list > li[data-embarque-id="${embId}"]`);
            _li.dataset.status = _li.dataset.status === 'ativo' ? 'inativo' : 'ativo';
            salvaEmbarques();
          }
        }
        function handleToggleCheckbox(_el){
          if(!_el.checked){
            _el.checked = true;
          } 
        }
        function salvaEmbarques(_e = null){
          if(_e) _e.preventDefault();
          const embarquesAtivos = Array.from(document.querySelectorAll('.main-embarques-list > li[data-status="ativo"]'));
          const novo_exc_embs = [];
          const obj = embarquesAtivos.flatMap((_emb) => {
          let _return = {embarqueId: +_emb.dataset.embarqueId, horarios: [], taxa: 0}

            _emb.querySelectorAll('ul.lista-horarios > li').forEach(horarioLi => {
              const inputHora = horarioLi.querySelector('input[type="time"]')
              if(inputHora.value != ''){
                //Cria o objeto que será retornado

                //Cria um objeto filho para cada horário do embarque
                const horarioObj = {horario: inputHora.value, disponibilidade: []}

                const diasDispCheckboxes = _emb.querySelectorAll(`.lista-horarios li[data-order="${inputHora.dataset.order}"] .disponibilidade input[type="checkbox"]`);
                if(diasDispCheckboxes.length > 0){
                  diasDispCheckboxes.forEach(dispInput => {
                    horarioObj.disponibilidade.push({disp_dia: dispInput.dataset.dia, status: dispInput.checked ? 'disponivel' : 'indisponivel'});
                  })
                } else {
                    let _todosDias = JSON.parse(document.querySelector('#exc_embarques_meta.panel.woocommerce_options_panel .section-show').dataset.dias);
                    _todosDias.forEach(__dia => {
                    horarioObj.disponibilidade.push({disp_dia: __dia, status: 'disponivel'});
                  })
                }
                
                _return.horarios.push(horarioObj);

              }
            })

            //Define a propriedade 'taxa'
            const taxaCheckbox = _emb.querySelector('.switch.taxa input[type="checkbox"]');
            const taxa = +_emb.querySelector('.switch.taxa input[type="number"]').value;
            if(taxaCheckbox.checked && taxa > 0) _return.taxa = taxa;


            // PREPARA O EXC_EMBARQUES
            let = _exc_emb_return = {
              nome_embarque: _emb.querySelector('.emb-title').innerText,
              endereco_embarque: _emb.dataset.endereco, 
              taxa: taxaCheckbox.checked ? taxa : 0,
              referencia: _emb.dataset.referencia, 
              mapa: _emb.dataset.link_mapa,
              opcoes: []
            }

            //pega todos os dias definidos
            const todosDias = JSON.parse(document.querySelector('#exc_embarques_meta.panel.woocommerce_options_panel .section-show').dataset.dias);

            todosDias.forEach(_dia => {
              _return.horarios.forEach(_hor => {
                let _status = 'ativo';
                _hor.disponibilidade.forEach(_do => {
                  if(_do.dia = _dia) _status = _do.status == 'disponivel' ? 'ativo' : 'inativo';
                })

                _exc_emb_return.opcoes.push({
                  dia: _dia,
                  horario: _hor.horario,
                  status: _status,
                })

              })
            })


            novo_exc_embs.push(_exc_emb_return);
            console.log(novo_exc_embs);
            document.querySelector('input#meta_exc_embarques[type="hidden"]').setAttribute('value', JSON.stringify(novo_exc_embs));
            // FIM PREPARA O EXC_EMBARQUES          

            if(_return.horarios.length > 0) return _return;
            else{
              return [];
            } 

          });

          document.querySelector('input#meta_embarques[type="hidden"]').setAttribute('value', JSON.stringify(obj));



        }
      </script>   

      
    </div>
    <dic class="section-hide">
      <p>Defina primeiro as datas!</p>
    </dic>
 
  </div>
<?php
}
?>
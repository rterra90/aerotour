<?php 

add_action('admin_head', 'admin_head_scripts');

function admin_head_scripts() {
  ?>
  <script>
    function unicodeFilter(str){
      const values = [['u00e1', 'á'], ['u00fa', 'ú'], ['u00ed', 'í'], ['u00e3', 'ã'], ['u00e7', 'ç'], ['u00e9', 'é'], ['u00ea', 'ê'], ['u00c1', 'Á'], ['u00c7', 'Ç'], ['u00c9', 'É'], ['u00f4', 'ô'], ['u00f3', 'ó']];
      values.forEach(value => {
        if(str.includes(value[0])) str = str.replace(value[0], value[1]);
      })
      return str;
    }

    /* Obtém a timestamp de um horário a partir o ms 0 */
    function getTimestampFromZero(tempo) {
      // Dividir a string "hh:mm" em horas e minutos
      const [horas, minutos] = tempo.split(':').map(Number);

      // Criar um objeto Date com a data atual e definir as horas e minutos
      const agora = new Date();
      agora.setHours(horas, minutos, 0, 0);

      // Criar um objeto Date para o início do dia (meia-noite)
      const inicioDoDia = new Date(agora);
      inicioDoDia.setHours(0, 0, 0, 0);

      // Calcular o timestamp em relação ao início do dia
      const timestamp = agora.getTime() - inicioDoDia.getTime();

      return timestamp;
    }

    /* Atualiza definições de uma variação de lista de passageiros */
    function atualizarDefinicoesVariacao(exc_id, exc_var_id, element){
      element.setAttribute('disabled', '');
      const variacao = document.querySelector(`#passageiros_meta .accordion-item[data-variacao-id="${exc_var_id}"]`);
  
      /* auto-organizar passageiros */
      const linhas_qtd = variacao.querySelectorAll(`.linhas-inner-flex > div`).length
      const linhas_auto_org_rule = {}
      for (let i = 1; i <= linhas_qtd; i++) {
        linhas_auto_org_rule[`linha_${i}`] = [];
      }

      const emb_checkboxes = variacao.querySelectorAll(`.linhas-inner-flex input[type="checkbox"]`)
      emb_checkboxes.forEach(checkbox => {
        if(checkbox.checked){
          linha_key = 'linha_' + checkbox.dataset.linha;
          linhas_auto_org_rule[linha_key].push(checkbox.value);
        }
      })

      jQuery(function($) {
        $.ajax({
          url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'POST',
          data: {
              'action': 'save_definicoes_variacao',
              'excursao_id': exc_id,
              'variacao_id': exc_var_id,
              'definicoes_a': linhas_auto_org_rule,
          },
          success: async function(response) {
            location.reload();
            // console.log(response)
          },
          error: function(error) {
            console.dir(error);
          }
        });
      })
      
    }

    /* Alterna a lista de passageiros exibida (linha ou todos) em uma variação */
    function handleListasPassageirosVar(exc_var_id, linha){
      const navItems = document.querySelectorAll(`.passageiros_meta > [data-variacao-id="${exc_var_id}"] .linhas-nav li`);
      const listas_passageiros = document.querySelectorAll(`.passageiros_meta > [data-variacao-id="${exc_var_id}"] .passageiros-linha`);
      listas_passageiros.forEach((lista, i) => {
        lista.dataset.linha === linha ? lista.classList.remove('d-none') : lista.classList.add('d-none');
        navItems[i].dataset.linha === linha ? navItems[i].classList.add('active') : navItems[i].classList.remove('active');
      })
    }

    // /* Cria e exclui ponto de embarque global */
    // function handleEmbarquesAdmin(action, ref, _endereco){
    //   let nome;
    //   let endereco;

    //   if(action === 'salvar'){
    //     nome = document.querySelector('.adicionar_embarque input[name="nome_embarque"]').value;
    //     endereco = document.querySelector('.adicionar_embarque input[name="endereco_embarque"]').value;
    //   }else if(action === 'editar'){
    //     nome = prompt('Digite o novo NOME do ponto de embarque', ref);
    //     endereco = nome ? prompt('Digite o novo ENDEREÇO do ponto de embarque', _endereco) : null;
    //   }

    //   jQuery(function($) {
    //     $.ajax({
    //       url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
    //       type: 'POST',
    //       data: { 
    //         'action': 'handle_embarques',
    //         'data': {
    //           'nome': action === 'excluir' ? ref : nome,
    //           'endereco': action === 'excluir' ? null : endereco,
    //           'nome_anterior': action === 'editar' ? ref : null, 
    //           'endereco_anterior': action === 'editar' ? _endereco : null, 
    //           'action': action,
    //         }
    //       },
    //       success: async function(response) {
    //         location.reload()
    //         // console.log(response)
    //       },
    //       error: function(error) {
    //         console.log(error);
    //       }
    //     });
    //   })
    // }

    /* Atribui ou remove cupom de um usuário encontrado pelo componente user_search */
    function atribuirCupom(cupom_icon, user_id, code){
      const loading_element = document.createElement('span');
      loading_element.classList.add('loading-element');
      cupom_icon.appendChild(loading_element);

      jQuery(function($) {
        $.ajax({
          url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'POST',
          data: {
              'action': 'atribuir_cupom',
              'user_id': user_id,
              'code': code,
          },
          success: async function(response) {
            // updateReactiveValues('user_search', response.data);
            cupom_icon.querySelector('.loading-element').remove();
            cupom_icon.parentElement.classList.toggle('nao-tem');
            cupom_icon.parentElement.classList.toggle('ja-tem');
            const responseTooltip = document.createElement('span');
            responseTooltip.innerText = response.data;
            responseTooltip.classList.add('success-tooltip');
            cupom_icon.appendChild(responseTooltip);
            setTimeout(() => responseTooltip.classList.add('show'), 100);
            setTimeout(() => responseTooltip.classList.remove('show'), 2300);
            setTimeout(() => cupom_icon.querySelector('.success-tooltip').remove(), 2700);
          },
          error: function(error) {
            console.log('response error:  ' + error);
          }
        });
      })
    }

    /* Adiciona ou remove usuário encontrado pelo componente user_search da lista de passageiros da variação */
    function inserirListaPassageiros(add_icon, user, variation_id){
      const user_to_add = JSON.parse(user);

      //complementa informações de cadastros incompletos
      if(user_to_add.rg === '' | user_to_add.rg_orgao_exp === '' || user_to_add.telefone === ''){
          Object.keys(user_to_add).forEach(dado => {
          if(user_to_add[dado] === ''){
            user_to_add[dado] = prompt(`Informe o ${dado}`);
          }
        })
      }

      //confirma a ação
      const confirmMessage = () => {
        return `Adicionar o passageiro a seguir?\r\n
        Nome: ${user_to_add.nome_completo}\r\n
        RG/Órgão exp: ${user_to_add.rg} ${user_to_add.rg_orgao_exp}\r\n
        Telefone: ${user_to_add.telefone}`;
      }
      if(confirm(confirmMessage())){
        console.log('adiciona')
      }
      
      console.log(user_to_add);
    }

    /* CHECK-IN */
    function aerCheckIn(var_id, nome, doc, sentido, targetBox){
        event.stopPropagation();
        let lista_passageiros_filtered = 'lista_passageiros_alfa';
        if(!nome) document.querySelector('ul.lista-check-in').innerHTML = 'Aguarde...'
        if(!nome && targetBox) lista_passageiros_filtered = `lista_passageiros_${targetBox.dataset.filter}`;

      jQuery(function($) {
        $.ajax({
          url:  '<?php echo admin_url( 'admin-ajax.php' ); ?>',
          type: 'POST',
          data: {
              'action': 'check_in',
              'variation_id': var_id,
              'nome': nome || null,
              'doc': doc || null,
              'sentido': sentido || null
          },
          success: async function(response) {

            if(response.data.length === 3){
              document.querySelector('ul.lista-check-in').innerHTML = '';
              updateReactiveValues(lista_passageiros_filtered, response.data)
            }else{
              if(response.data.saida === true) targetBox.parentElement.children[0].classList.add('ok');
              else targetBox.parentElement.children[0].classList.remove('ok');
 
              if(response.data.volta === true) targetBox.parentElement.children[1].classList.add('ok');
              else targetBox.parentElement.children[1].classList.remove('ok');
            }
            
          },
          error: function(error) {
            console.dir(error);
          }
        });
      })
    }


    /* REACTIVE ELEMENTS */
    function updateReactiveValues(query_type, obj = null){
      let parsedObj = typeof obj === 'string' ? JSON.parse(obj) : obj;
      let reactiveElements = document.querySelectorAll(`[data-react="${query_type}"]`);
      
      if(query_type === "obj_passageiros"){
          Object.keys(parsedObj).forEach(id_dia_exc => {
            let var_id = id_dia_exc.replace('id', '').split('__')[0];
            let dia = id_dia_exc.replace('id', '').split('__')[1];
            // /* cria objeto com as linhas de cada variação */
            let linhas_var = {};
            if(parsedObj[id_dia_exc]){
              parsedObj[id_dia_exc].forEach(_passageiro => {
                if(_passageiro.linha && _passageiro.linha.length > 1){
                    if(linhas_var.hasOwnProperty(_passageiro.linha)) linhas_var[_passageiro.linha].push(_passageiro);
                    else linhas_var[_passageiro.linha] = [_passageiro];
                }
              })
            }
            
            reactiveElements.forEach(element => {
                if(element.classList.contains('total_linha') && element.dataset.variacaoId === var_id){
                  element.innerText = linhas_var[element.dataset.linha] !== undefined ? linhas_var[element.dataset.linha].length : 0;                                    
                } else if(element.classList.contains('passageiros_linha') && element.dataset.variacaoId === var_id){
                  element.innerHTML = '';
                  let colunas_lista_linhas = ['nome_completo', 'telefone', 'embarque'];
                  if(linhas_var[element.dataset.linha] !== undefined){
                    linhas_var[element.dataset.linha].forEach(_passageiro => {
                      let li = document.createElement('li');
                      colunas_lista_linhas.forEach(coluna => {
                        let _div = document.createElement('div');
                        _div.classList.add(`linha-${coluna}`);
                        _div.innerText = coluna === 'embarque' ? unicodeFilter(_passageiro[coluna].split('(')[0]) : unicodeFilter(_passageiro[coluna]);
                        li.appendChild(_div);
                      })
                      element.appendChild(li);
                    })
                  } else{
                    let sem_passageiros_placeholder = document.createElement('p'); 
                    sem_passageiros_placeholder.innerText = 'Sem pasageiros nesta linha no momento!';
                    element.appendChild(sem_passageiros_placeholder);
                  }
                }
            })                
        })
      }else if(query_type === 'user_search'){
        <?php
        global $post;
          if(isset($post)){
          ?>
            reactiveElements.forEach(element => {
          
            const post_type = "<?= $post -> post_type; ?>";

            if(obj.cpf){
              const userResultIconClass = (_post_type) => {
                
                if(_post_type === 'shop_coupon'){
                  if(obj.cupons && (obj.cupons.includes(element.dataset.code.toUpperCase()) || obj.cupons.includes(element.dataset.code))) return 'ja-tem';
                }else if(_post_type === 'product'){
                  // if para verificar se usuário está na lista de passageiros da excursão
                }
                return 'nao-tem'; 
              } 

              element.classList.add('active');
              element.children[0].innerText = obj.nome_completo;

              /* as funções 'atribuirCupom' e 'inserirListaPassageiros'
              estão em admin-head-scripts.php */
              
              if(post_type === 'shop_coupon'){
                element.children[1].innerHTML = `<span onclick="atribuirCupom(this, ${obj.id}, '${document.querySelector('.user-search-area_result').dataset.code}')" class="dashicons dashicons-tickets-alt"></span>`;              
              }else if(post_type === 'product'){
                // inserir 
                const _user = JSON.stringify(obj);
                element.children[1].innerHTML = "<span onclick='inserirListaPassageiros(this, `"+_user+"`, "+document.querySelector('.user-search-area_result').dataset.variationId+")' class='dashicons dashicons-yes-alt'></span>";    

              }

              
              element.children[1].classList.remove('nao-tem', 'ja-tem');
              element.children[1].classList.add(userResultIconClass(post_type));
              
            }else{
              element.children[0].innerText = 'Nenhum usuário encontardo';

            }
          }) 
          <?php
          }
        ?>

      }else if(query_type.startsWith('lista_passageiros')){
        const listaCheckIn = document.querySelector('#check-in-modal ul.lista-check-in');

        let passageiros = obj[0];
        passageiros = passageiros.filter((_p) => _p.status === 'normal')

        const tem_linhas = obj[1];
        const variation_id = obj[2];
        let passageiros_ordenados;
        const filter = query_type.split('_')[2]; //'alfa' ou 'embarque'

        if(filter === 'alfa'){
          //Ordena objeto de passageiros em ordem alfabética
          passageiros_ordenados = passageiros.sort(function(a, b){
            if (a.p_nome.toUpperCase() > b.p_nome.toUpperCase()) return 1
            if (a.p_nome.toUpperCase() < b.p_nome.toUpperCase()) return -1
            return 0;
          })
        } else if(filter === 'embarque'){
          passageiros_ordenados = {};

          passageiros.forEach(passageiro => {
            const p_embarque = passageiro.embarque;
            if(!passageiros_ordenados.hasOwnProperty(p_embarque)) passageiros_ordenados[p_embarque] = [];
            passageiros_ordenados[p_embarque].push(passageiro);
          })
        }


        console.log(passageiros_ordenados);
        // const p_o_sem_cancel = passageiros_ordenados.filter((_p) => _p.status === 'normal')
        // console.log(p_o_sem_cancel);


        const passageiros_src = filter === 'alfa' ? passageiros_ordenados : Object.keys(passageiros_ordenados).sort();
        
        if(filter === 'alfa'){
          passageiros_src.forEach(passageiro => {
            const liPassageiro = document.createElement('li');
            liPassageiro.innerHTML=`
            <div>
              <p>${unicodeFilter(passageiro.p_nome)}</p>
              <div class="passageiro_dados">
                <span>Doc: ${passageiro.p_cpf}</span>
                <span>Contato: ${passageiro.p_telefone}</span>
                <span style="display: block">Embarque: ${unicodeFilter(passageiro.embarque)}<span>
              </div>
            </div>
            <div class="check-in-boxes" data-nome="${passageiro.p_nome}" data-doc="${passageiro.p_cpf}">
              <span data-sentido="saida" class="${passageiro.saida == 1 ? 'ok' : ''}"></span>
              <span data-sentido="volta" class="${passageiro.volta == 1 ? 'ok' : ''}"></span>
            </div>`
              
            liPassageiro.addEventListener('click', ({currentTarget}) => currentTarget.querySelector('.passageiro_dados').classList.toggle('active'));
            
            if(passageiro.status === 'normal') listaCheckIn.appendChild(liPassageiro);
            
          })

        }else if(filter === 'embarque'){
          passageiros_src.forEach(embarque => {
            passageiros_ordenados[embarque] = passageiros_ordenados[embarque].sort(function(a, b){
              if (a.p_nome.toUpperCase() > b.p_nome.toUpperCase()) return 1
              if (a.p_nome.toUpperCase() < b.p_nome.toUpperCase()) return -1
              return 0;
            });
          });

          passageiros_src.forEach(embarque =>{
            const liEmbarqueTitle = document.createElement('li');
            liEmbarqueTitle.classList.add('embarque-header');
            liEmbarqueTitle.innerHTML = `<span class="show-hide-btn dashicons dashicons-visibility"></span><b>${unicodeFilter(embarque)}<span class="count">` + passageiros_ordenados[embarque].length + `</span></b>`;
            listaCheckIn.appendChild(liEmbarqueTitle);
            liEmbarqueTitle.querySelector('.show-hide-btn').addEventListener('click', ({target}) => {
              target.classList.toggle('dashicons-visibility');
              target.classList.toggle('dashicons-hidden');
              document.querySelectorAll(`li[data-embarque="${embarque}"`).forEach(li => li.classList.toggle('d-none'))

            })

            passageiros_ordenados[embarque].forEach(_passageiro => {

              const liPassageiro = document.createElement('li');
              liPassageiro.dataset.embarque = embarque;
              liPassageiro.innerHTML=`
              <div>
                <p>${unicodeFilter(_passageiro.p_nome)}</p>
                <div class="passageiro_dados">
                  <span>Doc: ${_passageiro.p_cpf}</span>
                  <span>Contato: ${_passageiro.p_telefone}</span>
                  <span style="display: block">Embarque: ${unicodeFilter(_passageiro.embarque)}<span>
                </div>
              </div>
              <div class="check-in-boxes" data-nome="${_passageiro.p_nome}" data-doc="${_passageiro.p_cpf}">
                <span data-sentido="saida" class="${_passageiro.saida == 1 ? 'ok' : ''}"></span>
                <span data-sentido="volta" class="${_passageiro.volta == 1 ? 'ok' : ''}"></span>
              </div>`
                
              liPassageiro.addEventListener('click', ({currentTarget}) => currentTarget.querySelector('.passageiro_dados').classList.toggle('active'));
              
              listaCheckIn.appendChild(liPassageiro);

            })
          })

        }

        const checkInBoxes = document.querySelectorAll('span[data-sentido]');
        checkInBoxes.forEach(box => box.addEventListener('click', ({target}) => aerCheckIn(variation_id, target.parentElement.dataset.nome, target.parentElement.dataset.doc, target.dataset.sentido, target)));
        
      }
    }
  </script>
  <?php
}


?>
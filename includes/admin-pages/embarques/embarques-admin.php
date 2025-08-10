<?php
function embarques_admin_page(){
  global $wpdb;
  // $pontos_embarque = get_option('aer_embarques');

  // Nome da tabela que você quer verificar
  $nome_tabela = $wpdb->prefix . 'embarques'; 
  $embarques_db = $wpdb -> get_results("SELECT * from $nome_tabela");
  
  // Verifica se a tabela existe
  $tabela_reservas = $wpdb->get_var( "SHOW TABLES LIKE '$nome_tabela'" );

 ?> 
  <section id="admin-embarques">
    <div>
      <h1>NOVO PONTOS DE EMBARQUE</h1>
      <div class="admin-embarques-main">
        <ul id="embarques-sortable-list" data-sortable class="sortable-list">
        </ul>
        <div class="embarques-menu">
          <div class="embarques-menu-wrapper">
            <button class="admin-fancy-button" data-dialog-btn="add-embarque">Adicionar embarque</button>
            <button class="admin-fancy-button" data-dialog-btn="padroes-horarios">Configurar padrões</button>
          </div>
        </div>
      </div>
    </div>

    <?php include 'embarques-padroes.php'?>
    <?php include 'embarques-add.php'?>
    <?php include 'embarques-edit.php'?>

    <script>

      //Renderiza um elemento de lista para cada embarque
      const embarques_db = <?= json_encode($embarques_db); ?>;
      class EmbarqueItem {
        constructor(id, nome, endereco, obs, linkMapa){
          this.id = id,
          this.nome = nome,
          this.endereco = endereco,
          this.obs = obs,
          this.linkMapa = linkMapa
        }

        excluir(){
          if(window.confirm('Você deseja realmente apagar esse ponto de embarque?')){
            const _element = document.querySelector(`#embarques-sortable-list li.sortable-item[data-id="${this.id}"]`)

            fetchAdminAPI('excluir_embarque', {id: this.id}, function(_success, _data){

              if(_success){
                _element.classList.add('excluindo');    //Adiciona classe para estilizar o item que está sendo removido
                setTimeout(() => {
                  _element.remove();    //Remove o item do DOM
                  onDragEnd();                //Refaz a ordem dos embarques
                }, 600);

                console.log(_data)

              }else{
                console.log('ERRO: ' + _data)
              }

            })
          }
        }

        render(_pos = 'end'){
          // Crie o elemento <li>
          var li = document.createElement('li');
          li.className = 'sortable-item';
          li.setAttribute('data-id', this.id);

          // Crie o elemento <span> para a área de arrasto
          var spanDraggable = document.createElement('span');
          spanDraggable.className = 'draggable-area';
          li.appendChild(spanDraggable);

          // Crie o elemento <div> com a classe 'emb-flex'
          var divEmbFlex = document.createElement('div');
          divEmbFlex.className = 'emb-flex';
          li.appendChild(divEmbFlex);

          // Crie o elemento <div> com a classe 'emb-detalhes'
          var divEmbDetalhes = document.createElement('div');
          divEmbDetalhes.className = 'emb-detalhes';
          divEmbFlex.appendChild(divEmbDetalhes);

          // Crie os elementos <p> para 'nome' e 'endereco'
          var pNome = document.createElement('p');
          pNome.className = 'nome';
          pNome.innerText = this.nome;
          divEmbDetalhes.appendChild(pNome);

          var pEndereco = document.createElement('p');
          pEndereco.className = 'endereco';
          pEndereco.innerText = this.obs ? this.endereco + ' (' + this.obs +')' : this.endereco;
          divEmbDetalhes.appendChild(pEndereco);

          // Crie o elemento <div> com a classe 'emb-opcoes'
          var divEmbOpcoes = document.createElement('div');
          divEmbOpcoes.className = 'emb-opcoes';
          divEmbFlex.appendChild(divEmbOpcoes);

          // Crie os elementos <span> para botões de mapa, editar e excluir
          var linkMapBtn = document.createElement('a');
          linkMapBtn.href = this.linkMapa;
          linkMapBtn.setAttribute('target', '_blank');
          linkMapBtn.classList.add('map-link');
          var spanMapBtn = document.createElement('span');
          spanMapBtn.className = 'map-btn dashicons dashicons-location-alt';
          linkMapBtn.appendChild(spanMapBtn);
          divEmbOpcoes.appendChild(linkMapBtn);

          var spanEditarBtn = document.createElement('span');
          spanEditarBtn.className = 'editar-btn dashicons dashicons-edit';
          spanEditarBtn.dataset.dialogBtn = "edit-embarques";
          spanEditarBtn.dataset.id = this.id;
          divEmbOpcoes.appendChild(spanEditarBtn);

          var spanExcluirBtn = document.createElement('span');
          spanExcluirBtn.className = 'excluir-btn dashicons dashicons-trash';
          spanExcluirBtn.addEventListener('click', () => this.excluir())
          divEmbOpcoes.appendChild(spanExcluirBtn);

          // Adicione o elemento <li> ao DOM, por exemplo, em uma lista com id 'minha-lista'
          const refParent = document.getElementById('embarques-sortable-list');

          if(_pos === 'end') refParent.appendChild(li);
          else if(_pos === 'start') refParent.insertBefore(li, refParent.children[0]);

        }
      }
      embarques_db.forEach(_emb => {
        const _emb_item = new EmbarqueItem(_emb.id, _emb.nome, _emb.endereco, _emb.obs, _emb.link_mapa);
        _emb_item.render()
      })
      

      //Ordena e inicializa os itens arrstáveis
      jQuery(document).ready(function($) {
        // Array de IDs na ordem desejada
        var ordemDesejada = <?= json_encode(get_option('preset_ordem_embarques')); ?>;

        // Selecionar o contêiner pai
        var $lista = $('[data-sortable]');
        
        // Reordenar os elementos com base na array de IDs
        if(ordemDesejada){
          $.each(ordemDesejada, function(index, id) {
            var $item = $lista.find('.sortable-item[data-id="' + id + '"]');
            $lista.append($item);
          }); 
        }
        
        // Inicializar Sortable.js
        var sortable = new Sortable($lista[0], {
          animation: 150,
          handle: '.draggable-area',
          onEnd: () => onDragEnd(),
        });
      });


      //Configura os modais existentes na página
      const dialogs = document.querySelectorAll('dialog');
      dialogs.forEach(_dialog => {
        //Botão fechar modal
        _dialog.querySelector('span.dashicons-exit').addEventListener('click', () => _dialog.close());

        document.querySelectorAll(`[data-dialog-btn="${_dialog.dataset.dialog}"]`).forEach(_btn => _btn.addEventListener('click', () =>{
          if(_dialog.dataset.dialog === 'edit-embarques') {
            //Preenche os dados se for EDIT
            _dialog.dataset.id = _btn.dataset.id;
            _dialog.querySelector('form').dataset.id = _btn.dataset.id;
            const emb_obj = embarques_db.filter((_emb_db) => _emb_db.id == _btn.dataset.id)[0];
            _dialog.querySelector('#edit-embarque-form').children[1].querySelector('input').value = emb_obj.nome;
            _dialog.querySelector('#edit-embarque-form').children[2].querySelector('input').value = emb_obj.endereco;
            _dialog.querySelector('#edit-embarque-form').children[3].querySelector('input').value = emb_obj.obs;
            _dialog.querySelector('#edit-embarque-form').children[4].querySelector('input').value = emb_obj.link_mapa;
          }
          _dialog.showModal()
        }));
      })
      
      function onDragEnd(){
        const ordem = [];

        // Seleciona todos os elementos que correspondem ao seletor '[data-sortable] .sortable-item'
        var items = document.querySelectorAll('[data-sortable] .sortable-item');

        // Itera sobre cada elemento selecionado
        items.forEach(function(item) {
            // Adiciona o valor do atributo 'data-id' ao array 'ordem'
            ordem.push(+item.getAttribute('data-id'));
        });

        // Salvar a nova ordem (AJAX, etc.)
        console.log(ordem);

        fetchAdminAPI('handle_wp_option', {key: 'preset_ordem_embarques', newValue: ordem}, function(_success, _data){
          console.log(_data)
        }); 
      }

      function ajaxRequestSuccess(_success, _data, submitBtn, targetForm, postData){
        //Reset no botão submit
        submitBtn.removeAttribute('disabled');
        submitBtn.innerText = postData.id ? 'Atualizar embarque' : 'Adicionar embarque';
        
        const embTooltip = postData.id ? document.querySelector('#edit-embarque-form .emb-modal-tooltip') : document.querySelector('#add-embarque-form .emb-modal-tooltip');

        if(_success){
          embTooltip.classList.add('ativo', 'success');

          if(postData.id){
            const targetLi = document.querySelector(`#embarques-sortable-list li.sortable-item[data-id="${postData.id}"]`);
            targetLi.querySelector('.emb-detalhes p.nome').innerText = postData.nome;
            targetLi.querySelector('.emb-detalhes p.endereco').innerText = postData.endereco;
            if(postData.obs.length > 0){
              targetLi.querySelector('.emb-detalhes p.endereco').innerText = targetLi.querySelector('.emb-detalhes p.endereco').innerText + ' (' + postData.obs + ')';
            }
            targetLi.querySelector('.emb-opcoes a.map-link').href = postData.link_mapa;

          }else{
            targetForm.forEach(_inp => {_inp.setAttribute('value', ''); _inp.value = '';});
            const new_item = new EmbarqueItem(_data.new_id, postData.nome, postData.endereco, postData.obs, postData.link_mapa);
            new_item.render('start');
            onDragEnd()
          }
        }
        else embTooltip.classList.add('ativo', 'error');
        embTooltip.innerText = postData.id ?_data : _data.message;

        setTimeout(() => embTooltip.classList.value = 'emb-modal-tooltip', 2500);
      }
    </script>
  </section>
 <?php

}
?>

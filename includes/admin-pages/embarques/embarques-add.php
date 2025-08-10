<dialog id="embarques-add-modal" data-dialog="add-embarque">
  <span class="dashicons dashicons-exit" style="float:right; z-index: 1000"></span>
  <p>Adicionar ponto de embarque</p>
  <form id="add-embarque-form">
    <span class="emb-modal-tooltip">Ponto adicionado com sucesso!</span>
    <?php
      woocommerce_wp_text_input(array(
        'id'      => 'novo_emb_nome',
        'value'   => '',
        'label'   => 'Nome de referência',
      ));
     woocommerce_wp_text_input(array(
      'id'      => 'novo_emb_endereco',
      'value'   => '',
      'label'   => 'Endereço do ponto de embarque',
      ));
      woocommerce_wp_text_input(array(
        'id'      => 'novo_emb_obs',
        'value'   => '',
        'label'   => 'Observações sobre o ponto de embarque (opcional)',
      ));
      woocommerce_wp_text_input(array(
        'id'      => 'novo_emb_link_mapa',
        'value'   => '',
        'label'   => 'Link do maps',
      ));
    ?>

    <button id="add-embarque-submit" class="button button-small button-secondary">Adicionar embarque</button>
  </form>
</dialog>

<script>
  const addEmbarqueForm = document.querySelector('#add-embarque-form');
  const submitBtn = document.querySelector('#add-embarque-submit');

  addEmbarqueForm.addEventListener('submit', async (e) => {
    submitBtn.setAttribute('disabled', '');
    submitBtn.innerText = 'Aguarde...'
    e.preventDefault();
    const postData = {
      nome: e.target[0].value,
      endereco: e.target[1].value,
      obs: e.target[2].value,
      link_mapa: e.target[3].value,
    }

    function success(_success, _data){
      ajaxRequestSuccess(_success, _data, submitBtn, addEmbarqueForm, postData)
    }
    
    fetchAdminAPI('add_embarque', postData, success);

  })
</script>
<dialog id="embarques-edit-modal" data-dialog="edit-embarques">
  <span class="dashicons dashicons-exit" style="float:right; z-index: 1000"></span>
  <p>Editar ponto de embarque</p>
  <form id="edit-embarque-form">
    <span class="emb-modal-tooltip">Informações atualizadas com sucesso!</span>
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

    <button id="edit-embarque-submit" class="button button-small button-secondary">Atualizar embarque</button>
  </form>
</dialog>

<script>
  const editEmbarqueForm = document.querySelector('#edit-embarque-form');
  const editSubmitBtn = document.querySelector('#edit-embarque-submit');

  editEmbarqueForm.addEventListener('submit', async (e) => {
    editSubmitBtn.setAttribute('disabled', '');
    editSubmitBtn.innerText = 'Aguarde...';
    e.preventDefault();
    const postData = {
      id: e.target.dataset.id,
      nome: e.target[0].value,
      endereco: e.target[1].value,
      obs: e.target[2].value,
      link_mapa: e.target[3].value,
    }


    function success(_success, _data){
      ajaxRequestSuccess(_success, _data, editSubmitBtn, editEmbarqueForm, postData)
    }

    fetchAdminAPI('add_embarque', postData, success);


  })
</script>

<?php
$locais_embarque_exc = json_decode(get_post_meta(wp_get_post_parent_id($reserva['variation_id']), 'exc_embarques', true));
?>

<div class="modal fade alterar-embarque-modal" id="alterar-embarque-<?= $reserva['variation_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="alterar-embarque-<?= $reserva['variation_id']; ?>-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alterar-embarque-<?= $reserva['variation_id']; ?>-label">Alterar embarque</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Seu local de embarque atual:</p>
        <p><?= $reserva['local_embarque']; ?></p>        
      </div>


      <div class="modal-footer">
        <form action="" method="POST">
        <p>Selecione seu novo local de embarque:</p>
        <select name="novo_local_embarque">
        <?php
          foreach($locais_embarque_exc as $local_embarque){
            ?>
              <option value="<?= $local_embarque->nome . ' (' . $local_embarque->horario . ')'; ?>"><?= $local_embarque->nome . ' (' . $local_embarque->horario . ')'; ?></option>
            <?php
          }
        ?>  
        </select>
          <input type="hidden" name="variation_id" value="<?= $reserva['variation_id']; ?>">
          <input type="hidden" name="order_id" value="<?= $reserva['order_id']; ?>">
          <input type="hidden" name="order_index" value="<?= $reserva['order_index']; ?>">
          <input type="hidden" name="p_cpf" value="<?= $user->nickname; ?>">
          
          <input type="hidden" name="to" value="alterar_embarque">
          <div class="buttons-wrapper mt-4">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
            <button type="submit" class="btn btn-primary">Confirmar alteração</button>
          </div>
          
        </form>
      
      </div>
      
    </div>
  </div>
</div>
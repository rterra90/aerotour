<div class="modal fade cancelar-reserva-modal" id="cancelar-reserva-<?= $reserva['variation_id']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cancelar-reserva-<?= $reserva['variation_id']; ?>-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelar-reserva-<?= $reserva['variation_id']; ?>-label">Cancelar reserva</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Selecione as reservas que serão canceladas na excursão <?= $reserva['nome']; ?></p>

        <div class="passageiros mt-2 mb-3">
          <ul>
            <li>
              <label>
                <input type="checkbox" name="cancel_res" value="">
                <?= $reserva['passageiro']['nome_completo']; ?>
              </label>
            </li>
            <?php 
            if(isset($reserva['dependentes'])){
              foreach($reserva['dependentes'] as $res_dep){
                ?>
                <li>
                  <label>
                    <input type="checkbox" name="cancel_res" value="">
                    <?= $res_dep['passageiro']['nome_completo']; ?>
                  </label>
                </li>
                <?php
              }
            }
            ?>
          </ul>
        </div>


        <p>Ao prosseguir, será aberta uma solicitação de reembolso e seus dados serão removidos da lista de passageiros.</p>
        <div class="cancelamento-taxa">
          <span>Taxa de cancelamento: <i>10%</i></span>
          <span>Valor reembolsável: <i>R$ <?= (int)preco_item_cancel(876, $reserva['variation_id']) * (9/10); ?>,00</i></span>
          <!-- substituir 876 por $reserva['order_id'] -->
          
        </div>

        
      </div>
      <div class="modal-footer">
        <form action="" method="POST">
          <label for="reason-<?= $reserva['variation_id']; ?>">Conte-nos o motivo do cancelamento &nbsp;<i>(opcional)</i></label>
          <textarea name="motivo" id="reason-<?= $reserva['variation_id']; ?>" rows="2"></textarea>

          <input type="hidden" name="variation_id" value="<?= $reserva['variation_id']; ?>">
          <input type="hidden" name="order_id" value="<?= $reserva['order_id']; ?>">
          <input type="hidden" name="to" value="cancel">
          <div class="buttons-wrapper">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
            <button type="submit" class="btn btn-primary">Prosseguir com cancelamento</button>
          </div>
          
        </form>
      
      </div>
      
    </div>
  </div>
</div>
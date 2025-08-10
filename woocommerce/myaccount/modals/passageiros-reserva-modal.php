<div class="modal fade passageiros-reserva-modal" id="passageiros-reserva-<?= $reserva['variation_id']; ?>" data-bs-keyboard="false" tabindex="-1" aria-labelledby="passageiros-reserva-<?= $reserva['variation_id']; ?>-label" aria-hidden="true">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelar-reserva-<?= $reserva['variation_id']; ?>-label">Passageiros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php
          $qtd_passageiros = isset($reserva['dependentes']) ? sizeof($reserva['dependentes']) + 1 : 1;
        ?>
        <span>Excursão <?= $reserva['nome']; ?></span>
        <p>Reserva para <?= $qtd_passageiros; ?> <?= $qtd_passageiros > 1 ? 'passageiros' : 'passageiro'; ?></p>

        <div class="passageiros my-3">
          <ul class="d-flex flex-column gap-2">
            <li class="d-flex gap-2">
            <div>
												<svg xmlns="http://www.w3.org/2000/svg" width="12.211" height="8.141" viewBox="0 0 12.211 8.141">
													<path id="Icon_awesome-ticket-alt" data-name="Icon awesome-ticket-alt" d="M2.714,6.535H9.5v4.07H2.714Zm8.48,2.035a1.018,1.018,0,0,0,1.018,1.018v2.035a1.018,1.018,0,0,1-1.018,1.018H1.018A1.018,1.018,0,0,1,0,11.623V9.588A1.018,1.018,0,0,0,1.018,8.57,1.018,1.018,0,0,0,0,7.553V5.518A1.018,1.018,0,0,1,1.018,4.5H11.193a1.018,1.018,0,0,1,1.018,1.018V7.553A1.018,1.018,0,0,0,11.193,8.57Zm-1.018-2.2a.509.509,0,0,0-.509-.509H2.544a.509.509,0,0,0-.509.509v4.409a.509.509,0,0,0,.509.509H9.667a.509.509,0,0,0,.509-.509Z" transform="translate(0 -4.5)" fill="#707070"/>
												</svg>
											</div>
                      <div>
                        <p class="mb-0"><?= $reserva['passageiro']['nome_completo']; ?></p>
                        <p>
                          <span>CPF: <?= $reserva['passageiro']['doc']; ?></span>
                          <span>Telefone: <?= $reserva['passageiro']['telefone']; ?></span>
                        </p>
                      </div>
              
            </li>
            <?php 
            if(isset($reserva['dependentes'])){
              foreach($reserva['dependentes'] as $res_dep){
                ?>
                <li class="d-flex gap-2">
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="12.211" height="8.141" viewBox="0 0 12.211 8.141">
                      <path id="Icon_awesome-ticket-alt" data-name="Icon awesome-ticket-alt" d="M2.714,6.535H9.5v4.07H2.714Zm8.48,2.035a1.018,1.018,0,0,0,1.018,1.018v2.035a1.018,1.018,0,0,1-1.018,1.018H1.018A1.018,1.018,0,0,1,0,11.623V9.588A1.018,1.018,0,0,0,1.018,8.57,1.018,1.018,0,0,0,0,7.553V5.518A1.018,1.018,0,0,1,1.018,4.5H11.193a1.018,1.018,0,0,1,1.018,1.018V7.553A1.018,1.018,0,0,0,11.193,8.57Zm-1.018-2.2a.509.509,0,0,0-.509-.509H2.544a.509.509,0,0,0-.509.509v4.409a.509.509,0,0,0,.509.509H9.667a.509.509,0,0,0,.509-.509Z" transform="translate(0 -4.5)" fill="#707070"/>
                    </svg>
                  </div>
                  <div><p class="mb-0"><?= $res_dep['passageiro']['nome_completo']; ?><p>
                  <span>CPF: <?= $res_dep['passageiro']['doc']; ?></span>
                  <span>Telefone: <?= $res_dep['passageiro']['telefone']; ?></span></div>
                  
                </li>
                <?php
              }
            }
            ?>
          </ul>
        </div>

        
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
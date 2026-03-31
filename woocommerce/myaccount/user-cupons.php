<?php
$customer_cupons = get_user_meta($current_user->ID, 'cupons', true);
?>
<section class="customer_cupons">
  <h3>Seus cupons</h3>
  <div>
    <?php
    $customer_cupons = get_user_meta($current_user->ID, 'cupons', true);
    if ($customer_cupons !== '') {
      $cupons_ativos = array();
      $cupons_inativos = array();
      $customer_cupons_obj = json_decode($customer_cupons);

      foreach ($customer_cupons_obj as $_cupom_id) {
        if (is_numeric($_cupom_id)) {
          $__cupom = get_post($_cupom_id);
          if ($__cupom && $__cupom->post_type == 'shop_coupon') {

            // Instancia objeto do cupom
            $new_cupom = new WC_Coupon($_cupom_id);

            // Verifica se cliente já utilizou esse cupom
            $coupon_code_usado = in_array($current_user->ID, $new_cupom->get_used_by());

            // Se há expire date, verifica se já extá expirado
            if ($new_cupom->get_date_expires()) {
              $coupon_code_expirado = strtotime($new_cupom->get_date_expires()) < strtotime(date('d-m-Y')) ? true : false;
            } else $coupon_code_expirado = false;

            // Pega os pedidos do usuário
            $customer_orders = wc_get_orders(array('customer_id' => $current_user->ID));

            // se o cupom já foi usado, busca o pedido em que foi utilizado; 
            if ($coupon_code_usado === true) {
              foreach ($customer_orders as $customer_order) {
                $cupons_do_pedido = $customer_order->get_coupon_codes();
                if ($customer_order->get_status() === 'completed') {
                  if (is_array($cupons_do_pedido) && sizeof($cupons_do_pedido) > 0) {
                    if ($cupons_do_pedido[0] === $new_cupom->code) {
                      // quando encontrar, insere em $cupons_inativos uma array com informações do cupom e do seu uso
                      array_push($cupons_inativos, array($new_cupom, $customer_order->get_status(), $customer_order->get_date_paid()));
                    }
                  }
                }
              }
              // se o cupom expirou, insere em $cupons_inativos
            } else if ($coupon_code_expirado === true) {
              array_push($cupons_inativos, array($new_cupom, 'expired', $new_cupom->get_date_expires()));
            } else array_push($cupons_ativos, $new_cupom);
          }
        }
      }




      if (sizeof($cupons_ativos) > 0) {
    ?>
        <h4>Ativos</h4>
        <div>
          <?php
          foreach ($cupons_ativos as $cupom_ativo) {
          ?>
            <div class="aer_cupom ativo">
              <p class="code_title"><?= strtoupper($cupom_ativo->code); ?></p>
              <div class="d-flex justify-content-between">
                <span>
                  <?= $cupom_ativo->get_discount_type() === 'percent' ? $cupom_ativo->get_amount() . '% de desconto' : 'R$ ' . $cupom_ativo->get_amount() . ' de desconto' ?>
                </span>
                <span>
                  Válido até <?= str_replace('-', '/', date("d-m-Y", strtotime($cupom_ativo->get_date_expires()))); ?>
                </span>
              </div>
            </div>
          <?php
          }
          ?>
        </div>
      <?php
      } else echo '<p class="no-user-coupons-placeholder my-3">Nenhum cupom ativo no momento...</p>';


      if (sizeof($cupons_inativos) > 0) {
      ?>
        <div id="historico-cupons" class="historico-cupons mt-2">
          <span onclick="handleHistoricoCupons('historico-cupons')">Histórico de cupons <span>></span></span>
          <div id="historico-cupons-wrapper">
            <?php
            foreach ($cupons_inativos as $cupom_inativo) {
            ?>
              <div class="aer_cupom usado">
                <p class="code_title"><?= strtoupper($cupom_inativo[0]->code); ?></p>
                <div><?= $cupom_inativo[1] === 'completed' ? 'Utilizado em ' : 'Expirado em '; ?> <span><?= date('d/m/Y', strtotime($cupom_inativo[2])); ?></span></div>
              </div>
            <?php
            }
            ?>
          </div>

        </div>
    <?php
      }
    } else echo '<p class="sem-cupom-placeholder">Nenhum cupom no momento...</p>'
    ?>
  </div>
  <script>
    function handleHistoricoCupons(elementId) {
      document.getElementById(elementId).classList.toggle('active');
    }
  </script>
</section>
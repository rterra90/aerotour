<?php
// Adiciona o container de resumo antes do formulário de faturamento
add_action('woocommerce_before_checkout_billing_form', 'render_billing_summary_container');
function render_billing_summary_container()
{
  echo '<div id="billing-summary-section" style="display:none;">
            <div class="summary-content"></div>
            <div class="summary-footer">
              <button type="button" id="edit-billing-data" class="edit-billing edit-billing-data">
                  <i class="bi bi-pencil-fill"></i> Editar
              </button>
            </div>
          </div>';
}


// Remove campos desnecessários do checkout
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields)
{
  unset($fields['billing']['billing_company']); //remover empresa
  unset($fields['billing']['billing_address_1']); //remover endereço 1
  unset($fields['billing']['billing_address_2']); //remover endereço 2
  unset($fields['billing']['billing_city']); //remover cidade
  unset($fields['billing']['billing_postcode']); //remover cep
  unset($fields['billing']['billing_country']); //remover país 
  unset($fields['billing']['billing_state']); //remover estado
  return $fields;
}

// // Accordion métodos de pagamento em payment.php
// add_action('woocommerce_review_order_after_payment', 'accordion_formas_pagamento');
// function accordion_formas_pagamento()
// {
//     ?>
//     <script>
//         document.addEventListener('DOMContentLoaded', function () {
//             const acc = document.getElementById('accordionFormasPagamento');
//             if (acc) {
//                 const items = acc.querySelectorAll('.wc_payment_method');
//                 items.forEach(item => {
//                     const label = item.querySelector('label');
//                     const box = item.querySelector('.payment_box');
//                     if (label && box) {
//                         label.addEventListener('click', () => {
//                             // Fecha todos os boxes
//                             items.forEach(i => {
//                                 const b = i.querySelector('.payment_box');
//                                 if (b) b.style.display = 'none';
//                             });
//                             // Abre o box do método selecionado
//                             box.style.display = 'block';
//                         });
//                     }
//                 });
//             }
//         });
//     </script>
//     <?php
// }
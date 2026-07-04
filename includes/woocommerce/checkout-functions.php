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

// Accordion métodos de pagamento em payment.php
// add_action('woocommerce_review_order_after_payment', 'accordion_formas_pagamento');
function accordion_formas_pagamento()
{
    ?>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     const acc = document.getElementById('accordionFormasPagamento');
        //     if (acc) {
        //         const items = acc.querySelectorAll('.wc_payment_method');
        //         items.forEach(item => {
        //             const label = item.querySelector('label');
        //             const box = item.querySelector('.payment_box');
        //             if (label && box) {
        //                 label.addEventListener('click', () => {
        //                     // Fecha todos os boxes
        //                     items.forEach(i => {
        //                         const b = i.querySelector('.payment_box');
        //                         if (b) b.style.display = 'none';
        //                     });
        //                     // Abre o box do método selecionado
        //                     box.style.display = 'block';
        //                 });
        //             }
        //         });
        //     }
        // });
    </script>
    <?php
}

/* ************************************************************************** */
/* Fluxo de validação de reservas no carrinho e checkout */
/* Impede que itens com embarque ou horários indisponíveis sejam mantidos no carrinho, avancem ao checkout ou concluam pagamento */

/* função auxiliar que verifica se os detalhes de embarque do item estão disponíveis */
function verificar_item_embarque_disponivel($cart_item) {
    // 1. Verifica se o item possui os dados de embarque na sessão do carrinho
    if (!isset($cart_item['variation_id']) || !isset($cart_item['embarque']) || !isset($cart_item['horario'])) {
        return false; // Se não houver dados de embarque, invalida o item
    }

    $variation_id = $cart_item['variation_id'];
    $embarque_id  = (int) $cart_item['embarque'];
    $horario_cart = $cart_item['horario'];

    // 2. Busca a nova arquitetura de configurações da variação correspondente
    $embarques_meta = get_post_meta($variation_id, '_embarques_config', true);
    $embarques_config = $embarques_meta ? json_decode($embarques_meta, true) : [];

    $embarque_valido = false;

    // 3. Varre as configurações procurando o ID do embarque e o horário específico
    foreach ($embarques_config as $emb) {
        if ((int) $emb['embarque_id'] === $embarque_id) {
            foreach ($emb['horarios'] as $h) {
                if ($h['horario'] === $horario_cart && isset($h['disponivel']) && $h['disponivel'] === true) {
                    $embarque_valido = true;
                    break 2; // Encontrou o registro idêntico e ativo, interrompe os loops
                }
            }
        }
    }

    return $embarque_valido;
}

add_action('woocommerce_check_cart_items', 'check_reservas_cart_and_checkout');
function check_reservas_cart_and_checkout()
{
    // Só executa se o carrinho possuir itens
    if (WC()->cart->is_empty()) return;

    // Armazena temporariamente as mensagens para não duplicar se rodar mais de uma vez no mesmo request
    static $validado = false;
    if ($validado) return;
    $validado = true;

    // Remove notices antigos de embarque para evitar o acúmulo e duplicação
    if (function_exists('wc_clear_notices')) {
        // Nota: Não limpamos tudo de uma vez aqui para não quebrar cupons ou outros alertas do WC,
        // controlamos a inserção de forma única por ciclo de execução.
    }

    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $disponivel = verificar_item_embarque_disponivel($cart_item);

        if (!$disponivel) {
            $produto = $cart_item['data'];
            $nome_produto = $produto ? $produto->get_name() : 'Excursão';
            $mensagem_erro = sprintf(
                __('Lamentamos, mas o local ou horário de embarque selecionado para a excursão <strong>"%s"</strong> não está mais disponível. Por favor, remova o item e altere sua reserva para prosseguir.', 'woocommerce'),
                $nome_produto
            );

            // Evita injetar a mesma mensagem idêntica se ela já existir na sessão do WC
            if (!wc_has_notice($mensagem_erro, 'error')) {
                wc_add_notice($mensagem_erro, 'error');
            }
        }
    }
}

/**
 * Validação de segurança extra executada no envio final do formulário de checkout
 */
function validar_disponibilidade_embarque_checkout($data, $errors) {
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $disponivel = verificar_item_embarque_disponivel($cart_item);

        if (!$disponivel) {
            $produto = $cart_item['data'];
            $nome_produto = $produto ? $produto->get_name() : 'Excursão';

            
            // Adiciona o erro diretamente na pilha do validador de formulário do checkout

            //verifica se o erro já não foi adicionado em $errors para evitar duplicidade
            $existing_errors = $errors->get_error_codes();
            if (!in_array('embarque_indisponivel', $existing_errors)) {
                $errors->add(
                    'embarque_indisponivel',
                    sprintf(
                        __('O embarque escolhido para a excursão <strong>"%s"</strong> tornou-se indisponível. Volte ao carrinho para atualizar sua opção.', 'woocommerce'),
                        $nome_produto
                    )
                );
            }

        }
    }
}

/**
 * Se o usuário tentar acessar o checkout com erros no carrinho (ex: embarque indisponível),
 * redireciona-o automaticamente de volta para a página do carrinho.
 */
add_action('template_redirect', 'redirecionar_erros_checkout_para_carrinho');
function redirecionar_erros_checkout_para_carrinho() {
if (is_checkout() && !is_order_received_page() && function_exists('WC')) {
        
        // Em vez de chamar a função que cria novos notices, nós apenas checamos matematicamente se há algum erro ativo de disponibilidade
        $ha_indisponibilidade = false;
        
        foreach (WC()->cart->get_cart() as $cart_item) {
            if (!verificar_item_embarque_disponivel($cart_item)) {
                $ha_indisponibilidade = true;
                break;
            }
        }

        if ($ha_indisponibilidade) {
            // Limpa mensagens residuais que possam ter sido geradas na sessão errada do checkout
            wc_clear_notices();
            
            // Força a execução limpa da inserção do notice no carrinho uma única vez antes de redirecionar
            check_reservas_cart_and_checkout();
            
            wp_safe_redirect(wc_get_cart_url());
            exit;
        }
    }
}

/**
 * Customiza mensagens de erro do WooCommerce (Estoque Esgotado)
 */
add_filter('woocommerce_add_error', 'aerotour_customizar_mensagens_erro_wc');
function aerotour_customizar_mensagens_erro_wc($mensagem) {

    //pega o termo entre aspas duplas da mensagem original para identificar o produto
    $matches = [];
    preg_match('/"([^"]*)"/', $mensagem, $matches);
    $nome_excursao = isset($matches[1]) ? $matches[1] : '';
    


    // 1. Intercepta a mensagem padrão de falta de estoque/esgotado
    // O WC nativamente usa "não está em estoque" ou "vagas restantes"
    if (strpos($mensagem, 'não está em estoque') !== false || strpos($mensagem, 'estoque esgotado') !== false || strpos($mensagem, 'em falta no estoque') !== false) {
        $mensagem = __('Ops! As vagas para a excursão<b>' . (isset($nome_excursao) ? " $nome_excursao " : '') . '</b>se esgotaram. Por favor, verifique outras datas disponíveis ou remova o item do carrinho.', 'woocommerce');
    }

    return $mensagem;
}
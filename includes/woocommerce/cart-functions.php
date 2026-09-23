<?php

// // // /
// Cabeçalho personalizado do carrinho
add_action( 'woocommerce_before_cart', 'aerotour_custom_cart_progress_header', 5 );
function aerotour_custom_cart_progress_header() {
    // Busca o link da página principal de excursões/loja
    $shop_url = wc_get_page_permalink( 'shop' );
    ?>
    <div class="aerotour-cart-header">
        
        <!-- Barra de Progresso (Stepper) -->
        <?php
        // Inclui a barra de progresso do checkout
        get_template_part( 'includes/reserva-progress-bar', null, array( 'step' => 2 ) );
        ?>

        <!-- Banner Informativo -->
        <div class="cart-info-banner">
            <!-- <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg> -->
             
            <div class="cart-info-text">
                
                <p><strong><i class="bi bi-cart-fill"> </i>Confira sua reserva: </strong>revise os dados dos passageiros e o embarque escolhido. Você também pode <a href="<?php echo esc_url( $shop_url ); ?>">adicionar outra excursão</a> antes de seguir ao pagamento e fechar tudo em um único pedido.</p>
            </div>
        </div>

    </div>
    <?php
}

?>
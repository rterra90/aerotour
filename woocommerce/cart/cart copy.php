<?php
defined('ABSPATH') || exit();

do_action('woocommerce_before_cart');

global $woocommerce;
global $wpdb;
$items_carrinho = $woocommerce->cart->get_cart();
?>

<link rel="stylesheet" href="<?= esc_url(
  get_stylesheet_directory_uri()
) ?>/css/woocommerce/carrinho.min.css?ver=<?= time() ?>">
<link rel="stylesheet" href="<?= esc_url(
  get_stylesheet_directory_uri()
) ?>/css/includes/banner-cupom.css">

<h1 class="mt-2">Carrinho de reservas</h1>

<div class="notices woocommerce-notices-wrapper">
    <?php wc_print_notices(); ?>
</div>

<div id="carrinho-container" class="row">
    <form class="woocommerce-cart-form col-lg-8" action="<?php echo esc_url(
      wc_get_cart_url()
    ); ?>" method="post">
        <?php do_action('woocommerce_before_cart_table'); ?>

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <tbody>
                <?php do_action('woocommerce_before_cart_contents'); ?>

                <?php foreach (
                  WC()->cart->get_cart()
                  as $cart_item_key => $cart_item
                ):

                  $emb_id = intval($cart_item['embarque']);
                  $embarque = $wpdb->get_var(
                    $wpdb->prepare(
                      'SELECT nome FROM aer_embarques WHERE id = %d',
                      $emb_id
                    )
                  );

                  $passageiros = json_decode(
                    str_replace('\"', '"', $cart_item['passageiros'])
                  );
                  $passageiros = array_filter($passageiros);

                  $_product = $cart_item['data'];
                  $product_id = $cart_item['product_id'];
                  $product_name = $_product->get_name();

                  $data_exc = explode(' - ', $product_name);
                  $data_exc = end($data_exc);

                  $remove_url = wc_get_cart_remove_url($cart_item_key);

                  if (
                    $_product &&
                    $_product->exists() &&
                    $cart_item['quantity'] > 0
                  ): ?>
                        
                        <div class="cart-item" data-cart-key="<?= esc_attr(
                          $cart_item_key
                        ) ?>">
                            <!-- Botão remover -->
                            <a href="<?= esc_url($remove_url) ?>" 
                               class="remove-item" 
                               aria-label="<?php esc_attr_e(
                                 'Remover',
                                 'woocommerce'
                               ); ?>" 
                               data-product_id="<?= esc_attr($product_id) ?>" 
                               data-cart_item_key="<?= esc_attr(
                                 $cart_item_key
                               ) ?>" 
                               data-product_sku="<?= esc_attr(
                                 $_product->get_sku()
                               ) ?>">
                               ✖
                            </a>

                            <!-- Informações da excursão -->
                            <div class="tour-info">
                              <?php
                              // Se for uma variação, pega o ID do produto pai
                              $parent_id = $_product->is_type('variation')
                                ? $_product->get_parent_id()
                                : $_product->get_id();
                              $parent_permalink = get_permalink($parent_id);
                              ?>

																<a class="title-link" href="<?= esc_url($parent_permalink) ?>">
																		<h3 class="bg-title">
																				Excursão <?= esc_html(
                      preg_replace(
                        '/ - \d{2}\/\d{2}\/\d{4}$/',
                        '',
                        $product_name
                      )
                    ) ?>
																		</h3>
																</a>

                                
                                <div class="d-flex justify-content-between">
                                    <?php if ($data_exc): ?>
                                        <p><strong>Data:</strong> <?= esc_html(
                                          $data_exc
                                        ) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($cart_item['horario'])): ?>
                                        <p class="w-50"><strong>Horário:</strong> <?= esc_html(
                                          $cart_item['horario']
                                        ) ?></p>
                                    <?php endif; ?>
                                </div>

                                <?php if (!empty($embarque)): ?>
                                    <p><strong>Embarque:</strong> <?= esc_html(
                                      $embarque
                                    ) ?></p>
                                <?php endif; ?>

                                <p><strong>Valor:</strong>
                                    <?php
                                    if (
                                      $_product->get_meta('preco_original') &&
                                      $_product->get_meta(
                                        'desconto_antecipado_rev'
                                      ) !== false
                                    ) {
                                      echo '<span class="preco-original">R$ ' .
                                        esc_html(
                                          $_product->get_meta('preco_original')
                                        ) .
                                        '</span>';
                                    }
                                    echo WC()->cart->get_product_subtotal(
                                      $_product,
                                      $cart_item['quantity']
                                    );
                                    ?>
                                </p>

                                <?php if (
                                  !empty($cart_item['desconto_antecipado']) &&
                                  $_product->get_meta(
                                    'desconto_antecipado_rev'
                                  ) === true
                                ): ?>
                                    <p class="desconto-antecipado-alert">
                                        Desconto de 5% válido até <?= esc_html(
                                          data_to_dmy(
                                            $_product->get_meta(
                                              'data_limite_desconto'
                                            )
                                          )
                                        ) ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <!-- Passageiros -->
                            <?php if (!empty($passageiros)): ?>
                                <div class="passengers">
                                    <button type="button" data-qty="<?= count(
                                      $passageiros
                                    ) ?>" class="toggle-passengers secondary-btn toggle-active">
                                        Ver passageiros (<?= count(
                                          $passageiros
                                        ) ?>)
                                    </button>
                                    <div class="passenger-list">
                                        <?php foreach (
                                          $passageiros
                                          as $passenger
                                        ): ?>
                                            <div class="passenger">
                                                <p><strong>Nome:</strong> <?= esc_html(
                                                  $passenger->nome_completo
                                                ) ?></p>
                                                <p><strong>CPF:</strong> <?= esc_html(
                                                  $passenger->cpf
                                                ) ?></p>
                                                <p><strong>Celular:</strong> <?= esc_html(
                                                  $passenger->celular
                                                ) ?></p>
																								<div>
																									<p><strong>Nascimento:</strong> <?= esc_html(
                           data_to_dmy($passenger->data_nascimento)
                         ) ?></p>
                                                <span class="rota">
                                                    <?= strtoupper(
                                                      $passenger->tripType ===
                                                      'ida-e-volta'
                                                        ? 'Ida e volta'
                                                        : 'Apenas ' .
                                                          $passenger->tripType
                                                    ) ?>
                                                </span>
																								</div>
                                                
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif;
                  ?>
                <?php
                endforeach; ?>

                <?php do_action('woocommerce_cart_contents'); ?>
                <?php do_action('woocommerce_after_cart_contents'); ?>
            </tbody>
        </table>

        <div class="pt-3">
            <tr>
                <td colspan="6" class="actions">
                    <?php if (wc_coupons_enabled()): ?>
                        <div class="coupon">
                            <label for="coupon_code" class="screen-reader-text" onclick="toggleCupomInputs('coupon_inputs')">Tem um cupom de desconto?</label> 
                            <div id="coupon_inputs">
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" placeholder="<?php esc_attr_e(
                                  'Coupon code',
                                  'woocommerce'
                                ); ?>" />
                                <button type="submit" class="button btn cart-btn-style" name="apply_coupon" value="<?php esc_attr_e(
                                  'Apply coupon',
                                  'woocommerce'
                                ); ?>">
                                    <?php esc_html_e(
                                      'Apply coupon',
                                      'woocommerce'
                                    ); ?>
                                </button>
                            </div>
                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php endif; ?>

                    <?php do_action('woocommerce_cart_actions'); ?>
                    <?php wp_nonce_field(
                      'woocommerce-cart',
                      'woocommerce-cart-nonce'
                    ); ?>
                </td>
            </tr>
        </div>

        <?php do_action('woocommerce_after_cart_table'); ?>
    </form>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>
    <div class="col-lg-4">
        <div class="cart-collaterals">
            <?php do_action('woocommerce_cart_collaterals'); ?>
        </div>
    </div>
</div>

<script>

</script>

<?php
do_action('woocommerce_after_cart');

//Enfileira o script customizado do carrinho
wp_enqueue_script(
  'cart-custom-js',
  get_stylesheet_directory_uri() . '/js/cart.js',
  ['jquery'],
  time(),
  true
);


?>

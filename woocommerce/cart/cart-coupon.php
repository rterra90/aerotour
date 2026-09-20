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
                        ); ?>" onclick="return submitCouponForm(this)">
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
<script>
function submitCouponForm(button) {
    var form = button.closest('form');
    if (form) {
        form.submit();
    }
    return false;
}
</script>

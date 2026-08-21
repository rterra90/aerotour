<?php
defined('ABSPATH') || exit;

// do_action('woocommerce_before_account_orders', $has_orders); ?>

<h2 class="mb-4">Meus pedidos</h2>

<?php if ($has_orders) : ?>
  <div>
    <div id="orders-table" class="d-flex gap-2 flex-column">
      <div class="table-header py-3 px-1">
        <span class="header-order-number">#</span>
        <span class="header-order-data">Data</span>
        <span style="flex-grow:1">Reservas</span>
        <span class="header-order-status">Status</span>
        <span class="header-order-total">Total</span>
        <span style="width: 110px">Ações</span>
      </div>
      <?php
      foreach ($customer_orders->orders as $customer_order) {
        $order = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
        $item_count = $order->get_item_count() - $order->get_item_count_refunded();
      ?>
        <div class="table-row p-1 <?= esc_attr($order->get_status()); ?>">
          <span class="order-number">
            <a href="<?php echo esc_url($order->get_view_order_url()); ?>">
              #<?php echo esc_html($order->get_order_number()); ?>
            </a>
          </span>

          <span class="order-data">
            <?= $order->get_date_created()->date('d/m/Y'); ?>
          </span>

          <span class="order-name">
            <?php foreach ($order->get_items() as $item) : ?>
              <?php
              $item_name = $item->get_product()->get_name();
              $ultimosQuatro = substr($item_name, -4);
              if (is_numeric($ultimosQuatro)) $item_name = substr($item_name, 0, -13);
              ?>
              <p><?= esc_html($item_name); ?></p>
            <?php endforeach; ?>
          </span>

          <span class="order-status">
            <?= esc_html(wc_get_order_status_name($order->get_status())); ?>
          </span>

          <span class="order-total">
            <?= $order->get_formatted_order_total(); ?>
          </span>

          <span class="order-buttons d-flex gap-2">
            <?php
            $actions = wc_get_account_orders_actions($order);
            foreach ($actions as $key => $action) {
              if ($key !== 'cancel') {
                echo '<a href="' . esc_url($action['url']) . '" class="button ' . sanitize_html_class($key) . '" title="' . esc_attr($action['name']) . '">' . aer_icons($key, 18, 18) . '</a>';
              }
            }
            ?>
          </span>
        </div>
      <?php
      }
      ?>
    </div>
  </div>


  <?php do_action('woocommerce_before_account_orders_pagination'); ?>

  <?php if (1 < $customer_orders->max_num_pages) : ?>
    <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
      <?php if (1 !== $current_page) : ?>
        <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('Previous', 'woocommerce'); ?></a>
      <?php endif; ?>

      <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
        <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('Next', 'woocommerce'); ?></a>
      <?php endif; ?>
    </div>
  <?php endif; ?>

<?php else : ?>

  <div class="account-empty-placeholder pedidos">
    <div class="placeholder-content text-center">
      <div class="dashboard-placeholder-icon mb-4">
        <svg viewBox="0 0 24 24" fill="none" stroke="#400f0f" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="width: 80px; height: 80px; opacity: 0.35;">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="16" y1="13" x2="8" y2="13"></line>
          <line x1="16" y1="17" x2="8" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
      </div>

      <h3>Nenhum pedido por aqui</h3>

      <p class="text-muted mb-4" style="max-width: 400px; margin: 0 auto; font-size: 0.95rem;">
        Nesta página você encontra o <strong>histórico financeiro</strong> de suas compras, como métodos de pagamento e valores valores e status dos pedidos.
        <br><br>
        <small>As informações sobre datas, locais de embarque e vouchers das suas viagens ficarão disponíveis na página <strong>Minhas Reservas</strong>.</small>
      </p>

      <div class="placeholder-actions">
        <a href="<?= esc_url(wc_get_page_permalink('shop')) ?>" class="ae-btn-primary">
          Começar minha primeira compra
        </a>
      </div>
    </div>
  </div>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
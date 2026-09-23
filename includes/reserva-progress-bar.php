<?php
$args = isset($args) ? $args : array();
$step = isset($args['step']) ? $args['step'] : 1;
$order_status = isset($args['order_status']) ? $args['order_status'] : '';
if (!function_exists('last_step_class')) {
    function last_step_class($step, $order_status) {
        $return_class = '';
        if($step == 4 && $order_status == 'pending') {
            $return_class = 'active';
        }else if($step >= 4 && $order_status == 'completed') {
            $return_class = 'final completed';
        }else if($step >= 4 && $order_status == 'cancelled') {
            $return_class = 'cancelled';
        }
        return $return_class;
    }
}
if (!function_exists('last_step_label')) {
    function last_step_label($step, $order_status) {
        $label = 'Conclusão';
        if($step == 4 && $order_status == 'pending') {
            $label = 'Aguardando Pagamento';
        }else if($step >= 4 && $order_status == 'completed') {
            $label = 'Concluído';
        }else if($step >= 4 && $order_status == 'cancelled') {
            $label = 'Cancelado';
        }
        return $label;
    }
}

?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/includes/reserva-progress-bar.min.css">

<div class="checkout-progress-bar">
    <div class="step <?php echo $step == 1 ? 'active' : ($step > 1 ? 'completed' : ''); ?>">
        <span class="step-circle">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="3" fill="none"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </span>
        <span class="step-label">Excursão</span>
    </div>
    <div class="step <?php echo $step == 2 ? 'active' : ($step > 2 ? 'completed' : ''); ?>">
        <span class="step-circle">2</span>
        <span class="step-label">Carrinho</span>
    </div>
    <div class="step <?php echo $step == 3 ? 'active' : ($step > 3 ? 'completed' : ''); ?>">
        <span class="step-circle">3</span>
        <span class="step-label">Pagamento</span>
    </div>
    <div class="step <?php echo last_step_class($step, $order_status); ?>">
        <span class="step-circle">4</span>
        <span class="step-label"><?php echo last_step_label($step, $order_status); ?></span>
    </div>
</div>

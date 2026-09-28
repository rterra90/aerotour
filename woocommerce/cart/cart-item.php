<?php
// Obtém os dados do item do carrinho a partir dos argumentos passados para o template.
$cart_item = $args['item']; 

// Obtém as variáveis a partir do item do carrinho.
$cart_item_key = $args['cart_item_key'];
$product_id = $cart_item['product_id'];
$product_name = $cart_item['data']->get_name();
$_product = $cart_item['data'];
$data_exc = explode(' - ', $product_name);
$data_exc = end($data_exc); //formato dd/mm/aaaa
$data_iso = date('Y-m-d', strtotime(str_replace('/', '-', $data_exc)));
$remove_url = wc_get_cart_remove_url($cart_item_key);
$embarque_dia_anterior = !empty($cart_item['dia_anterior']) ? ($cart_item['dia_anterior'] === 'dia-anterior' ? true : false) : false;
$passageiros = !empty($args['passageiros']) ? $args['passageiros'] : 0;
?>

<div class="cart-item-modern" data-cart-key="<?= esc_attr($cart_item_key) ?>">    
    <!-- Cabeçalho do Card: Título e Botão Fechar -->
    <div class="cart-item-header">
        <?php
        $parent_id = $_product->is_type('variation') ? $_product->get_parent_id() : $_product->get_id();
        $parent_permalink = get_permalink($parent_id);
        $clean_title = preg_replace('/ - \d{2}\/\d{2}\/\d{4}$/', '', $product_name);
        ?>
        <a class="item-title-link" href="<?= esc_url($parent_permalink) ?>">
            <h3 class="item-title">Excursão <?= esc_html($clean_title) ?></h3>
        </a>

        <a href="<?= esc_url($remove_url) ?>" class="item-remove" aria-label="<?php esc_attr_e('Remover', 'woocommerce'); ?>" data-product_id="<?= esc_attr($product_id) ?>" data-cart_item_key="<?= esc_attr($cart_item_key) ?>">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </a>
    </div>

    <!-- Informações da Excursão -->
    <div class="cart-item-details">
        <div class="detail-row badges-row">
            <!-- Badge data do evento -->
            <?php if ($data_exc): ?>
                <span class="detail-badge"><svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> <span>Data do evento: <?= esc_html($data_exc) ?></span></span>
            <?php endif; ?>

            <!-- Badge de embarque no dia anterior -->
            <?php if (!empty($embarque_dia_anterior)): ?>
                <span class="detail-badge attention">
                    <i class="bi bi-moon-stars" style="line-height: 1.2;"></i>
                    <span>Embarque no dia anterior</span>
                </span>
            <?php endif; ?>
        </div>

        <div class="embarque-detail-area">
            <div class="icon">
                <!-- importar bus-stop.svg como ícone de local de embarque -->
                <?php $bus_stop_icon = file_get_contents(get_template_directory() . '/assets/icons/bus-stop.svg'); 
                
                // renderizar o ícone de local de embarque
                echo $bus_stop_icon;
                ?>
            </div>
            <div class="info">
                <?php $embarque = !empty($cart_item['embarque']) ? get_embarque_by_id($cart_item['embarque']) : ''; ?>
                <?php if (!empty($embarque)): ?>
                    <p class="emb-selecionado mb-1"><strong>Embarque escolhido:</strong> <span style="white-space: nowrap;"><?= esc_html($embarque) ?></span></p>
                    <p class="mb-0 data-horario"><span  style="white-space: nowrap;" class="pe-2"><strong>Data de embarque:</strong> <?php 

                    //se embarque_dia_anterior estiver definido, exibir a data de embarque como o dia anterior à data do evento
                    if (!empty($embarque_dia_anterior)) {
                        echo esc_html(date('d/m/Y', strtotime($data_iso . ' -1 day')));
                    } else {
                        echo esc_html($data_exc);
                    }
                    ?></span><span style="white-space: nowrap;"><strong>Horário:</strong> <?= esc_html($cart_item['horario']) ?></span></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Seção de Preço e Desconto -->
    <div class="cart-item-price-wrapper">
        <div class="price-display">
            <?php if ($_product->get_meta('preco_original') && $_product->get_meta('desconto_antecipado_rev') !== false): ?>
                <span class="price-old">R$ <?= esc_html($_product->get_meta('preco_original')) ?></span>
            <?php endif; ?>
            <span class="price-current"><?= WC()->cart->get_product_subtotal($_product, $cart_item['quantity']); ?></span>
        </div>
        
        <?php if (!empty($cart_item['desconto_antecipado']) && $_product->get_meta('desconto_antecipado_rev') === true): ?>
            <div class="discount-badge">
                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                5% OFF garantido até <?= esc_html(data_to_dmy($_product->get_meta('data_limite_desconto'))) ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Lista de Passageiros -->
    <?php if (!empty($passageiros)): ?>
        <div class="cart-passengers-accordion">
            <button type="button" class="accordion-toggle" data-qty="<?= count($passageiros) ?>">
                <span><svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> Passageiros (<?= count($passageiros) ?>)</span>
                <svg class="chevron" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            
            <div class="accordion-content">
                <?php foreach ($passageiros as $index => $passenger): ?>
                    <div class="passenger-card">
                        <div class="passenger-header">
                            <span class="passenger-number">#<?= $index + 1 ?></span>
                            <span class="passenger-name"><?= esc_html($passenger->nome_completo) ?></span>
                            <span class="passenger-route <?= $passenger->tripType === 'ida-e-volta' ? 'route-roundtrip' : 'route-oneway' ?>">
                                <?= strtoupper($passenger->tripType === 'ida-e-volta' ? 'Ida e volta' : 'Apenas ' . $passenger->tripType) ?>
                            </span>
                        </div>
                        <div class="passenger-data-grid">
                            <div class="data-item">
                                <small>CPF</small>
                                <span><?= esc_html($passenger->cpf) ?></span>
                            </div>
                            <div class="data-item">
                                <small>Celular</small>
                                <span><?= esc_html($passenger->celular) ?></span>
                            </div>
                            <div class="data-item">
                                <small>Nascimento</small>
                                <span><?= esc_html(data_to_dmy($passenger->data_nascimento)) ?></span>
                            </div>
                            <div class="d-flex justify-content-start align-items-center"><span class="passenger-route <?= $passenger->tripType === 'ida-e-volta' ? 'route-roundtrip' : 'route-oneway' ?>">
                                <?= strtoupper($passenger->tripType === 'ida-e-volta' ? 'Ida e volta' : 'Apenas ' . $passenger->tripType) ?>
                            </span></div>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
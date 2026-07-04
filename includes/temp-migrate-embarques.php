<?php

/**
 * Registra a página de migração no painel admin
 */
add_action('admin_menu', 'aerotour_registrar_pagina_migracao');
function aerotour_registrar_pagina_migracao() {
    add_submenu_page(
        null, // null faz com que a página fique invisível no menu lateral
        'Migração de Embarques',
        'Migração de Embarques',
        'manage_options',
        'aerotour-migracao-embarques',
        'aerotour_executar_migracao_embarques'
    );
}

/**
 * Função principal que processa os dados e exibe o relatório
 */
function aerotour_executar_migracao_embarques() {
    if (!current_user_can('manage_options')) {
        return;
    }

    echo '<div class="wrap">';
    echo '<h1>Relatório de Migração: Nova Arquitetura de Embarques</h1>';
    echo '<p>Verificando produtos variáveis a partir do ID 5740...</p>';
    echo '<table class="wp-list-table widefat fixed striped">';
    echo '<thead><tr><th>ID Pai</th><th>Nome da Excursão</th><th>Variações (Datas) Atualizadas</th><th>Status</th></tr></thead>';
    echo '<tbody>';

    // Busca apenas produtos variáveis com ID >= 5740
    $args = [
        'post_type'      => 'product',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'variable',
            ],
        ],
    ];

    $query = new WP_Query($args);
    $produtos_processados = 0;
    $variacoes_atualizadas = 0;

    if ($query->have_posts()) {
        foreach ($query->posts as $post) {
            $parent_id = $post->ID;

            // Bloqueio de segurança: Ignora IDs menores que 5740
            if ($parent_id < 5740) {
                continue;
            }

            // Verifica se o produto pai possui o meta antigo
            $old_meta = get_post_meta($parent_id, 'embarques', true);
            if (!$old_meta) {
                continue;
            }

            $old_data = json_decode($old_meta, true);
            if (!is_array($old_data)) {
                continue;
            }

            $product = wc_get_product($parent_id);
            $variations = $product->get_children();
            
            $datas_migradas_log = [];

            foreach ($variations as $var_id) {
                // REGRA 1: Pula se já tiver a nova meta _embarques_config
                $meta_existente = get_post_meta($var_id, '_embarques_config', true);
                if (!empty($meta_existente)) {
                    continue; 
                }

                $variation_obj = wc_get_product($var_id);
                
                // Obtém o atributo 'dia' da variação. O WooCommerce salva atributos prefixados com 'attribute_pa_' ou 'attribute_'.
                $dia_attr = $variation_obj->get_attribute('dia'); 
                
                // Fallback caso get_attribute não pegue diretamente a string mapeada
                if (empty($dia_attr)) {
                    $attributes = $variation_obj->get_attributes();
                    $dia_attr = isset($attributes['dia']) ? $attributes['dia'] : (isset($attributes['pa_dia']) ? $attributes['pa_dia'] : '');
                }

                $new_config = [];

                // Monta a nova arquitetura baseada no array antigo
                foreach ($old_data as $emb) {
                    if (!isset($emb['embarqueId'])) continue;

                    $novo_embarque = [
                        'embarque_id' => (int) $emb['embarqueId'],
                        'taxa'        => isset($emb['taxa']) ? (float) $emb['taxa'] : 0,
                        'horarios'    => []
                    ];

                    if (isset($emb['horarios']) && is_array($emb['horarios'])) {
                        foreach ($emb['horarios'] as $h) {
                            $is_disponivel = false;

                            // Verifica a disponibilidade cruzando a data da variação com o 'disp_dia'
                            if (isset($h['disponibilidade']) && is_array($h['disponibilidade'])) {
                                foreach ($h['disponibilidade'] as $disp) {
                                    if ($disp['disp_dia'] === $dia_attr && $disp['status'] === 'disponivel') {
                                        $is_disponivel = true;
                                        break;
                                    }
                                }
                            }

                            $novo_embarque['horarios'][] = [
                                'horario'    => $h['horario'],
                                'disponivel' => $is_disponivel
                            ];
                        }
                    }

                    $new_config[] = $novo_embarque;
                }

                // Salva o novo objeto no meta da variação
                if (!empty($new_config)) {
                    update_post_meta($var_id, '_embarques_config', wp_slash(json_encode($new_config, JSON_UNESCAPED_UNICODE)));
                    $datas_migradas_log[] = $dia_attr . ' (Var: ' . $var_id . ')';
                    $variacoes_atualizadas++;
                }
            }

            if (!empty($datas_migradas_log)) {
                $produtos_processados++;
                echo '<tr>';
                echo '<td>' . esc_html($parent_id) . '</td>';
                echo '<td><strong>' . esc_html($product->get_name()) . '</strong></td>';
                echo '<td>' . implode('<br>', $datas_migradas_log) . '</td>';
                echo '<td><span style="color: green; font-weight: bold;">Migrado</span></td>';
                echo '</tr>';
            }
        }
    }

    if ($produtos_processados === 0) {
        echo '<tr><td colspan="4">Nenhuma nova variação precisava de migração (ou os produtos não se enquadram na regra ID >= 5740).</td></tr>';
    }

    echo '</tbody></table>';
    
    echo '<h2>Resumo</h2>';
    echo '<p><strong>Excursões processadas:</strong> ' . $produtos_processados . '</p>';
    echo '<p><strong>Variações/Datas atualizadas:</strong> ' . $variacoes_atualizadas . '</p>';
    echo '</div>';
}
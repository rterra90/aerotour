<?php
// Registra e enfileira o React (preferencialmente local para evitar DNS lookup externo)
wp_enqueue_script('react', 'https://unpkg.com/react@18/umd/react.production.min.js', [], '18', true);
wp_enqueue_script('react-dom', 'https://unpkg.com/react-dom@18/umd/react-dom.production.min.js', ['react'], '18', true);

// // //
// FUNÇÕES DA PÁGINA SINGLE-PRODUCT
//Scripts gerais, como react, json-LD, e js da página
require_once get_template_directory() .
    '/includes/woocommerce/single-product-functions.php';

//Lógicas que lidam com as informações das excursões (embarques, datas, disponibilidade...)
require_once get_template_directory() .
    '/includes/classes/helper-single-product.php';

//Funções que renderizam as seções da página single-product
require_once get_template_directory() .
    '/includes/classes/render-components-single-product.php';


// // //
// FUNÇÕES DA PÁGINA ARCHIVE-PRODUCT
require_once get_template_directory() .
    '/includes/woocommerce/archive-product-functions.php';



// // //
// FUNÇÕES DA PÁGINA CHECKOUT
require_once get_template_directory() .
    '/includes/woocommerce/checkout-functions.php';

// // //
// FUNÇÕES DE PEDIDOS
//Função que formata os metadados por item de um pedido
add_filter(
    'woocommerce_order_item_get_formatted_meta_data',
    'customizar_exibicao_metadados_order',
    10,
    2,
);

// Insere alerta de login ou cadastro ao ser redirecionado após tentativa de checkout
add_action('woocommerce_after_title_my_account', function () {
    if (isset($_GET['redirect'])) {
        $redirect_url = urldecode($_GET['redirect']);
        $checkout_url = wc_get_checkout_url();

        // Se a URL de redirecionamento for a do checkout, exibe a mensagem
        if (strpos($redirect_url, $checkout_url) !== false) {
            echo '<div class="woocommerce-info redirect_alert mb-3" style="list-style:none;">';
            echo 'Identifique-se ou cadastre-se para finalizar seu pedido.';
            echo '</div>';
        }
    }
});

function customizar_exibicao_metadados_order($formatted_meta, $item)
{
    global $wpdb;
    foreach ($formatted_meta as $key => $meta) {
        // 1. Tratamento para o campo de Passageiros (JSON string)
        if (strtolower($meta->key) === 'passageiros') {
            $passageiros_raw = $meta->value;

            // Decodifica o JSON para array associativa do PHP
            $passageiros = json_decode(wp_unslash($passageiros_raw), true);

            if (is_array($passageiros) && !empty($passageiros)) {
                $html_output =
                    '<ul class="order-item-pax-list" style="list-style: none; padding-left: 0; margin-top: 5px;">';

                foreach ($passageiros as $index => $p) {
                    $num = $index + 1;
                    $nome = esc_html(
                        $p['nome_completo'] ?? ($p['nome'] ?? 'Não informado'),
                    );
                    $cpf = esc_html($p['cpf'] ?? 'Não informado');
                    $tel = esc_html($p['celular'] ?? 'Não informado');
                    $nasc = isset($p['data_nascimento'])
                        ? esc_html(data_to_dmy($p['data_nascimento']))
                        : '';

                    $html_output .=
                        "<li class='order-item-single-pax' style='margin-bottom: 8px; flex-direction:column'>";
                    $html_output .= "<strong>{$nome}</strong> ";
                    $html_output .= "<div><small style='color: #666;'>CPF: {$cpf}  | </small>";
                    $html_output .= "<small style='color: #666;'>Tel: {$tel} | </small>";
                    if ($nasc) {
                        $html_output .= "<small style='color: #666;'>Nasc: {$nasc}</small></div>";
                    }
                    $html_output .= '</li>';
                }

                $html_output .= '</ul>';

                // Substitui o valor bruto pelo HTML estruturado e altera a label para ficar amigável
                $formatted_meta[$key]->display_key = 'Passageiros';
                $formatted_meta[$key]->display_value = $html_output;
            }
        }

        // 2. Tratamento para o campo de Embarque (ID para Nome na tabela customizada)
        if ($meta->key === 'Embarque') {
            $embarque_id = absint($meta->value);

            if ($embarque_id > 0) {
                // Faz a consulta na sua tabela personalizada de embarques
                // Ajuste o nome da tabela ('wp_aerotour_embarques' ou similar) e da coluna conforme sua estrutura
                $tabela_embarques = $wpdb->prefix . 'embarques';

                $nome_embarque = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT nome FROM {$tabela_embarques} WHERE id = %d",
                        $embarque_id,
                    ),
                );

                if ($nome_embarque) {
                    // Substitui o ID numérico pelo nome real do ponto de embarque
                    $formatted_meta[$key]->display_key = 'Local de Embarque';
                    $formatted_meta[$key]->display_value = esc_html(
                        $nome_embarque,
                    );
                }
            }
        }
    }

    return $formatted_meta;
}

//Função que renderiza o Timer de Validade do Pedido Pendente
add_action('woocommerce_before_thankyou_box', 'render_order_countdown', 10);
add_action('woocommerce_view_order_start', 'render_order_countdown', 5);

function render_order_countdown($order_id)
{
    $order = wc_get_order($order_id);

    // Interrompe se não exister order ou se não estiver pendente de pagamento
    if (!$order || !$order->has_status(['pending', 'on-hold'])) {
        return;
    }

    // Tempo total permitido: 30 minutos em segundos
    $tempo_limite_segundos = 30 * 60;

    // Obtém o timestamp de criação do pedido em UTC/GMT para evitar problemas de fuso local
    $horario_pedido = $order->get_date_created()->getTimestamp();
    $horario_atual = current_time('timestamp', true); // UTC timestamp nativo do WP

    // Calcula os segundos passados e o que ainda resta
    $segundos_passados = $horario_atual - $horario_pedido;
    $segundos_restantes = $tempo_limite_segundos - $segundos_passados;

    // Se o tempo já esgotou no backend, não renderiza o timer (ou renderiza zerado)
    if ($segundos_restantes <= 0) {

        // Altera o status e adiciona uma nota explicativa na timeline do pedido
        $order->update_status(
            'cancelled',
            __(
                'Pedido cancelado automaticamente: Tempo limite de 30 minutos para pagamento esgotado.',
                'aerotour',
            ),
        );

        echo '<div class="alert alert-danger text-center fw-bold mb-4 py-2">O tempo de pagamento para este pedido expirou.</div>';
        ?>
            <script>
                window.addEventListener('load', () => {

                    const isPageOrder = document.querySelector('.order-summary-text');
                    if(isPageOrder){
                        const text = document.querySelector('.order-summary-text');
                        const badge = document.querySelector('mark.order-status');
                        const actions = document.querySelector('.pending-order-buttons');
                        if(text) text.dataset.status = 'cancelled';
                        if(badge) badge.innerText = 'CANCELADO';
                        if (actions) actions.remove();
                    }

                    const isPageThankYou = document.querySelector('#page-thankyou');
                    if(isPageThankYou){
                        const thankyouBox = document.querySelector('#thankyou-box');
                        const p_prazo = document.querySelector('#thankyou-box p.pedido-prazo-aviso');
                        const progress_1 = document.querySelector('.progress.step-1 > div');
                        const progress_2 = document.querySelector('.progress.step-2 > div');
                        const alerta_refresh = document.querySelector('p.alerta-refresh-header');
                        const mp_pix_container = document.querySelector('div.mp-details-pix');

                        p_prazo.innerText = "Será necessário fazer um novo pedido para garantir sua reserva."
                        progress_1.className = 'progress-bar step-1 cancelled';
                        progress_2.className = 'progress-bar step-2 animate-2 cancelled';
                        progress_2.style.animationDelay = '1s';
                        if(alerta_refresh) alerta_refresh.remove();
                        if(mp_pix_container) mp_pix_container.remove();
                    }
                })
            </script>
        <?php return;
    }
    // Renderiza a estrutura HTML com os atributos lidos pelo JavaScript
    ?>
    <div class="alert alert-warning d-flex align-items-center gap-3 mb-3 mb-md-4 p-2 pe-3 shadow-sm rounded border-start border-warning" 
         id="order-countdown-timer" 
         data-order-id="<?php echo $order_id; ?>" 
         data-seconds-left="<?php echo esc_attr($segundos_restantes); ?>">
        
        <div class="spinner-grow text-warning spinner-grow-sm" role="status"></div>
        
        <div class="text-start">
            <span class="count-down-text d-block text-muted small text-uppercase fw-semibold tracking-wider" style="font-size: 0.75rem;">Sua vaga está reservada por:</span>
            <span class="countdown-clock fw-bold text-dark font-monospace m-0" style="font-size:1.4rem" id="countdown-clock-digits">--:--</span>
        </div>
    </div>
    <?php
}

//ADICIONAR SUPORTE WOOCOMMERCE
function theme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}
add_action('after_setup_theme', 'theme_add_woocommerce_support');

/**
 * Remove todos os estilos padrão do WooCommerce
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Remove o script de checkout do WooCommerce (que inclui o bloco de pagamento)
add_action(
    'wp_enqueue_scripts',
    function () {
        wp_dequeue_script('wc-checkout');
        if (is_checkout()) {
            wp_dequeue_script('wc-cart-fragments');
        }
    },
    100,
);

// Registrar endpoint para "Minhas reservas"
add_action('init', 'add_endpoints');
function add_endpoints()
{
    add_rewrite_endpoint('minhas-reservas', EP_PAGES);
}
add_action(
    'woocommerce_account_minhas-reservas_endpoint',
    'minhas_reservas_endpoint_page_create',
);
function minhas_reservas_endpoint_page_create()
{
    wc_get_template('myaccount/minhas-reservas.php');
}

// Modifica os itens do menu da conta do usuário
add_action('woocommerce_account_menu_items', 'custom_account_menu');
function custom_account_menu($menu_links)
{
    unset($menu_links['downloads']);
    unset($menu_links['customer-logout']);
    // $menu_links['customer-logout'] = 'Sair';
    $menu_links =
        array_slice($menu_links, 0, 5, true) + [
            'minhas-reservas' => 'Minhas reservas',
        ] +
        array_slice($menu_links, 5, null, true);
    return $menu_links;
}

// Otimiza a query de produtos para exibir apenas excursões ativas (com data limite >= hoje) em arquivos de loja, categoria e tag
add_action('pre_get_posts', 'otimizar_query_produtos_excursao');
function otimizar_query_produtos_excursao($query)
{
    // 1. Saída antecipada (Early Return) para evitar processamento desnecessário
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    // 2. Agrupa as verificações de página
    if (is_shop() || is_product_category() || is_product_tag()) {
        // Define a data atual uma única vez
        $hoje = date('Ymd');

        // Configurações da Query
        $query->set('posts_per_page', -1); // Nota: Cuidado se tiver +100 produtos
        $query->set('meta_key', 'data_limite_excursao');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');

        // 3. Otimização da Meta Query
        $meta_query = (array) $query->get('meta_query');
        $meta_query[] = [
            'key' => 'data_limite_excursao',
            'value' => $hoje,
            'compare' => '>=',
            'type' => 'NUMERIC',
        ];

        $query->set('meta_query', $meta_query);
    }
}

// Ponto de venda em cart_collaterals
add_action('woocommerce_review_order_before_payment', 'exibe_pdv');
function exibe_pdv()
{
    ?>
  <div class="cart_collaterals_pdv">
    <p>Ponto de venda: <span></span></p>
    <input type="hidden" name="pdv">
    <script>
      if (window.sessionStorage.getItem('aer_pdv')) {
        document.querySelector('input[name="pdv"]').value = window.sessionStorage.getItem('aer_pdv');
        document.querySelector('.cart_collaterals_pdv span').innerText = window.sessionStorage.getItem('aer_pdv').replace(/\_/g, ' ');
      } else document.querySelector('.cart_collaterals_pdv').remove();
    </script>
  </div>

<?php
}

// Remove breadcrumb do WooCommerce em arquivos de loja, categoria e tag
function remover_breadcrumb_em_arquivos_woocommerce()
{
    if (is_product_category() || is_shop() || is_product_tag()) {
        remove_action(
            'woocommerce_before_main_content',
            'woocommerce_breadcrumb',
            20,
        );
    }
}
add_action('wp', 'remover_breadcrumb_em_arquivos_woocommerce');

//Remove a exibição de cross-sell do cart
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');

function filter_woocommerce_cart_totals_coupon_html(
    $coupon_html,
    $coupon,
    $discount_amount_html,
) {
    // Change text
    $coupon_html =
        $discount_amount_html .
        ' <a href="' .
        esc_url(
            add_query_arg(
                'remove_coupon',
                rawurlencode($coupon->get_code()),
                defined('WOOCOMMERCE_CHECKOUT')
                    ? wc_get_checkout_url()
                    : wc_get_cart_url(),
            ),
        ) .
        '" class="woocommerce-remove-coupon" data-coupon="' .
        esc_attr($coupon->get_code()) .
        '">' .
        __('<i class="bi bi-trash"></i>', 'woocommerce') .
        '</a>';

    return $coupon_html;
}
add_filter(
    'woocommerce_cart_totals_coupon_html',
    'filter_woocommerce_cart_totals_coupon_html',
    10,
    3,
);

// Adicionar o filtro ao texto de "obrigado pelo pedido"
add_filter(
    'woocommerce_thankyou_order_received_text',
    'customizar_texto_obrigado',
    10,
    2,
);
function customizar_texto_obrigado($texto, $pedido)
{
    $novo_texto = 'Confira os detalhes do pedido'; // Substitua pelo texto desejado
    return $novo_texto;
}
add_filter('woocommerce_price_format', function () {
    return '%1$s%2$s';
});

/**
 * Registra as taxonomias customizadas 'Gênero Musical' e 'Local do Evento' para os Produtos.
 *
 * @return void
 */
function theme_register_taxonomies() {
    
    // 1. Taxonomia: Gênero Musical
    $labels_genre = array(
        'name'                       => _x( 'Gêneros Musicais', 'taxonomy general name', 'aerotour' ),
        'singular_name'              => _x( 'Gênero Musical', 'taxonomy singular name', 'aerotour' ),
        'search_items'               => __( 'Buscar Gêneros', 'aerotour' ),
        'popular_items'              => __( 'Gêneros Populares', 'aerotour' ),
        'all_items'                  => __( 'Todos os Gêneros', 'aerotour' ),
        'edit_item'                  => __( 'Editar Gênero', 'aerotour' ),
        'update_item'                => __( 'Atualizar Gênero', 'aerotour' ),
        'add_new_item'               => __( 'Adicionar Novo Gênero', 'aerotour' ),
        'new_item_name'              => __( 'Novo Nome de Gênero', 'aerotour' ),
        'separate_items_with_commas' => __( 'Separe os gêneros por vírgula', 'aerotour' ),
        'add_or_remove_items'        => __( 'Adicionar ou remover gêneros', 'aerotour' ),
        'choose_from_most_used'      => __( 'Escolher entre os gêneros mais usados', 'aerotour' ),
        'menu_name'                  => __( 'Gêneros Musicais', 'aerotour' ),
    );

    $args_genre = array(
        'hierarchical'          => false, // Comportamento estilo 'Tags'
        'labels'                => $labels_genre,
        'show_ui'               => true,
        'show_in_rest'          => true,  // Exibe na REST API e no editor Gutenberg
        'show_admin_column'     => true,  // Adiciona coluna na listagem de produtos do admin
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'genero-musical' ),
    );

    register_taxonomy( 'exc_genre', array( 'product' ), $args_genre );

    // 2. Taxonomia: Local / Venue (Ex: Allianz Parque, Sambódromo, etc.)
    $labels_venue = array(
        'name'                       => _x( 'Locais do Evento', 'taxonomy general name', 'aerotour' ),
        'singular_name'              => _x( 'Local do Evento', 'taxonomy singular name', 'aerotour' ),
        'search_items'               => __( 'Buscar Locais', 'aerotour' ),
        'all_items'                  => __( 'Todos os Locais', 'aerotour' ),
        'edit_item'                  => __( 'Editar Local', 'aerotour' ),
        'update_item'                => __( 'Atualizar Local', 'aerotour' ),
        'add_new_item'               => __( 'Adicionar Novo Local', 'aerotour' ),
        'new_item_name'              => __( 'Novo Nome de Local', 'aerotour' ),
        'menu_name'                  => __( 'Locais / Venues', 'aerotour' ),
    );

    $args_venue = array(
        'hierarchical'          => false,
        'labels'                => $labels_venue,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'local-evento' ),
    );

    register_taxonomy( 'exc_venue', array( 'product' ), $args_venue );
}
add_action( 'init', 'theme_register_taxonomies', 0 );


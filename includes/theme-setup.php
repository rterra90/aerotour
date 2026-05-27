<?php

/**
 *
 * Criação das tabelas personalizadas do tema
 */
function create_theme_tables()
{
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    global $wpdb;

    $tables = ['reservas', 'reserva_leads', 'embarques', 'cancelamentos'];
    $charset_collate = $wpdb->get_charset_collate();

    foreach ($tables as $table) {
        $table_name = $wpdb->prefix . $table;

        switch ($table) {
            case 'reservas':
                $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                user_id int DEFAULT NULL,
                order_user_id int(11) DEFAULT NULL,
                variation_id int(11),
                order_id int(11) DEFAULT NULL,
                status varchar(20) DEFAULT 'normal',
                p_nome varchar(255) DEFAULT '',
                p_cpf varchar(255) DEFAULT '',
                p_telefone varchar(255) DEFAULT '',
                embarque varchar(255) DEFAULT '',
                horario time DEFAULT NULL,
                saida tinyint(1) DEFAULT 0,
                volta tinyint(1) DEFAULT 0,
                data_nasc date DEFAULT NULL,
                rota enum('1','2','3') DEFAULT '1',
                PRIMARY KEY  (id)
            ) $charset_collate;";
                break;
            case 'reserva_leads':
                $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                variation_id varchar(255) NOT NULL,
                order_id bigint(20) DEFAULT NULL, 
                embarque varchar(255) DEFAULT '',
                passenger_name varchar(255) DEFAULT '',
                passenger_cpf varchar(20) DEFAULT '',
                passenger_phone varchar(20) DEFAULT '',
                session_id varchar(100) DEFAULT '',
                status varchar(20) DEFAULT 'pendente',
                created_at datetime DEFAULT CURRENT_TIMESTAMP,
                updated_at datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY  (id),
                UNIQUE KEY session_pax (session_id, passenger_cpf)
            ) $charset_collate;";
                break;
            case 'embarques':
                $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                nome varchar(255) NOT NULL,
                endereco bigint(20) DEFAULT NULL, 
                obs varchar(255) DEFAULT '',
                link_mapa varchar(255) DEFAULT '',
                PRIMARY KEY  (id)
            ) $charset_collate;";
                break;
            case 'cancelamentos':
                $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                order_id bigint(20) DEFAULT NULL,
                user_id bigint(20) DEFAULT NULL,
                variation_id bigint(20) DEFAULT NULL,
                passageiros text,
                data_solic datetime DEFAULT CURRENT_TIMESTAMP,
                taxa bigint(20) DEFAULT NULL,
                status varchar(20) DEFAULT '',
                PRIMARY KEY  (id)
            ) $charset_collate;";
                break;
        }

        // Executa ação no banco de dados
        dbDelta($sql);
    }
}

// add_action('admin_init', 'create_theme_tables');

// Executa APENAS quando o tema da Aerotour for ativado
add_action('after_switch_theme', 'create_theme_tables');

/**
 * Registrar os plugins obrigatórios e recomendados para o tema Aerotour
 * utilizando a biblioteca TGM Plugin Activation.
 */
// Inclui a classe TGM
require_once get_template_directory() .
    '/includes/class-tgm-plugin-activation.php';
function registrar_plugins_obrigatorios()
{
    // Lista de plugins do repositório oficial do WordPress
    $plugins = [
        // 1. WooCommerce (Obrigatório)
        [
            'name' => 'WooCommerce',
            'slug' => 'woocommerce',
            'required' => true,
        ],
        // 2. Mercado Pago para WooCommerce (Obrigatório)
        [
            'name' => 'Mercado Pago para WooCommerce',
            'slug' => 'woocommerce-mercadopago',
            'required' => true,
        ],
        // 3. Editor Clássico (Recomendado)
        [
            'name' => 'Editor Clássico',
            'slug' => 'classic-editor',
            'required' => false,
        ],
        // 4. LiteSpeed Cache (Recomendado)
        [
            'name' => 'LiteSpeed Cache',
            'slug' => 'litespeed-cache',
            'required' => false,
        ],
        // 5. Preview E-mails for WooCommerce (Recomendado)
        [
            'name' => 'Preview E-mails for WooCommerce',
            'slug' => 'woo-preview-emails',
            'required' => false,
        ],
        // 6. Regenerate Thumbnails (Recomendado)
        [
            'name' => 'Regenerate Thumbnails',
            'slug' => 'regenerate-thumbnails',
            'required' => false,
        ],
        // 7. WP Mail SMTP (Recomendado)
        [
            'name' => 'WP Mail SMTP',
            'slug' => 'wp-mail-smtp',
            'required' => false,
        ],
        // 8. WPS Hide Login (Recomendado)
        [
            'name' => 'WPS Hide Login',
            'slug' => 'wps-hide-login',
            'required' => false,
        ],
        // 9. Yoast SEO (Recomendado)
        [
            'name' => 'Yoast SEO',
            'slug' => 'wordpress-seo',
            'required' => false,
        ],
    ];

    // Configurações de exibição do painel TGM
    $config = [
        'id' => 'aerotour-tgmpa', // Identificador único
        'default_path' => '', // Caminho padrão para plugins locais (não usado aqui)
        'menu' => 'tgmpa-install-plugins', // Slug do menu de instalação
        'has_notices' => true, // Exibe avisos administrativos
        'dismissable' => true, // Permite fechar o aviso se os obrigatórios estiverem ativos
        'dismiss_msg' => '',
        'is_automatic' => true, // Ativa automaticamente os plugins após a instalação (se o usuário quiser)
        'message' => '',
    ];

    tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'registrar_plugins_obrigatorios');

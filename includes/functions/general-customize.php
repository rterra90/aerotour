<?php

//ADICIONA CAMPO PARA UPLOAD DE LOGOTIPO NO CUSTOMIZER
function theme_customizer($wp_customize)
{
    // Adiciona o Campo de Upload para o logo principal
    $wp_customize->add_setting('theme_header_logo', [
        'default' => '',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control(
        new WP_Customize_Image_Control($wp_customize, 'theme_header_logo', [
            'label' => 'Upload do Logotipo',
            'section' => 'title_tagline',
            'settings' => 'theme_header_logo',
        ]),
    );

    // // // // // // // // //
    // // CABEÇALHO
    //
    // 1. Adiciona a Seção "Cabeçalho"
    $wp_customize->add_section('theme_header_section', [
        'title' => __('Cabeçalho', 'theme_textdomain'),
        'priority' => 30,
    ]);
    // 2. Adiciona a configuração (o dado no banco)
    $wp_customize->add_setting('theme_header_type', [
        'default' => 'header-static',
        'transport' => 'refresh', // 'refresh' atualiza a página para aplicar
    ]);
    // 3. Adiciona o controle (o campo visual no painel)
    $wp_customize->add_control('theme_header_type_control', [
        'label' => __('Tipo de Cabeçalho', 'theme_textdomain'),
        'section' => 'theme_header_section',
        'settings' => 'theme_header_type',
        'type' => 'select',
        'choices' => [
            'header-fixed' => 'Fixo (Sticky)',
            'header-static' => 'Estático (Normal)',
        ],
    ]);

    // Habilitar/Desabilitar Top-header
    $wp_customize->add_setting('theme_show_top_header', [
        'default' => true,
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('theme_show_top_header_control', [
        'label' => __('Exibir Barra Superior (Top-header)', 'theme_textdomain'),
        'section' => 'theme_header_section',
        'settings' => 'theme_show_top_header',
        'type' => 'checkbox',
    ]);

    // Texto da Top-header ---
    $wp_customize->add_setting('theme_top_header_text', [
        'default' => 'Seja bem vindo ao nosso site!',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('theme_top_header_text_control', [
        'label' => __('Texto da Barra Superior', 'theme_textdomain'),
        'description' => __(
            'Frase que aparece acima do menu principal.',
            'theme_textdomain',
        ),
        'section' => 'theme_header_section',
        'settings' => 'theme_top_header_text',
        'type' => 'text',
    ]);

    // Estilo do Menu (Dropdown vs Offcanvas) ---
    $wp_customize->add_setting('theme_menu_style', [
        'default' => 'menu-dropdown',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('theme_menu_style_control', [
        'label' => __('Estilo do Menu Mobile/Moderno', 'theme_textdomain'),
        'section' => 'theme_header_section',
        'settings' => 'theme_menu_style',
        'type' => 'select',
        'choices' => [
            'menu-dropdown' => 'Dropdown (Abaixo do Header)',
            'menu-offcanvas' => 'Offcanvas (Lateral)',
        ],
    ]);
}

add_action('customize_register', 'theme_customizer');

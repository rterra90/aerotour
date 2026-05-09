<?php

require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/helper-theme-settings.php'; // Funções utilitárias do painel de configurações
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/settings-page-header.php'; // Cabeçalho das configurações com submenu
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/dashboard-settings-page.php'; // DASHBOARD das configurações do tema
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/excursao-settings-page.php'; // SUB "Página da excursão"
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/excursao-como-funciona-settings-page.php'; // SUB "Página da excursão > Como Funciona"
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/excursao-faq-settings-page.php'; // SUB "Página da excursão > FAQ"
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/contato-settings-page.php'; // SUB "Contato"
require_once get_template_directory() .
  '/includes/admin-pages/theme-settings/integracoes-settings-page.php'; // SUB "Integrações"

/**
 * Cria o menu e submenus de configuração do tema
 */
add_action('admin_menu', function () {
  // Menu Principal
  add_menu_page(
    'Configurações do Tema',
    'Configurações do Tema',
    'manage_options',
    'tema-geral-settings', // slug
    'render_admin_dashboard_page', // Função que desenha a página inicial
    'dashicons-admin-appearance',
    30
  );

  // Submenu: Integrações
  add_submenu_page(
    'tema-geral-settings', // slug do menu pai
    'Integrações com ferramentas',
    'Integrações',
    'manage_options',
    'config-integracoes', // slug
    'render_integrations_settings_page'
  );

  // Submenu: Contato
  add_submenu_page(
    'tema-geral-settings', // slug do menu pai
    'Configurações de contato',
    'Contato',
    'manage_options',
    'config-contato', // slug
    'render_contato_settings_page'
  );

  // Submenu: Página da Excursão
  add_submenu_page(
    'tema-geral-settings', // slug do menu pai
    'Configurações da Página de Excursão',
    'Página da Excursão',
    'manage_options',
    'config-excursao', // slug
    'render_excursao_settings_page'
  );

  // Submenu: Página da excursao > Como Funciona
  add_submenu_page(
    'tema-geral-settings',
    'Seção Como Funciona',
    '— Como Funciona',
    'manage_options',
    'config-excursao-como-funciona',
    'render_excursao_como_funciona_settings_page'
  );

  // Submenu: Página da excursao > Principais dúvidas (FAQ)
  add_submenu_page(
    'tema-geral-settings',
    'Seção FAQ',
    '— FAQ',
    'manage_options',
    'config-excursao-faq',
    'render_excursao_faq_settings_page'
  );
});

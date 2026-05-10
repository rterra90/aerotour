<?php

function create_leads_table()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'reserva_leads';
  $charset_collate = $wpdb->get_charset_collate();

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

  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
}
// Executar uma vez ou em hooks de ativação
add_action('admin_init', 'create_leads_table');

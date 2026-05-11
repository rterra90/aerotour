<?php

add_action('admin_menu', function () {
  add_menu_page(
    'Leads de Reservas',
    'Leads Aerotour',
    'manage_options',
    'leads-reservas',
    'render_leads_page',
    'dashicons-id-alt',
    '25'
  );
});

function render_leads_page()
{
  global $wpdb;
  $table_name = $wpdb->prefix . 'reserva_leads';
  $embarques_table = $wpdb->prefix . 'embarques';

  // --- 1. LÓGICA DE PROCESSAMENTO (Exclusão) ---
  $message = '';

  // Ação de excluir (individual ou lote)
  if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'delete') {
    check_admin_referer('bulk-leads'); // Segurança

    $ids_to_delete = [];
    if (isset($_REQUEST['lead'])) {
      $ids_to_delete = is_array($_REQUEST['lead']) ? $_REQUEST['lead'] : [$_REQUEST['lead']];
    }

    if (!empty($ids_to_delete)) {
      foreach ($ids_to_delete as $id) {
        $wpdb->delete($table_name, ['id' => intval($id)]);
      }
      $message = '<div class="updated notice is-dismissible"><p>' . count($ids_to_delete) . ' lead(s) excluídos com sucesso.</p></div>';
    }
  }

  // --- 2. FILTROS E BUSCA ---
  $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
  $query = "SELECT * FROM $table_name";

  if (!empty($search)) {
    $query .= $wpdb->prepare(" WHERE passenger_name LIKE %s OR passenger_cpf LIKE %s", "%$search%", "%$search%");
  }

  $query .= " ORDER BY created_at DESC";
  $leads = $wpdb->get_results($query);

  // --- 3. RENDERIZAÇÃO DA PÁGINA ---
  echo '<div class="wrap"><h1>Leads de Reservas Abandonadas</h1>';
  echo $message; // Exibe feedback de exclusão

?>
  <form method="get" style="margin-bottom: 20px; display: flex; justify-content: flex-end;">
    <input type="hidden" name="page" value="leads-reservas">
    <p class="search-box">
      <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="Nome ou CPF...">
      <input type="submit" class="button" value="Filtrar">
    </p>
  </form>

  <form method="post">
    <?php wp_nonce_field('bulk-leads'); ?>

    <div class="tablenav top">
      <div class="alignleft actions bulkactions">
        <select name="action">
          <option value="-1">Ações em lote</option>
          <option value="delete">Excluir permanentemente</option>
        </select>
        <input type="submit" class="button action" value="Aplicar">
      </div>
    </div>

    <table class="wp-list-table widefat fixed striped">
      <thead>
        <tr>
          <td id="cb" class="manage-column column-cb check-column">
            <input id="cb-select-all-1" type="checkbox">
          </td>
          <th style="width: 8%">Data/Hora</th>
          <th>Passageiro</th>
          <th style="width: 15%">Contato / CPF</th>
          <th>Excursão</th>
          <th>Embarque</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($leads): foreach ($leads as $lead):
            $variation_ids = json_decode($lead->variation_id, true);
            $tour_info = 'N/A';
            $permalink = '#';

            if (!empty($variation_ids) && is_array($variation_ids)) {
              // Pegamos a primeira variação para descobrir o Produto Pai (Excursão)
              $parent_id = wp_get_post_parent_id($variation_ids[0]);

              // obtém a quantidade de variações do produto pai
              $variations_count = count(wc_get_product($parent_id)->get_children());

              if ($parent_id) {
                $product = wc_get_product($parent_id);
                $tour_info = '<strong>' . $product->get_name() . '</strong>';
                $permalink = get_permalink($parent_id);

                // Opcional: Listar os nomes das variações (ex: "Adulto", "Criança")
                $v_names = array();
                foreach ($variation_ids as $v_id) {
                  $v_obj = wc_get_product($v_id);
                  if ($v_obj) $v_names[] = substr($v_obj->get_attribute_summary(), 5);
                }
                if ($variations_count > 1) $tour_info .= '<br/><small>' . implode(', ', $v_names) . '</small>';
              }
            }
            $whatsapp_url = "https://wa.me/55" . preg_replace('/[^0-9]/', '', $lead->passenger_phone);
            $nome_embarque = "ID: " . $lead->embarque;
            if (!empty($lead->embarque)) {
              $res = $wpdb->get_var($wpdb->prepare("SELECT nome FROM $embarques_table WHERE id = %d", $lead->embarque));
              if ($res) $nome_embarque = "<span style='display:block'>" . explode(" - ", $res)[0] . "</span>
                                          <span style='display:block'>" . explode(" - ", $res)[1] . "</span>";
            }
        ?>
            <tr>
              <th scope="row" class="check-column">
                <input type="checkbox" name="lead[]" value="<?php echo $lead->id; ?>">
              </th>
              <td><?php echo date('d/m/Y H:i', strtotime($lead->created_at)); ?></td>
              <td><strong><?php echo esc_html($lead->passenger_name); ?></strong></td>
              <td>
                <?php echo esc_html($lead->passenger_phone); ?><br />
                <small>CPF: <?php echo esc_html($lead->passenger_cpf); ?></small>
              </td>
              <td>
                <a href="<?php echo $permalink; ?>" target="_blank"> <?php echo $tour_info; ?></a>
              </td>
              <td><?php echo $nome_embarque; ?></td>
              <td>
                <a href="<?= $whatsapp_url ?>" target='_blank' class='button button-primary'>
                  <span class='dashicons dashicons-whatsapp' style='margin-top: 4px;'></span>
                </a>
                <a href="<?php echo wp_nonce_url("?page=leads-reservas&action=delete&lead=" . $lead->id, 'bulk-leads'); ?>"
                  class="button button-link-delete"
                  style="border-color:#a76869"
                  onclick="return confirm('Deseja excluir este lead?')">
                  <span class="dashicons dashicons-trash" style="margin-top:4px"></span>
                </a>
              </td>
            </tr>
          <?php endforeach;
        else: ?>
          <tr>
            <td colspan="7">Nenhum lead encontrado.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </form>
  </div>

  <script>
    jQuery(document).ready(function($) {
      $('#cb-select-all-1').click(function() {
        $('tbody input[type="checkbox"]').prop('checked', this.checked);
      });
    });
  </script>
<?php
}

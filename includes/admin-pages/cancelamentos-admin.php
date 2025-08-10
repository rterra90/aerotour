<?php
function cancelamentos_admin_page(){
  global $wpdb;
  $cancelamentos_db = $wpdb->get_results("SELECT * FROM aer_cancelamentos");


  ?>
  <section id="admin-cancelamentos">
  <h1>Cancelamentos</h1>
  <button>limpar</button>

  <div id="cancelamentos-wrapper">
    <ul>
      <?php
      if(sizeof($cancelamentos_db) > 0){
        foreach($cancelamentos_db as $cancelamento){
            $evento_cancel = wc_get_product($cancelamento->variation_id);
            $order_cancel = wc_get_order($cancelamento->order_id);
            $nome_pax_cancelamento = json_decode($order_cancel->get_meta('passageiro')) -> nome_completo;
          ?>
            <li data-order-id="<?= $cancelamento->order_id; ?>" data-variation-id="<?= $cancelamento->variation_id; ?>">
                <span><?= $nome_pax_cancelamento; ?></span>
                <span><?= $evento_cancel -> get_title(); ?></span>
                <span><?= $cancelamento->data_solic; ?></span>
                <span><?= $cancelamento->taxa; ?></span>
                <span><?= preco_item_cancel($cancelamento->order_id, $cancelamento->variation_id); ?></span>
                <span class="file-wrapper">
                    <label>Anexar comprovante</label> <input type="file" name="file" style="padding: 0"/>
                    
                </span>
                <span>Finalizar</span>
            </li>
          <?php
        }
      }else{
        echo '<p>Nenhum cancelamento por enquanto...</p>';
      }
        
      ?>
    </ul>
  </div>
  <script>
      document.querySelectorAll('#cancelamentos-wrapper input[type="file"]').forEach(inp => inp.classList.add('dashicons', 'dashicons-cloud-upload'));
  </script>
  </section>
  <?php
}

?>
<?php
defined( 'ABSPATH' ) || exit;
global $wpdb;
$text_align = is_rtl() ? 'right' : 'left';

// do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
<style>
.excursao-card {
        border: 1px solid #ddd;
        border-radius: 14px;
        margin-bottom: 20px;
        padding: 15px;
        background-color: #fafafa;
    }
    .info-linha {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
    }
    .embarque {
        background-color: #400f0f0d;
        border-left: 4px solid #400f0f;
        padding: 10px;
        margin-top: 10px;
        border-radius: 4px;
    }
    .embarque a {
        color: #400f0f;
        text-decoration: none;
        font-weight: bold;
    }
    .passageir
    .passageiros {
        margin-top: 10px;
        border-top: 1px solid #ddd;
        padding-top: 10px;
    }
    .passageiro {
        padding: 6px 0;
        border-bottom: 1px solid #eee;
        font-size: .825rem;
    }
    .wpp-link-container{
      margin-top: 14px;
      border: 2px solid #414e46;
      padding: 7px;
      border-radius: 10px;
      background-color: #cbe7cb;
    }
</style>
<h2 style="margin-bottom: 0px">
	<?php
	if ( $sent_to_admin ) {
		$before = '<a class="link" href="' . esc_url( $order->get_edit_order_url() ) . '">';
		$after  = '</a>';
	} else {
		$before = '';
		$after  = '';
	}
	?>
</h2>

<div>
  <?php
    $passageiros_items = get_post_meta($order -> get_id(), 'passageiros_items', true);
    $p_index = 0;

    foreach($order -> get_items() as $_i => $email_item){
    //Excursão
    $nome_excursao = substr($email_item['name'], 0, -13);
    $data_excursao = array_filter($email_item -> get_meta_data(), function($item){
          if($item->key === 'dia') return $item;
        })[0] -> value;
    $link_wpp = get_post_meta($passageiros_items[$p_index]['variation_id'], 'link_wpp', true);

    //Embarque
    $emb_id = $passageiros_items[$p_index]['embarque'];
    $dados_embarque = $wpdb -> get_results("SELECT nome, endereco, obs, link_mapa from aer_embarques WHERE id = $emb_id");
    $nome_embarque = $dados_embarque[0] -> nome;
    $endereco_embarque = $dados_embarque[0] -> endereco;
    $obs_embarque = $dados_embarque[0] -> obs;
    $link_mapa_embarque = $dados_embarque[0] -> link_mapa;
    $horario_embarque = $passageiros_items[$p_index]['horario'];

    //Passageiros
    $passageiros = $passageiros_items[$p_index]['passageiros'];
    $passageiros = array_filter($passageiros, function($p) {if($p !== false) return $p; });
    ?>

    <!-- Bloco de excursão -->
    <div class="excursao-card">
      <h2>Excursão <?= $nome_excursao; ?></h2>
      <div class="info-linha"><span><strong>Data:</strong> <?= $data_excursao; ?></span><span><strong>Horário:</strong> <?= $horario_embarque; ?></span></div>
      <div class="info-linha"><span><strong>Local de embarque:</strong> <?= $nome_embarque; ?></span></div>

      <div class="embarque">
          <p><strong>Endereço:</strong> <?= $endereco_embarque; ?></p>
          <p><strong>Referência:</strong> <?= $obs_embarque; ?></p>
          <p><a href="<?= $link_mapa_embarque; ?>">📍 Ver no Google Maps</a></p>
      </div>

      <?php
        if($link_wpp){
          ?>
            <div class="wpp-link-container">
              <p style="text-align: center; text-transform: uppercase; letter-spacing: .04rem; font-weight: 600; font-size: 13px; margin-bottom: -2px">Grupo no WhatsApp já disponível!</p>
              <p style="text-align: center; font-size: 13px">Solicite acesso pelo link abaixo:</p>
              <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 3px">
                <a style="font-size: 13px;" href="<?= $link_wpp; ?>" target="_blank"><?= $link_wpp; ?></a> <span style="font-size: 9px; line-height: 2; height: fit-content; border: 1px solid gray; padding: 0px 3px; border-radius: 2px; letter-spacing: .04rem; cursor: pointer" onclick="copyToClipboard('<?= $link_wpp; ?>', this)">COPIAR</span>
              </div>
                  
              <?php
              if(count($passageiros) > 1){
                ?>
                  <p style="text-align: center; font-size: 12px; line-height: 1.25;">Copie e compartilhe com os demais passageiros de sua reserva. Apenas as solicitações feitas pelos números informados na reserva serão aprovadas.</p>

                <?php
              }
              ?>
            </div>
          <?php
        }
      ?>

      <div class="passageiros">
          <h3>Passageiros</h3>

          <?php
            foreach($passageiros as $passageiro) {
              $rota = esc_html($passageiro -> tripType);
							$rota = $rota == 'ida-e-volta' ? "Ida e volta" : 'Apenas ' . $rota;
              ?>
                <div class="passageiro">
                    <strong>Nome:</strong> <?= $passageiro-> nome_completo; ?><br>
                    <strong>CPF:</strong> <?= cpf_mask($passageiro-> cpf); ?><br>
                    <strong>Telefone:</strong> <?= $passageiro-> celular; ?><br>
                    <strong>Nascimento:</strong> <?= $passageiro-> data_nascimento; ?><br>
                    <strong>Modalidade:</strong> <?= $rota; ?>
                </div>
              <?php
            }
          ?>
        </div>
    </div>



    <?php
    $p_index = $p_index + 1;
  }


  ?>


  <script>
    async function copyToClipboard(textToCopy, element) {
      try {
        await navigator.clipboard.writeText(textToCopy);
        element.innerText = 'COPIADO';
      } catch (err) {
        console.error('Falha ao copiar: ', err);
      }
    }
  </script>
</div>

<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>

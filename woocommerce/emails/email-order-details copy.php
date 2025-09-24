<?php
defined( 'ABSPATH' ) || exit;
global $wpdb;
$text_align = is_rtl() ? 'right' : 'left';

// do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); ?>
<style>
  .link-mapa{
    font-size: .7rem;
    display: inline-block;
    margin-left: 6px
  }
  .email-lista-excursoes{
    list-style:none; 
    padding-left: 0px; 
    display: flex; 
    flex-direction: column; 
    gap: 10px; 
    margin-top: 5px
  }
  .emb-endereco{
    margin-bottom: -3px!important;
  }
  .emb-obs{
    font-size: .8rem;
    font-weight: 600
  }
</style>
<h2>
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

<div style="margin-bottom: 14px;">

  <div>
    <!-- <i style="font-size: .825rem; text-transform:uppercase; font-weight: 400;">Excursão</i> -->
    <ul class="email-lista-excursoes">
      <?php
      // $aer_embarques = get_option('aer_embarques');
      $passageiros_items = get_post_meta($order -> get_id(), 'passageiros_items', true);

      $p_index = 0;

      foreach($order -> get_items() as $_i => $email_item){
        $emb_id = $passageiros_items[$p_index]['embarque'];
        $dados_embarque = $wpdb -> get_results("SELECT nome, endereco, obs, link_mapa from aer_embarques WHERE id = $emb_id");

        // print_r($email_item -> get_meta_data());
        $dia = array_filter($email_item -> get_meta_data(), function($item){
          if($item->key === 'dia') return $item;
        })[0] -> value;
        $passageiros = $passageiros_items[$p_index]['passageiros'];
				$passageiros = array_filter($passageiros, function($p) {if($p !== false) return $p; });
        $nome_embarque = $dados_embarque[0] -> nome;
        $endereco_embarque = $dados_embarque[0] -> endereco;
        $obs_embarque = $dados_embarque[0] -> obs;
        $link_mapa_embarque = $dados_embarque[0] -> link_mapa;
        $horario = $passageiros_items[$p_index]['horario'];
        $link_wpp = get_post_meta($passageiros_items[$p_index]['variation_id'], 'link_wpp', true);


        ?>
        <li style="background-color: #d5d4d7; padding: 16px 20px; border-radius: .5rem; box-shadow: 2px 2px 2px #a7a7a7">
          <div>
            <p style="margin-bottom: 4px; font-size: 1.2rem">Excursão <?= substr($email_item['name'], 0, -13); ?></p>
            <span style="font-size: .825rem"><b>Dia:</b> <?= $dia; ?></span>                                           | <span style="font-size: .825rem"><b>Local de embarque:</b> <?= $nome_embarque; ?></span> | <span style="font-size: .825rem"><b>Horário:</b> <?= $horario; ?></span>


            <div style="display: flex; gap: 6px; margin-top: 14px">
              <svg style="padding-top: 5px" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
              </svg>
              <div>
                <p style="font-weight: 600; font-size: .825rem; text-transform: uppercase; margin-bottom: 2px">Endereço do local de embarque</p>
                <p class="emb-endereco"><?= $endereco_embarque; ?><a href="<?= $link_mapa_embarque; ?>" target="_blank" class="link-mapa">(ver no mapa)</a></p>
                <p class="emb-obs"><?= $obs_embarque; ?></p>
              </div>
              
            </div>
          </div>
          <hr style="width: 100px; border-style: solid; margin: 12px auto"/>
          <div class="passageiros">
            <p style="font-weight: 600; font-size: .825rem; text-transform: uppercase; margin-bottom: 2px">Reserva para <?= sizeof($passageiros); ?> <?= sizeof($passageiros) > 1 ? 'passageiros' : 'passageiro'; ?></p>
            <ul>
              <?php
                foreach($passageiros as $passageiro) {
                  ?>
                    <li style="margin-top: 12px">
                      <p style="margin-bottom: 1px; font-weight: 600"><?= $passageiro-> nome_completo; ?></p>
                      <p style="margin-bottom: 1px; font-size: .8rem">CPF: <?= cpf_mask($passageiro-> doc); ?></p>
                      <p style="margin-bottom: 1px; font-size: .8rem">Telefone: <?= $passageiro-> telefone; ?></p>
                    </li>
                  <?php
                }
              ?>
            </ul>
          </div>
          <?php
            if($link_wpp){
              ?>
                <div style="margin-top: 14px; border: 2px solid #414e46; padding: 8px; border-radius: 10px; background-color: #cfdbcf">
                  <p style="text-align: center; text-transform: uppercase; letter-spacing: .04rem; font-weight: 600; font-size: 13px; margin-bottom: -2px">Grupo no WhatsApp já disponível!</p>
                  <p style="text-align: center; font-size: 13px">Solicite acesso pelo link abaixo:</p>
                  <div style="display: flex; justify-content: center; gap: 16px; margin-bottom: 12px">
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
        </li>
        <?php
        $p_index = $p_index + 1;
      }
      ?>
    </ul>
    <div style="display:flex; justify-content: space-between">
      
      <div class="email-pagamento-box"style="width: 100%; background-color: #d9d9d9; padding: 8px; border-radius: .2rem">
        <b style="margin-bottom: 8px; font-size: .775rem; display: block; line-height: 1.1">Resumo do pagamento</b>
        <div style="display: flex;">
          <div style="font-size: .775rem"><b>Pedido: #</b><?= $order -> get_order_number(); ?></div>
          <div style="font-size: .775rem; margin-left: 15px"><b>Data: </b><?= $order -> get_date_created()->format( 'd/m/Y' ); ?></div>
        </div>
        
        <div style="font-size: .775rem"><b>Valor: </b><?= $order -> get_formatted_order_total(); ?></div>
        <div style="font-size: .775rem; line-height: 1.25;"><b>Forma de pagamento: </b><?= $order -> get_payment_method_title(); ?></div>

      </div>
      
    </div>
  </div>
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

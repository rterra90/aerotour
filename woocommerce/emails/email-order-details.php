<?php
defined('ABSPATH') || exit;
global $wpdb;
$text_align = is_rtl() ? 'right' : 'left';

// do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email ); 
?>
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

  .passageir .passageiros {
    margin-top: 10px;
    border-top: 1px solid #ddd;
    padding-top: 10px;
  }

  .passageiro {
    padding: 6px 0;
    border-bottom: 1px solid #eee;
    font-size: .825rem;
  }

  .wpp-link-container {
    margin-top: 14px;
    border: 2px solid #414e46;
    padding: 7px;
    border-radius: 10px;
    background-color: #cbe7cb;
  }
</style>
<h2 style="margin-bottom: 0px">
  <?php
  if ($sent_to_admin) {
    $before = '<a class="link" href="' . esc_url($order->get_edit_order_url()) . '">';
    $after  = '</a>';
  } else {
    $before = '';
    $after  = '';
  }
  ?>
</h2>

<div>
  <?php
  $passageiros_items = get_post_meta($order->get_id(), 'passageiros_items', true);
  $p_index = 0;

  foreach ($order->get_items() as $_i => $email_item) {
    //Excursão
    $nome_excursao = substr($email_item['name'], 0, -13);
    $data_excursao = array_filter($email_item->get_meta_data(), function ($item) {
      if ($item->key === 'dia') return $item;
    })[0]->value;
    $link_wpp = get_post_meta($passageiros_items[$p_index]['variation_id'], 'link_wpp', true);

    //Embarque
    $emb_id = $passageiros_items[$p_index]['embarque'];
    $dados_embarque = $wpdb->get_results("SELECT nome, endereco, obs, link_mapa from aer_embarques WHERE id = $emb_id");
    $nome_embarque = $dados_embarque[0]->nome;
    $endereco_embarque = $dados_embarque[0]->endereco;
    $obs_embarque = $dados_embarque[0]->obs;
    $link_mapa_embarque = $dados_embarque[0]->link_mapa;
    $horario_embarque = $passageiros_items[$p_index]['horario'];

    //Passageiros
    $passageiros = $passageiros_items[$p_index]['passageiros'];
    $passageiros = array_filter($passageiros, function ($p) {
      if ($p !== false) return $p;
    });
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
      if ($link_wpp && strlen($link_wpp) > 10) :
      ?>
        <div class="wpp-link-container" style="background-color: #e6eee9; border: 2px solid #25d366; border-radius: 10px; padding: 20px; margin: 20px 0; text-align: center;">

          <div style="margin-bottom: 10px;">
            <h4 style="color: #128c7e; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; font-size: 14px; margin: 5px 0;">
              Grupo no WhatsApp Disponível!
            </h4>
          </div>

          <p style="color: #333; font-size: 14px; margin: 0 0 15px 0; line-height: 1.4;">
            Solicite abaixo acesso ao grupo oficial da excursão:
          </p>

          <div style="margin-bottom: 15px;">
            <a href="<?php echo esc_url($link_wpp); ?>"
              target="_blank"
              style="background-color: #25d366; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 15px; display: inline-block; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
              SOLICITAR
            </a>
          </div>

          <p style="font-size: 11px; color: #666; margin: 10px 0 0 0;">
            Se o botão não funcionar, copie e cole este link:<br>
            <code style="background: rgba(255,255,255,0.5); padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 5px; color: #400f0f; font-weight: bold;">
              <?php echo esc_html($link_wpp); ?>
            </code>
          </p>

          <?php if (count($passageiros) > 1) : ?>
            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(37, 211, 102, 0.3);">
              <p style="font-size: 12px; color: #444; line-height: 1.4; margin: 0;">
                <strong>Atenção:</strong> Compartilhe o link com os demais passageiros. <br>
                <span style="font-size: 11px; color: #666;">Apenas números informados na reserva serão aprovados.</span>
              </p>
            </div>
          <?php endif; ?>

        </div>
      <?php endif; ?>

      <div class="passageiros">
        <h3>Passageiros</h3>

        <?php
        foreach ($passageiros as $passageiro) {
          $rota = esc_html($passageiro->tripType);
          $rota = $rota == 'ida-e-volta' ? "Ida e volta" : 'Apenas ' . $rota;
        ?>
          <div class="passageiro">
            <strong>Nome:</strong> <?= $passageiro->nome_completo; ?><br>
            <strong>CPF:</strong> <?= cpf_mask($passageiro->cpf); ?><br>
            <strong>Telefone:</strong> <?= $passageiro->celular; ?><br>
            <strong>Nascimento:</strong> <?= $passageiro->data_nascimento; ?><br>
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

<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>
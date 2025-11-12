<?php
// ======================
// RELATÓRIOS DE PARCEIROS
// ======================
add_action('admin_menu', function () {
  add_submenu_page(
    'edit.php?post_type=pdv', // Submenu do CPT Parceiro
    'Relatórios de PDVs', // Título da página
    'Relatórios', // Nome no menu
    'manage_woocommerce', // Permissão
    'relatorios_pdv', // Slug da página
    'render_relatorios_pdv_page' // Função de renderização
  );
});

function render_relatorios_pdv_page()
{
  // Obtém datas enviadas ou define padrão (últimos 30 dias)
  $data_inicio = isset($_GET['data_inicio'])
    ? sanitize_text_field($_GET['data_inicio'])
    : date('Y-m-d', strtotime('-1 year'));
  $data_fim = isset($_GET['data_fim'])
    ? sanitize_text_field($_GET['data_fim'])
    : date('Y-m-d');

  // URLs base e de períodos rápidos
  $base_url = admin_url('edit.php?post_type=pdv&page=relatorios_pdv');
  $periodos = [
    '1m' => [
      'label' => 'Último mês',
      'inicio' => date('Y-m-d', strtotime('-1 month')),
      'fim' => date('Y-m-d')
    ],
    '3m' => [
      'label' => '3 meses',
      'inicio' => date('Y-m-d', strtotime('-3 months')),
      'fim' => date('Y-m-d')
    ],
    '6m' => [
      'label' => '6 meses',
      'inicio' => date('Y-m-d', strtotime('-6 months')),
      'fim' => date('Y-m-d')
    ],
    '12m' => [
      'label' => '1 ano',
      'inicio' => date('Y-m-d', strtotime('-1 year')),
      'fim' => date('Y-m-d')
    ]
  ];
  ?>
    <div class="wrap">
        <h1>Relatórios de PDVs</h1>
        <p>Resumo de desempenho dos pontos de vendas.</p>
       <div class="relatorios-filtros" style="
            background: #fff;
            border: 1px solid #ccd0d4;
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        ">
        <form method="get" style="display:flex; flex-wrap:wrap; align-items:center; gap:8px; margin:0;">
            <input type="hidden" name="post_type" value="pdv">
            <input type="hidden" name="page" value="relatorios_pdv">

            <label for="data_inicio"><strong>Período:</strong></label>
            <input type="date" id="data_inicio" name="data_inicio" value="<?php echo esc_attr(
              $data_inicio
            ); ?>">
            <span>até</span>
            <input type="date" id="data_fim" name="data_fim" value="<?php echo esc_attr(
              $data_fim
            ); ?>">


            <button type="submit" class="button button-primary">Filtrar</button>
            <a href="<?php echo esc_url(
              $base_url
            ); ?>" class="button">Limpar</a>
        </form>
        <div style="margin-left:auto; display:flex; gap:8px; flex-wrap:wrap;">
          <?php foreach ($periodos as $key => $p): ?>
              <a href="<?php echo esc_url(
                add_query_arg(
                  ['data_inicio' => $p['inicio'], 'data_fim' => $p['fim']],
                  $base_url
                )
              ); ?>"
                  class="button <?php echo isset(
                    $_GET['data_inicio'],
                    $_GET['data_fim']
                  ) &&
                  $_GET['data_inicio'] === $p['inicio'] &&
                  $_GET['data_fim'] === $p['fim']
                    ? 'button-primary'
                    : ''; ?>">
                  <?php echo esc_html($p['label']); ?>
              </a>
          <?php endforeach; ?>
        </div>

      </div>  
        <?php if ($data_inicio && $data_fim): ?>
        <p>Exibindo pedidos entre <strong><?php echo esc_html(
          date_i18n('d/m/Y', strtotime($data_inicio))
        ); ?></strong> e <strong><?php echo esc_html(
  date_i18n('d/m/Y', strtotime($data_fim))
); ?></strong>.</p>
        <?php endif; ?>
        <?php render_tabela_relatorios_pdv($data_inicio, $data_fim); ?>
    </div>
    <?php
}

function render_tabela_relatorios_pdv($data_inicio, $data_fim)
{
  global $wpdb;

  // Conversão para formato aceito pelo MySQL
  $data_inicio = $data_inicio
    ? date('Y-m-d 00:00:00', strtotime($data_inicio))
    : '1970-01-01 00:00:00';
  $data_fim = $data_fim
    ? date('Y-m-d 23:59:59', strtotime($data_fim))
    : date('Y-m-d 23:59:59');

  $results = $wpdb->get_results(
    $wpdb->prepare(
      "
    SELECT meta.meta_value AS codigo, post_id AS order_id
    FROM {$wpdb->prefix}postmeta AS meta
    INNER JOIN {$wpdb->prefix}posts AS p
      ON meta.post_id = p.ID
    WHERE meta.meta_key = 'parceiro_pdv'
      AND p.post_type = 'shop_order'
      AND p.post_status IN ('wc-completed','wc-processing','wc-on-hold')
      AND p.post_date BETWEEN %s AND %s
  ",
      $data_inicio,
      $data_fim
    )
  );

  if (empty($results)) {
    echo '<p>Nenhum pedido associado a pontos de venda foi encontrado no período.</p>';
    return;
  }

  // Variáveis acumuladoras
  $total_pedidos_geral = 0;
  $valor_total_geral = 0;
  $total_comissao_geral = 0;

  echo '<table class="widefat striped" style="margin-top:20px;">';
  echo '<thead>
            <tr>
            <th></th>
            <th>Nome</th>
            <th>Código</th>
            <th>Nº de Pedidos</th>
            <th>Total Vendido</th>
            <th>Comissão Atual</th>
            <th>Total em Comissão</th>
            </tr>
          </thead>
          <tbody>';

  function group_results($results)
  {
    $grouped_data = [];

    // 1. Iterar e agrupar
    foreach ($results as $item) {
      $codigo = $item->codigo;
      $order_id = $item->order_id;

      // Se o 'codigo' ainda não existe no array auxiliar, inicializa com um array
      if (!isset($grouped_data[$codigo])) {
        $grouped_data[$codigo] = [
          'codigo' => $codigo,
          'order_id' => []
        ];
      }
      // Adiciona o 'order_id' ao array correspondente
      $grouped_data[$codigo]['order_id'][] = $order_id;
    }
    // 2. Reformatar para o formato de array de objetos (se necessário)
    // Usamos array_values para reindexar o array e converter cada item em um objeto
    $output_array = array_map(function ($data) {
      // Converte o array associativo em um objeto stdClass
      return (object) $data;
    }, array_values($grouped_data));
    return $output_array;
  }

  $parceiros_data = [];

  $results = group_results($results);
  foreach ($results as $result) {
    $result->nome_comercial = obter_nome_pdv_por_codigo($result->codigo);
    $result->comissao_atual = obter_comissao_pdv_por_codigo($result->codigo);
    $result->num_pedidos = count($result->order_id);
    $result->valores_e_comissoes = [];
    $result->valor_total = 0;
    $result->total_comissao = 0;

    foreach ($result->order_id as $order_id) {
      //obter valor do pedido
      $order = wc_get_order($order_id);
      $result->valor_total += floatval($order->get_total());

      //obter valor da comissão
      $comissao_percentual = floatval($order->get_meta('pdv_comissao'));
      $valor_comissao =
        floatval($order->get_total()) * ($comissao_percentual / 100);
      $result->total_comissao += $valor_comissao;

      //armazenar detalhes para debug
      $result->valores_e_comissoes[] = [
        'order_id' => $order_id,
        'valor' => floatval($order->get_total()),
        'comissao_percentual' => $comissao_percentual,
        'valor_comissao' => $valor_comissao
      ];
    }
    $total_pedidos_geral += $result->num_pedidos;
    $valor_total_geral += $result->valor_total;
    $total_comissao_geral += $result->total_comissao;
  }
  foreach ($results as $result) {
    echo '<tr class="linha-parceiro" data-codigo="' .
      esc_attr($result->codigo) .
      '"><td style="width:30px; text-align:center;">
              <button class="toggle-detalhes button" data-target="detalhes-' .
      esc_attr($result->codigo) .
      '">👁️</button>
            </td>
                  <td>' .
      esc_html($result->nome_comercial ?: '(não encontrado)') .
      '</td>
                  <td><code>' .
      esc_html($result->codigo) .
      '</code></td>
                  <td>' .
      esc_html(count($result->order_id)) .
      '</td>
                  <td><strong>' .
      wc_price($result->valor_total ?: 0) .
      '</strong></td>
        <td>' .
      esc_html(number_format($result->comissao_atual, 2)) .
      '%</td>
                  <td><strong>' .
      wc_price($result->total_comissao ?: 0) .
      '</strong></td>
                </tr>';

    // Linha de detalhes oculta
    echo '<tr id="detalhes-' .
      esc_attr($result->codigo) .
      '" class="detalhes-parceiro" style="display:none;">
            <td colspan="7" style="background:#fafafa; padding:10px 20px;">
              <table class="widefat striped" style="margin:0;">
                <thead>
                  <tr>
                    <th>ID do Pedido</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Comissão (%)</th>
                    <th>Valor Comissão</th>
                  </tr>
                </thead>
                <tbody>';

    foreach ($result->valores_e_comissoes as $pedido) {
      $data_do_pedido = get_the_date('d/m/Y', $pedido['order_id']);
      echo '<tr>
              <td><a href="' .
        esc_url(get_edit_post_link($pedido['order_id'])) .
        '" target="_blank">#' .
        esc_html($pedido['order_id']) .
        '</a></td>
              <td>' .
        esc_html($data_do_pedido) .
        '</td>
              <td>' .
        wc_price($pedido['valor']) .
        '</td>
              <td>' .
        sprintf('%.2f%%', $pedido['comissao_percentual']) .
        '</td>
              <td>' .
        wc_price($pedido['valor_comissao']) .
        '</td>
            </tr>';
    }

    echo '</tbody>
              </table>
            </td>
          </tr>';
  }
  echo '</tbody><tfoot>
            <tr style="background:#f1f1f1; font-weight:bold;">
                <td></td>
                <td colspan="2" style="text-align:right;">Total geral:</td>
                <td>' .
    esc_html($total_pedidos_geral) .
    '</td>
                <td>' .
    wc_price($valor_total_geral) .
    '</td>
                <td>—</td>
                <td><strong>' .
    wc_price($total_comissao_geral) .
    '</strong></td>
            </tr>
          </tfoot></table>';

  // Script para expandir/ocultar detalhes
  echo "<script>
  document.querySelectorAll('.toggle-detalhes').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = document.getElementById(btn.dataset.target);
      if (target.style.display === 'none' || !target.style.display) {
        target.style.display = 'table-row';
        btn.textContent = '🔽';
      } else {
        target.style.display = 'none';
        btn.textContent = '👁️';
      }
    });
  });
  </script>";
}

?>

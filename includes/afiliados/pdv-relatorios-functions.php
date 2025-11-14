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
      INNER JOIN {$wpdb->prefix}posts AS p ON meta.post_id = p.ID
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

  // Agrupar pedidos por parceiro
  $grouped = [];
  foreach ($results as $item) {
    $codigo = $item->codigo;
    $grouped[$codigo]['codigo'] = $codigo;
    $grouped[$codigo]['order_id'][] = $item->order_id;
  }

  $total_geral = [
    'pedidos' => 0,
    'valor' => 0,
    'comissao' => 0,
    'paga' => 0,
    'pendente' => 0
  ];

  echo '<table class="widefat striped" style="margin-top:20px;">';
  echo '<thead><tr>
          <th></th>
          <th>Nome</th>
          <th>Código</th>
          <th>Nº Pedidos</th>
          <th>Total Vendido</th>
          <th>Comissão Atual</th>
          <th>Total Comissão</th>
          <th>Comissão Paga</th>
          <th>Comissão Pendente</th>
        </tr></thead><tbody>';

  foreach ($grouped as $codigo => $dados) {
    $nome = obter_nome_pdv_por_codigo($codigo);
    $comissao_atual = obter_comissao_pdv_por_codigo($codigo);
    $orders = $dados['order_id'];

    // Recupera informações de contato
    $pdv_post = obter_post_pdv_por_codigo($codigo);
    $pdv_email = get_post_meta($pdv_post->ID, 'pdv_email', true);
    $pdv_telefone = get_post_meta($pdv_post->ID, 'pdv_telefone', true);
    $pdv_nome_contato = get_post_meta($pdv_post->ID, 'pdv_nome_contato', true);

    $soma_vendas = 0;
    $soma_comissao = 0;
    $soma_paga = 0;
    $soma_pendente = 0;
    $pedidos = [];

    foreach ($orders as $order_id) {
      $order = wc_get_order($order_id);
      if (!$order) {
        continue;
      }

      $valor = floatval($order->get_total());
      $percentual = floatval($order->get_meta('pdv_comissao'));
      $valor_comissao = $valor * ($percentual / 100);
      $paga = $order->get_meta('pdv_comissao_paga') === 'yes';

      $soma_vendas += $valor;
      $soma_comissao += $valor_comissao;
      if ($paga) {
        $soma_paga += $valor_comissao;
      } else {
        $soma_pendente += $valor_comissao;
      }

      $pedidos[] = [
        'id' => $order_id,
        'data' => $order->get_date_created()
          ? $order->get_date_created()->date_i18n('d/m/Y H:i')
          : '-',
        'valor' => $valor,
        'percentual' => $percentual,
        'valor_comissao' => $valor_comissao,
        'paga' => $paga
      ];
    }

    $total_geral['pedidos'] += count($orders);
    $total_geral['valor'] += $soma_vendas;
    $total_geral['comissao'] += $soma_comissao;
    $total_geral['paga'] += $soma_paga;
    $total_geral['pendente'] += $soma_pendente;

    echo '<tr>
            <td style="width:30px;text-align:center;">
              <button class="toggle-detalhes button" data-target="det-' .
      esc_attr($codigo) .
      '">👁️</button>
            </td>
            <td><a href="#" 
         class="ver-contato-pdv"
         data-nome="' .
      esc_attr($nome) .
      '"
         data-email="' .
      esc_attr($pdv_email) .
      '"
         data-telefone="' .
      esc_attr($pdv_telefone) .
      '"
         data-nome-contato="' .
      esc_attr($pdv_nome_contato) .
      '"
         data-codigo="' .
      esc_attr($codigo) .
      '"
      >' .
      esc_html($nome ?: '(não encontrado)') .
      '</a></td>
            <td><code>' .
      esc_html($codigo) .
      '</code></td>
            <td>' .
      count($orders) .
      '</td>
            <td>' .
      wc_price($soma_vendas) .
      '</td>
            <td>' .
      sprintf('%.2f%%', $comissao_atual) .
      '</td>
            <td>' .
      wc_price($soma_comissao) .
      '</td>
            <td>' .
      wc_price($soma_paga) .
      '</td>
            <td>' .
      wc_price($soma_pendente) .
      '</td>
          </tr>';

    // Detalhes
    echo '<tr id="det-' .
      esc_attr($codigo) .
      '" class="detalhes" style="display:none;">
            <td colspan="9" style="background:#fafafa;padding:15px;">
              <div class="area-detalhes">
              <div style="margin-bottom:8px;display:flex;justify-content:space-between;align-items:center;">
                <strong>Pedidos de ' .
      esc_html($nome) .
      '</strong>
                <div>
                  <span class="total-selecionado" style="margin-right:10px;padding-top:5px;display:inline-block;color:#555;font-weight:bold;"></span>
                  <button class="button pagar-selecionados" data-codigo="' .
      esc_attr($codigo) .
      '" disabled>💰 Pagar selecionados</button>
                </div>
              </div>
              <table class="widefat striped" style="margin:0;">
                <thead><tr>
                  <th>ID</th><th>Data</th><th>Valor</th>
                  <th>Comissão (%)</th><th>Valor Comissão</th><th>Status</th><th></th>
                </tr></thead><tbody>';
    foreach ($pedidos as $p) {
      $chk_disabled = $p['paga'] ? 'disabled' : '';
      $status_txt = $p['paga']
        ? '<span style="color:green;">Pago</span>'
        : '<span style="color:#a00;">Pendente</span>';
      echo '<tr>
              
              <td><a href="' .
        esc_url(get_edit_post_link($p['id'])) .
        '" target="_blank">#' .
        $p['id'] .
        '</a></td>
              <td>' .
        esc_html($p['data']) .
        '</td>
              <td>' .
        wc_price($p['valor']) .
        '</td>
              <td>' .
        sprintf('%.2f%%', $p['percentual']) .
        '</td>
              <td>' .
        wc_price($p['valor_comissao']) .
        '</td>
              <td>' .
        $status_txt .
        '</td>
        <td><input type="checkbox" class="chk-pagamento" data-valor="' .
        esc_attr($p['valor_comissao']) .
        '" data-order="' .
        esc_attr($p['id']) .
        '" ' .
        $chk_disabled .
        '></td>
            </tr>
            ';
    }
    echo '</tbody></table><table><h4>Histórico de Pagamentos</h4>
<table class="widefat striped">
  <thead>
    <tr>
      <th>Data</th>
      <th>Valor Pago</th>
      <th>Pedidos Incluídos</th>
      <th>Registrado Por</th>
      <th>Observação</th>
    </tr>
  </thead><tbody>';
    $historico = $wpdb->get_results(
      $wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}pdv_comissoes_pagamentos WHERE codigo_pdv = %s ORDER BY data_pagamento DESC",
        $codigo
      )
    );

    if ($historico) {
      foreach ($historico as $h) {
        $user = get_userdata($h->registrado_por);
        echo '<tr>';
        echo '<td>' .
          esc_html(date_i18n('d/m/Y H:i', strtotime($h->data_pagamento))) .
          '</td>';
        echo '<td>' . wc_price($h->valor_pago) . '</td>';
        echo '<td>' .
          esc_html(implode(', ', maybe_unserialize($h->referencia_pedidos))) .
          '</td>';
        echo '<td>' . esc_html($user ? $user->display_name : '-') . '</td>';
        echo '<td>' . esc_html($h->observacao ?: '-') . '</td>';
        echo '</tr>';
      }
    } else {
      echo '<tr><td colspan="5">Nenhum pagamento registrado ainda.</td></tr>';
    }
    echo '</table></div></td></tr>';
  }

  // Rodapé
  echo '</tbody><tfoot><tr style="background:#f1f1f1;font-weight:bold;">
          <td colspan="3" style="text-align:right;">Totais gerais:</td>
          <td>' .
    $total_geral['pedidos'] .
    '</td>
          <td>' .
    wc_price($total_geral['valor']) .
    '</td>
          <td>—</td>
          <td>' .
    wc_price($total_geral['comissao']) .
    '</td>
          <td>' .
    wc_price($total_geral['paga']) .
    '</td>
          <td>' .
    wc_price($total_geral['pendente']) .
    '</td>
        </tr></tfoot></table>';// JS
  ?>
  <script>

    //exibe ou oculta detalhes
  document.querySelectorAll('.toggle-detalhes').forEach(btn=>{
    btn.addEventListener('click',()=>{
      const t=document.getElementById(btn.dataset.target);
      const visible=t.style.display==='table-row';
      t.style.display=visible?'none':'table-row';
      btn.textContent=visible?'👁️':'🔽';
    });
  });

  // Gerencia seleção de comissões para pagamento
  document.querySelectorAll('.detalhes').forEach(section=>{
    const totalSpan=section.querySelector('.total-selecionado');
    const btnPagar=section.querySelector('.pagar-selecionados');
    section.querySelectorAll('.chk-pagamento').forEach(chk=>{
      chk.addEventListener('change',()=>{
        const selecionados=[...section.querySelectorAll('.chk-pagamento:checked')];
        const total=selecionados.reduce((s,c)=>s+parseFloat(c.dataset.valor||0),0);
        totalSpan.textContent=selecionados.length?('Total selecionado: '+total.toLocaleString('pt-BR',{style:'currency',currency:'BRL'})):'';
        btnPagar.disabled=selecionados.length===0;
      });
    });

    // Ação de pagar selecionados
    btnPagar.addEventListener('click',()=>{
      const selecionados=[...section.querySelectorAll('.chk-pagamento:checked')];
      if(!selecionados.length)return;
      const total=selecionados.reduce((s,c)=>s+parseFloat(c.dataset.valor||0),0);
      const codigo=btnPagar.dataset.codigo;
      const confirmar=confirm(`Você está informando o pagamento de ${total.toLocaleString('pt-BR',{style:'currency',currency:'BRL'})} em comissão de vendas para o PDV ${codigo}. Deseja confirmar?`);
      if(!confirmar)return;
      const ids=selecionados.map(c=>c.dataset.order);

      btnPagar.disabled = true;
      btnPagar.textContent = 'Registrando...';
      // AJAX
      adminApiFetch('marcar_comissoes_pagas', {orders:ids.join(','), codigo_pdv: codigo, valor_total: total, observacao: ''}, (resp, data) => {
        if(resp){
          if(data) alert(data || 'Pagamentos registrados.');
          btnPagar.textContent = 'Aguarde...';
          location.reload()
        } else alert('Erro: '+resp.data);
      })
    });
  });

  //Exibe modal com informações de contato do parceiro
  document.addEventListener('click', function(e) {
  const link = e.target.closest('.ver-contato-pdv');
  if (!link) return;
  e.preventDefault();

  const nome = link.dataset.nome || '';
  const contato = link.dataset.nomeContato || '';
  const email = link.dataset.email || '';
  const telefone = link.dataset.telefone || '';
  const codigo = link.dataset.codigo || '';

  const html = `
    <div id="pdv-modal" style="
      position: fixed; top: 0; left: 0; width: 100%; height: 100%;
      background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center;
      z-index: 9999;
    ">
      <div style="
        background: white; padding: 20px 30px; border-radius: 8px; max-width: 400px; width: 100%;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2); font-family: sans-serif;
      ">
        <h2 style="margin-top:0;">${nome}</h2>
        <p><strong>Código:</strong> ${codigo}</p>
        ${contato ? `<p><strong>Contato:</strong> ${contato}</p>` : ''}
        ${email ? `<p><strong>E-mail:</strong> <a href="mailto:${email}">${email}</a></p>` : ''}
        ${telefone ? `<p><strong>Telefone:</strong> <a href="tel:${telefone}">${telefone}</a></p>` : ''}
        <div style="text-align:right; margin-top:15px;">
          <button id="fechar-modal" class="button button-secondary">Fechar</button>
        </div>
      </div>
    </div>
  `;

  document.body.insertAdjacentHTML('beforeend', html);
  document.getElementById('fechar-modal').addEventListener('click', () => {
    document.getElementById('pdv-modal').remove();
  });
});
  </script>
  <?php
}

// Endpoint AJAX para registrar pagamento
add_action('wp_ajax_marcar_comissoes_pagas', function () {
  //permite apenas administradores ou gerentes de loja
  if (!current_user_can('manage_woocommerce')) {
    wp_send_json_error('Permissão negada.');
  }

  global $wpdb;
  $table = $wpdb->prefix . 'pdv_comissoes_pagamentos';
  $codigo_pdv = sanitize_text_field($_POST['codigo_pdv']);
  $ids_pedidos = array_map('intval', explode(',', $_POST['orders']));
  $valor_total = floatval($_POST['valor_total']);
  $observacao = sanitize_textarea_field($_POST['observacao'] ?? '');
  $user_id = get_current_user_id();

  if (empty($_POST['orders'])) {
    wp_send_json_error('Nenhum pedido recebido.');
  }

  $insert_query = $wpdb->insert($table, [
    'codigo_pdv' => $codigo_pdv,
    'valor_pago' => $valor_total,
    'data_pagamento' => current_time('mysql'),
    'referencia_pedidos' => maybe_serialize($ids_pedidos),
    'registrado_por' => $user_id,
    'observacao' => $observacao
  ]);

  if (!$insert_query) {
    wp_send_json_error('Erro ao registrar pagamento no banco de dados.');
  }

  foreach ($ids_pedidos as $id) {
    update_post_meta($id, 'pdv_comissao_paga', 'yes');
    update_post_meta($id, 'pdv_comissao_data_pagamento', current_time('mysql'));
  }
  wp_send_json_success('Pagamentos atualizados.');
});

?>

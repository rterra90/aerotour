<?php
// 1. Registro da página no Menu Admin
add_action('admin_menu', 'registrar_menu_moderacao_passageiros');
function registrar_menu_moderacao_passageiros() {
    add_menu_page(
        'Moderação de Dados',            // Título da Página
        'Alt. Passageiros',             // Título do Menu
        'manage_options',                // Capacidade necessária
        'moderacao-passageiros',         // Slug do Menu
        'renderizar_pagina_moderacao_passageiros', // Função Callback
        'dashicons-id',                  // Ícone
        25                               // Posição
    );
}

// 2. Carregamento de CSS e Scripts para a página do Admin
add_action('admin_enqueue_scripts', 'carregar_assets_moderacao_passageiros');
function carregar_assets_moderacao_passageiros($hook) {
    if ($hook !== 'toplevel_page_moderacao-passageiros') {
        return;
    }

    // Injeta CSS inline para a interface
    wp_register_style('moderacao-pax-css', false);
    wp_enqueue_style('moderacao-pax-css');
    wp_add_inline_style('moderacao-pax-css', "
        .diff-container {
        position: relative;
            background-color: #f0f6fc;
            border: 1px solid #c5d9ed;
            border-radius: 6px;
            padding: 8px 28px 8px 8px;
            font-size: 12px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            line-height: 1.4;
        }
        .diff-val-original {
            color: #999190;
            margin-bottom: 6px;
            font-family: monospace;
        }
        .diff-val-novo {
            color: #198754;
            font-weight: bold;
            margin-bottom: 4px;
            font-family: monospace;
        }
        .diff-actions {
            display: flex;
            gap: 4px;
            padding-top: 6px;
            position: absolute;
            right: 6px;
            flex-direction: column;
            top: 0px;
        }
        .diff-actions button {
            padding: 0px 2px !important;
            font-size: 11px !important;
            min-height: 24px !important;
            line-height: 1 !important;
            align-items: center;
            gap: 2px;
            display: flex!important;
            opacity: .4;
            transition: all .2s;
        }
        .diff-actions button .dashicons{
            line-height: 1 !important;
        }
            .diff-actions button:hover{
            opacity: 1;
        }
        .badge-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-aprovado { background-color: #d1e7dd; color: #0f5132; }
        .badge-rejeitado { background-color: #f8d7da; color: #842029; }
        .table-moderacao td { vertical-align: middle !important; }

        .table-row-actions > div{
            display: flex;
            flex-direction: column;
            align-items: start;
            gap: 2px;
        }
    ");

    // JS para requisições AJAX sem recarregar a página
    wp_enqueue_script('jquery');

}

function renderizar_pagina_moderacao_passageiros() {
    global $wpdb;

    // obtem todos os registros em aer_solic_edit_pax e ordena por data_solicitacao DESC
    $solicitacoes = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}solic_edit_pax ORDER BY data_solicitacao DESC");

    // obtém as reservas originais associadas às solicitações de edição
    $reservas_ids = array_map(function($res){
        return $res -> reserva_id;
    }, $solicitacoes);
    $reservas_ids_str = implode(',', array_map('intval', $reservas_ids));

    $reservas_originais = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reservas WHERE ID IN($reservas_ids_str)");

    $table_items = array();
    
    foreach($solicitacoes as $solic){
        $original = array_filter($reservas_originais, function($r) use($solic) { return $r -> ID == $solic -> reserva_id; })[0];

        $item = array(
            'orig_nome' => $original -> p_nome,
            'novo_nome' => $solic -> novo_nome,
            'orig_doc' => cpf_mask($original -> p_cpf),
            'novo_doc' => cpf_mask($solic -> novo_doc),
            'orig_telefone' => $original -> p_telefone,
            'novo_telefone' => $solic -> novo_telefone,
            'orig_data_nasc' => $original -> data_nasc,
            'nova_data_nasc' => $solic -> nova_data_nasc,
            'reserva_id' => $solic -> reserva_id,
            'solic_id' => $solic -> id,
            'data_solicitacao' => $solic -> data_solicitacao,
            'status_nome' => $solic -> status_nome,
            'status_doc' => $solic -> status_doc,
            'status_telefone' => $solic -> status_telefone,
            'status_data_nasc' => $solic -> status_data_nasc,
            'status' => $solic -> status
        );

        array_push($table_items, $item);
        
    }

       

    ?>
    <pre>
        <?php  //print_r($table_items); ?>
    </pre>

    <div class="wrap">
        <h1 class="wp-heading-inline">Moderação de Alterações de Passageiros</h1>
        <hr class="wp-header-end">

        <p class="description">
            Avalie as alterações solicitadas pelos clientes. Campos destacados em azul contêm alterações pendentes.
        </p>

        <table class="wp-list-table widefat fixed striped table-view-list table-moderacao mt-3">
            <thead>
                <tr>
                    <th style="width: 90px;">Reserva ID</th>
                    <th>Nome Completo</th>
                    <th>CPF</th>
                    <th>Celular</th>
                    <th>Data de Nascimento</th>
                    <th style="width: 170px;" class="text-end">Ações na Linha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($table_items)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            <strong>Nenhuma solicitação de alteração pendente no momento.</strong>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($table_items as $item): ?>
                        <tr>
                            <!-- ID da Reserva -->
                            <td>
                                <strong>#<?= esc_html($item['reserva_id']); ?></strong>
                                <br>
                                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($item['data_solicitacao'])); ?></small>
                            </td>

                            <!-- 1. Nome Completo -->
                            <td>
                                <?php renderizar_campo_moderacao(
                                    $item['solic_id'], 'nome', 
                                    $item['orig_nome'], $item['novo_nome'], 
                                    $item['status_nome']
                                ); ?>
                            </td>

                            <!-- 2. CPF -->
                            <td>
                                <?php renderizar_campo_moderacao(
                                    $item['solic_id'], 'doc', 
                                    $item['orig_doc'], $item['novo_doc'], 
                                    $item['status_doc']
                                ); ?>
                            </td>

                            <!-- 3. Celular -->
                            <td>
                                <?php renderizar_campo_moderacao(
                                    $item['solic_id'], 'telefone', 
                                    $item['orig_telefone'], $item['novo_telefone'], 
                                    $item['status_telefone']
                                ); ?>
                            </td>

                            <!-- 4. Data de Nascimento -->
                            <td>
                                <?php renderizar_campo_moderacao(
                                    $item['solic_id'], 'data_nasc', 
                                    $item['orig_data_nasc'] ? date('d/m/Y', strtotime($item['orig_data_nasc'])) : '', 
                                    $item['nova_data_nasc'] ? date('d/m/Y', strtotime($item['nova_data_nasc'])) : '', 
                                    $item['status_data_nasc']   
                                ); ?>
                            </td>

                            <!-- Ações da Linha Completa -->
                            <td>
                                <div class="table-row-actions" id="actions-<?= $item['solic_id'] ?>">
                                    <div class="pending-solic <?=  $item['status'] === 'concluido' ? 'd-none' : ''; ?>">
                                        <button type="button" 
                                            class="button button-primary button-small btn-acao-linha" 
                                            onclick="processarTudo(<?= $item['reserva_id']; ?>, 'aceitar')">
                                            <span class="dashicons dashicons-yes-alt" style="font-size:14px; line-height:1.4;"></span> Aceitar Tudo
                                        </button>
                                        <button type="button" 
                                                class="button button-secondary button-small btn-acao-linha" 
                                                style="color: #b32d2e; border-color: #b32d2e;"
                                                onclick="processarTudo(<?= $item['reserva_id']; ?>, 'rejeitar')">
                                            <span class="dashicons dashicons-dismiss" style="font-size:14px; line-height:1.4;"></span> Rejeitar Tudo
                                        </button>
                                    </div>

                                    <div class="concluido-solic <?=  $item['status'] !== 'concluido' ? 'd-none' : ''; ?>">
                                        <!-- botão para apagar a solicitação na tabela solic_edit_pax, apenas para fins de limpeza, não afeta a reserva -->
                                        <button type="button" 
                                                class="button button-small" 
                                                style="color: #6c757d; border-color: #6c757d;"
                                                onclick="processarTudo(<?= $item['solic_id']; ?>, 'limpar')">
                                            <span class="dashicons dashicons-trash" style="font-size:14px; line-height:1.4;"></span> Limpar Solicitação
                                        </button>
                                    </div>
                                    
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Script de Processamento AJAX -->
    <script>
    async function processarCampo(solicitationId, campo, acao, valorOriginal) {
        const ajaxData = new FormData();
        ajaxData.append('action', 'avaliar_edit_reserva');
        ajaxData.append('solicitacao_id', solicitationId);
        ajaxData.append('campo', campo);
        ajaxData.append('acao', acao);
        ajaxData.append('valor_original', valorOriginal);
        ajaxData.append('nonce', '<?= wp_create_nonce("avaliar_edit_reserva_nonce"); ?>');

        const ajaxDataObject = Object.fromEntries(ajaxData .entries());

        jQuery(function($) {
            $.ajax({
            url: themeLinks.ajaxUrl,
            type: 'POST',
            data: ajaxDataObject,
            success: async function(response) {
                console.log(response.data)

                const cell = document.getElementById(`box-field-${solicitationId}-${campo}`);
                if(cell) {
                    if(acao === 'aceitar') {
                        cell.innerHTML = `<span class="badge-status badge-aprovado">Aprovado: ${response.data.novo_valor}</span>`;
                    } else {
                        cell.innerHTML = `<span class="badge-status badge-rejeitado">Rejeitado</span> <br><small>${response.data.valor_original}</small>`;
                    }
                }
                
                const novo_status_solic = response.data.novo_status_solic;
                if(novo_status_solic === 'concluido'){
                    const actionsCell = document.getElementById(`actions-${solicitationId}`);
                    actionsCell.querySelector('.pending-solic').classList.add('d-none');
                    actionsCell.querySelector('.concluido-solic').classList.remove('d-none');
                }
            },
            error: function(error) {
                alert("Erro: " + error.data);
            }
            });
        })
    }

    function processarTudo(solicitationId, acao) {
        if(!confirm(`Tem certeza que deseja ${acao} TODAS as alterações desta solicitação?`)) return;

        const data = new FormData();
        data.append('action', 'processar_alteracao_tudo');
        data.append('solicitacao_id', solicitationId);
        data.append('acao', acao);
        data.append('nonce', '<?= wp_create_nonce("avaliar_edit_reserva_nonce"); ?>');

        fetch(ajaxurl, { method: 'POST', body: data })
        .then(response => response.json())
        .then(res => {
            if(res.success) {
                const row = document.getElementById(`row-solicitation-${solicitationId}`);
                if(row) {
                    row.style.transition = 'all 0.5s';
                    row.style.backgroundColor = acao === 'aceitar' ? '#d1e7dd' : '#f8d7da';
                    setTimeout(() => row.remove(), 600);
                }
            } else {
                alert('Erro: ' + res.data);
            }
        });
    }

    function checarConclusaoLinha(solicitationId) {
        const row = document.getElementById(`row-solicitation-${solicitationId}`);
        const pendentes = row.querySelectorAll('.diff-container');
        // Se não houver mais containers de diferença pendentes na linha, oculta a linha
        if(pendentes.length === 0) {
            setTimeout(() => {
                row.style.transition = 'all 0.5s';
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 500);
            }, 1000);
        }
    }
    </script>
    <?php
    }

    // Função Auxiliar para Renderização de Cada Célula (Compara Origem x Novo)
    function renderizar_campo_moderacao($solicitationId, $campo, $valorOriginal, $valorNovo, $statusCampo) {
        // Caso já tenha sido aprovado ou rejeitado individualmente
        if ($statusCampo === 'aprovado') {
            echo '<span class="badge-status badge-aprovado">Aprovado: ' . esc_html($valorNovo) . '</span>';
            return;
        }
        if ($statusCampo === 'rejeitado') {
            echo '<span class="badge-status badge-rejeitado">Rejeitado</span><br><small class="text-muted">' . esc_html($valorOriginal) . '</small>';
            return;
        }

        // Se o valor for igual ou o novo for vazio = Exibe valor normal
        if (empty($valorNovo) || $valorOriginal === $valorNovo) {
            echo '<span>' . esc_html($valorOriginal) . '</span>';
            return;
        }

        // Se o valor for diferente = Exibe container com destaque e botões dedicados
        ?>
        <div class="diff-container" id="box-field-<?= $solicitationId; ?>-<?= $campo; ?>">
            <div class="diff-val-original" title="Valor Atual">
                <small style="color:#666;">De:</small> <?= esc_html($valorOriginal); ?>
            </div>
            <div class="diff-val-novo" title="Novo Valor Solicitado">
                <small style="color:#666;">Para:</small> <?= esc_html($valorNovo); ?>
            </div>
            <div class="diff-actions">
                <button type="button" 
                        class="button button-small" 
                        style="color: #198754; border-color: #198754;"
                        onclick="processarCampo(<?= $solicitationId; ?>, '<?= $campo; ?>', 'aceitar', '<?= $valorOriginal; ?>')">
                    <span class="dashicons dashicons-yes"></span>
                </button>
                <button type="button" 
                        class="button button-small" 
                        style="color: #dc3545; border-color: #dc3545;"
                        onclick="processarCampo(<?= $solicitationId; ?>, '<?= $campo; ?>', 'rejeitar', '<?= $valorOriginal; ?>')">
                    <span class="dashicons dashicons-no"></span>
                </button>
            </div>
        </div>
        <?php
    }

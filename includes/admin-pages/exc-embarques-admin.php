<?php

add_action('woocommerce_product_data_panels', 'painel_exc_embarques');
function painel_exc_embarques()
{
    global $post;
    global $wpdb;

    $product = wc_get_product($post->ID);
    if (!$product) {
        return;
    }

    $old_embarques_meta = get_post_meta($product->get_id(), 'embarques', true);

    $nome_tabela = $wpdb->prefix . 'embarques';
    $embarques_db = $wpdb->get_results("SELECT * from $nome_tabela");
    $padroes_horarios_salvos = get_option('padroes_horarios');
    $ordem_dos_embarques = get_option('preset_ordem_embarques', []);

    // Obtém variações válidas se não for um rascunho automático
    $exc_variacoes = $product->get_status() !== 'auto-draft' && $product->is_type('variable') 
        ? $product->get_available_variations() 
        : [];

    // Mapeia a lista de variações ativas (ID e Data descritiva)
    $variacoes_list = [];
    $dias_exc = [];
    foreach ($exc_variacoes as $_var) {
        $dia_attr = $_var['attributes']['attribute_dia'] ?? '';
        $variacoes_list[] = [
            'id'  => $_var['variation_id'],
            'dia' => $dia_attr
        ];
        $dias_exc[] = $dia_attr;
    }

    // Reconstrói a matriz de dados a partir dos metadados de cada variação para alimentar a UI
    $ui_data = [];
    foreach ($variacoes_list as $v) {
        $v_id = $v['id'];
        $config_meta = get_post_meta($v_id, '_embarques_config', true);
        $config = $config_meta ? json_decode($config_meta, true) : [];

        foreach ($config as $emb) {
            $emb_id = $emb['embarque_id'];
            if (!isset($ui_data[$emb_id])) {
                $ui_data[$emb_id] = [
                    'ativo'    => true,
                    'taxa'     => $emb['taxa'] ?? 0,
                    'horarios' => []
                ];
            }

            foreach ($emb['horarios'] as $h) {
                $hora = $h['horario'];
                $found_index = -1;
                foreach ($ui_data[$emb_id]['horarios'] as $idx => $existing_h) {
                    if ($existing_h['horario'] === $hora) {
                        $found_index = $idx;
                        break;
                    }
                }

                if ($found_index === -1) {
                    $ui_data[$emb_id]['horarios'][] = [
                        'horario'         => $hora,
                        'disponibilidade' => [ $v_id => $h['disponivel'] ]
                    ];
                } else {
                    $ui_data[$emb_id]['horarios'][$found_index]['disponibilidade'][$v_id] = $h['disponivel'];
                }
            }
        }
    }
    ?>
    <div class="panel woocommerce_options_panel wc_metaboxes_wrapper hidden px-4" id="exc_embarques_meta">
        <div class="section-show" data-dias="<?= esc_attr(json_encode($dias_exc)) ?>">
            <dialog id="refHorarioModal">
                <p>Defina o horário de embarque no ponto</p>
                <p class="ref-nome-emb"></p>
                <input autofocus type="time">
                <button>Definir</button>
            </dialog>

            
            <p>Selecione os embarques da excursão</p>
            <div class="main-embarques-header">
                <div id="padraoSelector">
                    <?php if ($padroes_horarios_salvos) { ?>
                        <p>Selecione um padrão de horários</p>
                        <select name="padraoSelect" id="padraoSelect">
                            <option value="none" selected>Selecione...</option>
                            <?php foreach ($padroes_horarios_salvos as $_padrao) {
                                $nome_emb_ref = '';
                                foreach ($embarques_db as $_emb_db) {
                                    if ((int) $_emb_db->id == (int) $_padrao['referencia']) {
                                        $nome_emb_ref = $_emb_db->nome;
                                    }
                                }
                                ?>
                                <option data-ref="<?= esc_attr($nome_emb_ref) ?>" value="<?= esc_attr($_padrao['nome']) ?>" data-json='<?= json_encode([$_padrao], JSON_UNESCAPED_UNICODE) ?>'><?= esc_html($_padrao['nome']) ?></option>
                            <?php } ?>
                        </select>
                    <?php } ?>
                </div>
            </div>

            <ul class="main-embarques-list">
                <?php
                foreach ($ordem_dos_embarques as $_ordem) {
                    $embarque_db = array_filter($embarques_db, function ($_emb_db) use ($_ordem) {
                        return $_emb_db->id == $_ordem;
                    });
                    $embarque_db = array_values($embarque_db)[0] ?? null;
                    if (!$embarque_db) continue;

                    $has_meta = isset($ui_data[$embarque_db->id]);
                    $is_ativo = $has_meta ? 'ativo' : 'inativo';
                    $taxa_val = $has_meta ? $ui_data[$embarque_db->id]['taxa'] : 0;
                    $horarios_salvos = $has_meta ? $ui_data[$embarque_db->id]['horarios'] : [];
                    ?>
                    <li data-embarque-id="<?= esc_attr($embarque_db->id) ?>" data-status="<?= esc_attr($is_ativo) ?>" data-endereco="<?= esc_attr($embarque_db->endereco) ?>" data-referencia="<?= esc_attr($embarque_db->obs) ?>">
                        <div class="emb-item-head">
                            <p class="emb-title"><?= esc_html($embarque_db->nome) ?></p>
                            <div class="emb-ativo-check">
                                <span class="dashicons dashicons-yes-alt" data-embarque-id="<?= esc_attr($embarque_db->id) ?>"></span>
                            </div>
                        </div>
                        
                        <div class="emb-item-body">
                            <ul class="lista-horarios" data-embarque-id="<?= esc_attr($embarque_db->id) ?>">
                                <?php
                                if (!empty($horarios_salvos)) {
                                    $horariosIndex = 1;
                                    foreach ($horarios_salvos as $h_info) { 
                                        $current_hora = $h_info['horario'];
                                        ?>
                                        <li data-order="<?= $horariosIndex ?>">
                                            <div class="horario">
                                                <input type="time" data-order="<?= $horariosIndex ?>" value="<?= esc_attr($current_hora) ?>" onchange="salvaEmbarques()">
                                            </div>
                                            <div class="disponibilidade" data-embarque-id="<?= esc_attr($embarque_db->id) ?>" data-order="<?= $horariosIndex ?>">
                                                <?php foreach ($variacoes_list as $v) { 
                                                    $is_disp = isset($h_info['disponibilidade'][$v['id']]) ? $h_info['disponibilidade'][$v['id']] : false;
                                                    ?>
                                                    <label>
                                                        <input type="checkbox" 
                                                               <?= $is_disp ? 'checked' : '' ?> 
                                                               onchange="salvaEmbarques()" 
                                                               data-content="<?= esc_attr(substr($v['dia'], 0, -5)) ?>" 
                                                               data-variation-id="<?= esc_attr($v['id']) ?>" 
                                                               data-dia="<?= esc_attr($v['dia']) ?>">
                                                    </label>
                                                <?php } ?>
                                            </div>
                                            <div class="opcoes">
                                                <?php if ($horariosIndex > 1) { ?> 
                                                    <span onclick="excluirHorario(this.dataset.embarqueId, this.dataset.order)" class="dashicons dashicons-trash" data-embarque-id="<?= esc_attr($embarque_db->id) ?>" data-order="<?= $horariosIndex ?>"></span>
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <?php 
                                        $horariosIndex++;
                                    }
                                } else {
                                    // Layout padrão vazio (fallback)
                                    ?>
                                    <li data-order="1">
                                        <div class="horario">
                                            <input type="time" onchange="salvaEmbarques()" data-order="1" value="">
                                        </div>
                                        <div class="disponibilidade" data-embarque-id="<?= esc_attr($embarque_db->id) ?>" data-order="1">
                                            <?php foreach ($variacoes_list as $v) { ?>
                                                <label>
                                                    <input type="checkbox" 
                                                           checked 
                                                           onchange="salvaEmbarques()" 
                                                           data-content="<?= esc_attr(substr($v['dia'], 0, -5)) ?>" 
                                                           data-variation-id="<?= esc_attr($v['id']) ?>" 
                                                           data-dia="<?= esc_attr($v['dia']) ?>">
                                                </label>
                                            <?php } ?>
                                        </div>
                                        <div class="opcoes"></div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                            
                            <div class="emb-item-footer">
                                <span class="add-horario-btn" onclick="adicionarHorario(<?= esc_attr($embarque_db->id) ?>)">Adicionar horário</span>
                                <div class="switch taxa">
                                    <label>
                                        Adicionar taxa
                                        <input type="checkbox" <?= $taxa_val > 0 ? 'checked' : '' ?> data-embarque-id="<?= esc_attr($embarque_db->id) ?>" onchange="toggleTaxa(<?= esc_attr($embarque_db->id) ?>, this)">
                                        <span class="slider"></span>
                                    </label>
                                    <input type="number" onchange="salvaEmbarques()" class="<?= $taxa_val > 0 ? 'ativo' : '' ?>" value="<?= $taxa_val > 0 ? esc_attr($taxa_val) : '' ?>">
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
            </ul>

            <?php
            // Único metafield necessário para trafegar a árvore estruturada via post post-submit
            woocommerce_wp_hidden_input([
                'id'    => 'meta_embarques_data',
                'value' => ''
            ]);
            ?>
            
            <script>
                const embsLisHeads = document.querySelectorAll('ul.main-embarques-list > li .emb-item-head');
                embsLisHeads.forEach(_li => _li.addEventListener('click', ({target}) => cliqueHeaderEmbarque(target)));

                const padraoSelect = document.querySelector("#exc_embarques_meta select#padraoSelect");
                const setHorarioRefModal = document.querySelector('dialog#refHorarioModal');
                const closeModalBtn = document.querySelector('dialog#refHorarioModal button');

                function handleEnterKey(event){
                    if (event.key === 'Enter' || event.keyCode === 13) { 
                        event.preventDefault();
                        if(setHorarioRefModal.hasAttribute('open')){
                            closePadraoModal(setHorarioRefModal.querySelector('input[type="time"]'));
                        }
                    } 
                }

                function closePadraoModal(_e){
                    let refHour;
                    let padraoAtivoEmbarques;
                    
                    if(_e.dataset){
                        refHour = _e.value;
                        padraoAtivoEmbarques = JSON.parse(_e.dataset.embarques);
                    }else{
                        _e.preventDefault();
                        refHour = _e.target.parentElement.querySelector('input[type="time"]').value;
                        padraoAtivoEmbarques = JSON.parse(_e.target.parentElement.querySelector('input[type="time"]').dataset.embarques);
                    }
                    const refHourTimestamp = +getTimestampFromZero(refHour) + 270000000;

                    document.querySelectorAll('ul.main-embarques-list > li').forEach(_li => {
                        const _liTimeInput = _li.querySelector('ul.lista-horarios > li:first-child input[type="time"]');
                        const _padrao = padraoAtivoEmbarques.flatMap(_padrao_emb => _padrao_emb.embarque == _li.dataset.embarqueId ? _padrao_emb : []);

                        if(_padrao.length > 0){
                            let diffHourTimestamp = Number(_padrao[0].timestamp);
                            diffHourTimestamp = _padrao[0].rel == 'minus' ? diffHourTimestamp * (-1) : diffHourTimestamp;

                            let timestampToConvertToHour = refHourTimestamp + diffHourTimestamp;
                            timestampToConvertToHour = new Date(timestampToConvertToHour);

                            let _hh = timestampToConvertToHour.getHours().toString().padStart(2, '0');
                            let _mm = timestampToConvertToHour.getMinutes().toString().padStart(2, '0');

                            _liTimeInput.setAttribute('value', _hh + ":" + _mm);
                            _liTimeInput.value = _hh + ":" + _mm;
                            _li.dataset.status = 'ativo';
                        }
                    });
                    salvaEmbarques();
                    setHorarioRefModal.close();
                }

                padraoSelect.addEventListener('change', ({target}) => {
                    if(target.value === 'none'){
                        document.querySelectorAll('ul.main-embarques-list > li').forEach(_li => {
                            _li.dataset.status = 'inativo';
                            _li.querySelectorAll('ul.lista-horarios > li').forEach((_li_hor, _ind) => _ind > 0 ? _li_hor.remove() : null);
                            _li.querySelector('input[type="time"]').value = null;
                        });
                    }else{
                        const padrao_array = JSON.parse(target.options[target.options.selectedIndex].dataset.json)[0];
                        padrao_array.embarques.push({embarque: padrao_array.referencia, rel: 'minus', timestamp: '0000000'});
                        setHorarioRefModal.querySelector('.ref-nome-emb').innerText = target.options[target.options.selectedIndex].dataset.ref;
                        setHorarioRefModal.querySelector('input[type="time"]').dataset.embarques = JSON.stringify(padrao_array.embarques);
                        document.addEventListener('keydown', handleEnterKey);
                        setHorarioRefModal.showModal();
                    }
                });

                closeModalBtn.addEventListener('click', closePadraoModal);

                function adicionarHorario(_embId){
                    const listaHorariosRef = document.querySelector(`ul.main-embarques-list > li[data-embarque-id='${_embId}'] ul.lista-horarios`);
                    let cloneLi = listaHorariosRef.children[0].cloneNode(true);
                    let order = +listaHorariosRef.children[listaHorariosRef.children.length - 1].dataset.order + 1;
                    
                    cloneLi.dataset.order = order;
                    cloneLi.querySelector('input[type="time"]').value = '';
                    cloneLi.querySelector('input[type="time"]').dataset.order = order;
                    cloneLi.querySelectorAll('.disponibilidade input').forEach(_inp => _inp.checked = true);
                    
                    const opcoesDiv = cloneLi.querySelector('.opcoes');
                    opcoesDiv.innerHTML = '';
                    
                    let spanExcluir = document.createElement('span');
                    spanExcluir.classList.add("dashicons", "dashicons-trash");
                    spanExcluir.dataset.order = order;
                    spanExcluir.dataset.embarqueId = _embId;
                    spanExcluir.addEventListener('click', () => excluirHorario(_embId, order));
                    
                    opcoesDiv.appendChild(spanExcluir);
                    listaHorariosRef.appendChild(cloneLi);
                    salvaEmbarques();
                }

                function excluirHorario(_embId, _order){
                    const listaHorariosRef = document.querySelector(`ul.lista-horarios[data-embarque-id='${_embId}']`);
                    if(window.confirm('Excluir esse horário?')){
                        listaHorariosRef.querySelector(`li[data-order="${_order}"]`).remove();
                    }
                    salvaEmbarques();
                }

                function toggleTaxa(_embId, _el){
                    const embLiRef = document.querySelector(`ul.main-embarques-list > li[data-embarque-id='${_embId}']`);
                    const taxaNumberInput = embLiRef.querySelector('.switch.taxa input[type="number"]');
                    if(_el.checked){
                        taxaNumberInput.classList.add('ativo');
                        taxaNumberInput.focus();
                    }else{
                        taxaNumberInput.classList.remove('ativo');
                    }
                    salvaEmbarques();
                }

                function cliqueHeaderEmbarque(_target){
                    const embId = _target.dataset.embarqueId;
                    if(_target.classList.contains('dashicons')){
                        const _li = document.querySelector(`ul.main-embarques-list > li[data-embarque-id="${embId}"]`);
                        _li.dataset.status = _li.dataset.status === 'ativo' ? 'inativo' : 'ativo';
                        salvaEmbarques();
                    }
                }

                // JS Estrutural focado em mapear por Variação ID
                function salvaEmbarques(_e = null){
                    if(_e) _e.preventDefault();
                    
                    const embarquesAtivos = Array.from(document.querySelectorAll('.main-embarques-list > li[data-status="ativo"]'));
                    const dataPorVariacao = {};

                    embarquesAtivos.forEach(_emb => {
                        const embId = +_emb.dataset.embarqueId;
                        const taxaCheckbox = _emb.querySelector('.switch.taxa input[type="checkbox"]');
                        const taxaInput = _emb.querySelector('.switch.taxa input[type="number"]');
                        const taxaVal = (taxaCheckbox && taxaCheckbox.checked) ? +taxaInput.value : 0;

                        _emb.querySelectorAll('ul.lista-horarios > li').forEach(horarioLi => {
                            const inputHora = horarioLi.querySelector('input[type="time"]');
                            if(inputHora && inputHora.value !== ''){
                                const horaStr = inputHora.value;

                                const cbVariacoes = horarioLi.querySelectorAll(`.disponibilidade input[type="checkbox"]`);
                                cbVariacoes.forEach(cb => {
                                    const varId = cb.dataset.variationId;
                                    const isChecked = cb.checked;

                                    if (!dataPorVariacao[varId]) {
                                        dataPorVariacao[varId] = [];
                                    }

                                    let embConfig = dataPorVariacao[varId].find(item => item.embarque_id === embId);
                                    if (!embConfig) {
                                        embConfig = {
                                            embarque_id: embId,
                                            taxa: taxaVal,
                                            horarios: []
                                        };
                                        dataPorVariacao[varId].push(embConfig);
                                    }

                                    embConfig.horarios.push({
                                        horario: horaStr,
                                        disponivel: isChecked
                                    });
                                });
                            }
                        });
                    });
console.log(dataPorVariacao);
                    const hiddenInput = document.querySelector('input#meta_embarques_data');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(dataPorVariacao);
                    }
                }

                // Executa uma varredura inicial para garantir que o input oculto seja populado no carregamento
                document.addEventListener("DOMContentLoaded", () => {
                    salvaEmbarques();
                });
            </script>   
        </div>
        
        <div class="section-hide">
            <p>Defina primeiro as datas nas variações!</p>
        </div>
    </div>
    <?php
}
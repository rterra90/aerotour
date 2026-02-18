<?php
add_action('woocommerce_product_data_panels', 'painel_passageiros');
function painel_passageiros()
{
  global $post;
  global $wpdb;
  // update_post_meta($post -> ID, 'passageiros', '');
  // print_r(get_post_meta($post -> ID, 'exc_embarques', true));
?>

  <div class="panel woocommerce_options_panel wc_metaboxes_wrapper hidden px-4" id="passageiros_meta">

    <div class="passageiros_meta wc-metaboxes ui-sortable">
      <?php
      if ($post->post_title === '') echo '<p>Lista de passageiros ainda não disponível. Termine de configurar a nova excursão!</p>';
      else {
        $variacoes = wc_get_product($post->ID)->get_available_variations();

        foreach ($variacoes as $variacao) {
          $variation_id = $variacao['variation_id'];
          $passageiros_var = $wpdb->get_results("SELECT * FROM aer_reservas WHERE variation_id = $variation_id");
          $variacao_linhas_meta = get_post_meta($variation_id, 'tem_linhas', true);
          $variacao_linhas_qtd = is_numeric($variacao_linhas_meta) ? (int)$variacao_linhas_meta : 1;
          $link_grupo_wpp = get_post_meta($variacao['variation_id'], 'link_wpp', true);

          $vendas_pdv = array();
          foreach ($passageiros_var as $pv) {
            if (isset($pv->pdv)) {
              $vendas_pdv[$pv->pdv] = isset($vendas_pdv[$pv->pdv]) ? $vendas_pdv[$pv->pdv] + 1 : 1;
            }
          }
      ?>

          <div data-taxonomy class="accordion-item wc-metabox postbox" data-variacao-id="<?= $variacao['variation_id']; ?>" rel="<?php //$key; 
                                                                                                                                  ?>">
            <span class="accordion-header">
              <?= $variacao['attributes']['attribute_dia']; ?> &nbsp; &nbsp;
              <i style="opacity: .7"><?= sizeof($passageiros_var); ?> passageiros</i>

              <!-- controle -->
              <?php
              if ($variacao_linhas_qtd > 1) {
              ?>
                <i style="opacity: .7"> | <?= $variacao_linhas_qtd; ?> linhas</i>
              <?php
              }
              ?>
              <span class="dashicons dashicons-admin-generic" style="float:right; z-index: 1000"></span>
            </span>

            <div class="lista-passageiros-wrapper">
              <div class="passageiros-admin-config">

                <!-- GERENCIAR LINHAS -->
                <div class="linhas">
                  <label class="switch">
                    <input type="checkbox" class="<?= $variacao_linhas_qtd > 1 ? 'ativado' : ''; ?>" data-excursao-id="<?= $post->ID; ?>" data-variacao-id="<?= $variacao['variation_id']; ?>" <?= $variacao_linhas_qtd > 1 ? 'checked' : '' ?>>
                    <span class="slider round"></span>
                    <span>Gerar linhas</span>
                  </label>
                  <?php include 'includes/admin-pages/admin-panel-passageiros-linhas-config.php'; ?>

                  <?php
                  /* condiçao para exibir o botão 'atualizar' - melhorar isso */
                  if ($variacao_linhas_qtd > 1) {
                  ?>
                    <button type="button" class="button button-primary exc-var-config-submit" onclick="atualizarDefinicoesVariacao(<?= $post->ID; ?>, <?= $variacao['variation_id']; ?>, this)">Atualizar</button>
                  <?php
                  }
                  ?>
                </div>

                <div>
                  <?php
                  woocommerce_wp_checkbox(
                    array(
                      'id'      => 'meta_encerrar_vendas_' . $variacao['variation_id'],
                      'class'   => 'meta_encerrar_vendas_var_input',
                      'value'   => get_post_meta($variacao['variation_id'], 'encerrar_vendas', true),
                      'label'   => 'Encerrar vendas',
                    )
                  );
                  ?>
                  <input type="checkbox" value="no" style="display:none" id="meta_encerrar_vendas_<?= $variacao['variation_id'] ?>_p" name="meta_encerrar_vendas_<?= $variacao['variation_id']; ?>" <?= get_post_meta($variacao['variation_id'], 'encerrar_vendas', true) !== 'yes' ? 'checked' : ''; ?>>
                </div>

                <div class="wpp-link-container">
                  <?php
                  woocommerce_wp_text_input(
                    array(
                      'id'        => 'wpp-link-' . $variacao['variation_id'],
                      'name'      => 'meta_link_wpp_' . $variacao['variation_id'],
                      'value'     => $link_grupo_wpp,
                      'label'     => "Link do grupo no WhatsApp",
                      'data_type' => 'url',
                    )
                  );
                  ?>
                  <div class="email-wpp-link-container">
                    <span class="email-link-wpp-btn" onclick="handleEmailWppDialog('<?= $variacao['variation_id']; ?>')">Notificar passageiros</span>
                    <dialog id="email-wpp-<?= $variacao['variation_id'] ?>">
                      <b>Atenção!</b>
                      <p>Essa ação eviará um e-mail com o link de acesso ao grupo no WhatsApp para todos os passageiros dessa excursão que têm conta no site.</p>
                      <p>Link: <span><?= $link_grupo_wpp; ?></span></p>
                      <span class="confirma-envio-email" data-variation-id="<?= $variacao['variation_id']; ?>" data-link="<?= $link_grupo_wpp; ?>" onclick="enviaEmailLinkWpp(this)">Clique aqui para continuar >></span>

                      <div class="email-results">
                        <p class="success"></p>
                        <p class="error"></p>
                      </div>

                      <span class="closeModalBtn" onclick="handleEmailWppDialog('<?= $variacao['variation_id']; ?>')">Fechar</span>
                    </dialog>
                  </div>

                </div>



              </div>
              <div class="vendas_pdv_variacao">
                <?php
                foreach ($vendas_pdv as $pdv => $qtd) {
                ?>
                  <span class="pdv_count"><b><?= $qtd; ?></b><i><?= str_replace('_', ' ', $pdv) ?></i></span>
                <?php
                }
                ?>
              </div>
              <div class="passageiros">
                <?php
                if ($variacao_linhas_qtd > 1) {
                ?>
                  <nav class="linhas-nav">
                    <li class="active" data-linha="todos" onclick="handleListasPassageirosVar(<?= $variacao['variation_id'] ?>, 'todos')">TODOS</li>
                    <?php

                    for ($i = 1; $i <= $variacao_linhas_qtd; $i++) {
                    ?>
                      <li data-variacao-id="<?= $variacao['variation_id']; ?>" data-linha="linha_<?= $i; ?>" onclick="handleListasPassageirosVar(<?= $variacao['variation_id'] ?>, 'linha_<?= $i; ?>')">LINHA <?= $i; ?></li>
                    <?php
                    }

                    ?>
                  </nav>
                  <!-- Containers de passageiros de cada linha e geral -->
                  <?php

                  for ($i = 1; $i <= $variacao_linhas_qtd; $i++) {
                    $passageiros_linha = array();
                    foreach ($passageiros_var as $pl) {
                      if (isset($pl->linha) && $pl->linha === 'linha_' . $i) array_push($passageiros_linha, $pl);
                    }
                  ?>
                    <div class="passageiros-linha d-none" data-linha="<?= 'linha_' . $i; ?>">

                      <!-- Detalhes da linha -->
                      <div class="detalhes-linha linha-<?= $variacao['variation_id']; ?>">
                        <p>Total: <span class="total_linha" data-variacao-id="<?= $variacao['variation_id']; ?>" data-dia="<?= str_replace('/', '_', $variacao['attributes']['attribute_dia']); ?>" data-react="obj_passageiros" data-linha="linha_<?= $i; ?>"></span></p>
                      </div>
                      <div class="passageiros_linha" data-react="obj_passageiros" data-linha="linha_<?= $i; ?>" data-variacao-id="<?= $variacao['variation_id']; ?>"></div>
                    </div>
                <?php
                  }
                }
                ?>

                <!-- Lista geral de passageiros da variação -->
                <div class="passageiros-linha" data-linha="todos">
                  <?php
                  if (sizeof($passageiros_var) > 0) {
                    foreach ($passageiros_var as $index => $passageiro) {
                  ?>
                      <li data-cpf="<?= $passageiro->cpf; ?>" data-status="<?= $passageiro->status; ?>">
                        <?php

                        if ($variacao_linhas_qtd > 1) {
                        ?>
                          <div style="width: 56px" class="geral-linha">
                            <select name="linha" class="passageiro-linha" data-excursao-id="<?= $post->ID; ?>" data-variacao-id="<?= $variacao['variation_id']; ?>" onchange="defineLinhaPassageiro()">
                              <option value="none" <?= isset($passageiro->linha) ? '' : 'selected'; ?>>-</option>
                              <?php
                              for ($i = 1; $i <= $variacao_linhas_qtd; $i++) {
                              ?>
                                <option value="linha_<?= $i; ?>" <?= isset($passageiro->linha) && $passageiro->linha === "linha_" . $i ? 'selected' : ''; ?>><?= $i; ?></option>
                              <?php
                              }
                              ?>
                            </select>
                          </div>
                        <?php
                        }




                        ?>
                        <div style="flex-grow: 1" class="geral-nome"><?= unicode_filter($passageiro->p_nome); ?></div>
                        <div style="width: 120px" class="geral-telefone"><?= $passageiro->p_telefone; ?></div>
                        <div style="width: 190px" class="geral-embarque"><?= gettype($passageiro->embarque) !== 'array' ? unicode_filter(explode('(', $passageiro->embarque)[0]) : 'null'; ?></div>
                        <?php
                        if (isset($passageiro->pdv)) {
                        ?>
                          <div class="pdv"><span class="dashicons dashicons-store"></span><span class="pdv-tooltip"><?= $passageiro->pdv; ?></span></div>
                        <?php
                        }

                        ?>

                      </li>
                  <?php
                    }
                  } else {
                    echo '<p>Nenhum passageiro nesta excursão por enquanto...</p>';
                  }

                  ?>
                </div>
                <!-- FimLista geral de passageiros da variação -->

                <!-- Fim Containers de passageiros de cada linha e geral -->


              </div>
            </div>
          </div>
      <?php
        }
      }
      ?>
    </div>
    <script>
      const accordionHeader = document.querySelectorAll('.passageiros_meta span.accordion-header');
      accordionHeader.forEach(item => item.addEventListener('click', (a) => {
        const lista = a.currentTarget.parentElement.querySelector('.lista-passageiros-wrapper');
        const iconeConfig = item.querySelector('.dashicons-admin-generic');
        if (lista.classList.contains('open')) {
          iconeConfig.removeEventListener('click', configurarExcursao);
          a.currentTarget.classList.remove('open');
          lista.classList.remove('open');
        } else {
          iconeConfig.addEventListener('click', configurarExcursao);
          a.currentTarget.classList.add('open');
          lista.classList.add('open');
        }
      }))

      /* Abre e fecha o container de opções da lista de passageiros */
      function configurarExcursao(e) {
        e.stopPropagation()
        const excursaoConfigBox = e.currentTarget.parentElement.parentElement.querySelector('.passageiros-admin-config');

        excursaoConfigBox.classList.contains('open') ? e.currentTarget.classList.remove('active') : e.currentTarget.classList.add('active');

        const switcherInput = excursaoConfigBox.querySelector('.switch input[type="checkbox"]');
        if (excursaoConfigBox.classList.contains('open')) switcherInput.removeEventListener('change', toggleLinhasAjax);
        else switcherInput.addEventListener('change', toggleLinhasAjax);
        excursaoConfigBox.classList.toggle('open');
      }

      /* Define linha do passageiro indivudual - ajax request */
      function defineLinhaPassageiro() {
        const excursao_id = event.currentTarget.dataset.excursaoId;
        const variacao_id = event.currentTarget.dataset.variacaoId;
        const linha = event.currentTarget.value;
        const passageiro_ref = event.currentTarget.parentElement.parentElement.dataset.cpf;
        const selectElement = event.currentTarget;

        selectElement.setAttribute('disabled', '');

        jQuery(function($) {
          $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
              'action': 'define_linha_passageiro',
              'variacao_id': variacao_id,
              'linha': linha,
              'passageiro_ref': passageiro_ref,
            },
            success: async function(response) {
              selectElement.removeAttribute('disabled');
              updateReactiveValues('obj_passageiros', response.data);
            },
            error: function(error) {
              console.log('response error:  ' + error);
            }
          });
        })
      }

      /* CLIQUE NO SWITCH DE LINHAS - ajax request */
      function toggleLinhasAjax(event) {
        const excursao_id = event.currentTarget.dataset.excursaoId;
        const variacao_id = event.currentTarget.dataset.variacaoId;
        const switcher = document.querySelector(`input[type="checkbox"][data-variacao-id="${variacao_id}"]`);
        switcher.classList.toggle('ativado');

        jQuery(function($) {
          $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
              'action': 'toggle_linhas',
              // 'excursao_id': excursao_id,
              'variacao_id': variacao_id,
            },
            success: async function(response) {
              location.reload();
            },
            error: function(error) {
              console.log('response error:  ' + error);
            }
          });
        })
      }

      /* ENVIA EMAIL LINK WPP */
      function enviaEmailLinkWpp(button) {
        if (button.innerText === 'Clique aqui para continuar >>') {
          // //   const emails = JSON.parse(button.dataset.emails);
          // //   const excName = button.dataset.excName ? button.dataset.excName : 'Evento teste';
          // //   const excData = button.dataset.excData ? button.dataset.excData : '01/01/1999';
          // //   const _link = button.dataset.link ? button.dataset.link : 'https://linkteste';
          const variationId = button.dataset.variationId;
          button.innerText = "Aguarde..."
          jQuery(function($) {
            $.ajax({
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              type: 'GET',
              data: {
                'action': 'send_email',
                'template': 'convite-grupo-wpp',
                'variation_id': variationId,
              },
              success: async function({
                success,
                data
              }) {
                const containerResultados = button.closest('dialog').querySelector('.email-results');

                if (success) {
                  const envioSucesso = data.filter((_result) => _result.resultado === true);
                  const envioErro = data.filter((_result) => _result.resultado === false);
                  containerResultados.children[0].innerText = `${envioSucesso.length} e-mails enviados com sucesso`;
                  containerResultados.children[1].innerText = `${envioErro.length} falhas no envio`;
                } else {
                  containerResultados.children[1].innerText = `Erro na solicitação. Nenhum e-mail foi enviado`;
                }
                button.remove();
              },
              error: function(error) {
                console.log('response error:  ' + error);
              }
            });
          })
        }
      }


      document.querySelectorAll('.meta_encerrar_vendas_var_input').forEach(inp => inp.addEventListener('change', ({
        target
      }) => {
        if (target.checked) document.querySelector(`#${target.id}_p`).checked = false;
        else document.querySelector(`#${target.id}_p`).checked = true;
      }))

      function handleEmailWppDialog(_var_id) {
        const dialogElement = document.querySelector(`#email-wpp-${_var_id}`);
        if (dialogElement.open) dialogElement.close();
        else {
          dialogElement.showModal();
          dialogElement.classList.add('loading')
          const enviarEmailBtn = document.querySelector('.confirma-envio-email');
          enviarEmailBtn.dataset.variationId = _var_id;
          jQuery(function($) {
            $.ajax({
              url: '<?php echo admin_url('admin-ajax.php'); ?>',
              type: 'GET',
              data: {
                'action': 'get_reservas',
                'variation_id': _var_id,
              },
              success: async function(response) {
                const exc_name = Object.values(response.data[1])[0][0];
                const exc_data = Object.values(response.data[1])[0][1];
                const _user_ids = response.data[0].flatMap((_r) => {
                  if (_r.user_id != '0') { //se o usuário possui conta no site
                    if (_r.status !== 'cancel') return +_r.user_id; //se a reserva não está 'cancel', retorna o email
                  }
                  return []; //se não possui conta no site
                });
                // console.log(_user_ids);
                jQuery(function($) {
                  $.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'GET',
                    data: {
                      action: 'get_customers',
                      param: 'e-mail',
                      ids: _user_ids //[1, 2, 3]
                    },
                    success: async function(_resp) {
                      dialogElement.classList.remove('loading');
                      enviarEmailBtn.dataset.emails = JSON.stringify(_resp.data);
                      enviarEmailBtn.dataset.excName = exc_name;
                      enviarEmailBtn.dataset.excData = exc_data;
                    },
                    error: function(_error) {
                      console.log('response error 2:  ' + _error);
                    }
                  })
                })

              },
              error: function(error) {
                console.log('response error:  ' + error);
              }
            });
          })

        }
      }


      const containersEmailLinkWpp = document.querySelectorAll('.email-wpp-link-container');
      if (containersEmailLinkWpp) {
        containersEmailLinkWpp.forEach(_e => toggleContainer(_e))

        function toggleContainer(__e) {
          const wppInput = __e.parentElement.querySelector('.wc_input_url');
          wppInput.addEventListener('change', ({
            target
          }) => {
            __e.style.display = target.value.length > 0 ? 'inline-block' : 'none';
          })
        }
      }
    </script>
  </div>
<?php

}

?>
<?php
$embarques_detalhes = $args['embarques_detalhes'];
$var_embarque_settings = $args['embarques_por_variacao'];

// Funcionalidades Específicas do Rock in Rio
$is_rock_in_rio = has_term('rock-in-rio', 'product_cat');
$cidades_dia_anterior = $is_rock_in_rio ?
  array('Campinas', 'Limeira', 'Americana', 'Sumaré', 'Itu', 'Salto', 'Indaiatuba') : null;

function agruparHorariosPorDia(array $horarios_do_embarque): array
{
    $agrupado = [];
    foreach ($horarios_do_embarque as $item) {
        $dia = $item['dia'];
        if (!isset($agrupado[$dia])) {
            $agrupado[$dia] = [
                'dia' => $dia,
                'horarios' => []
            ];
        }

        $agrupado[$dia]['horarios'][] = [
            'horario' => $item['horario'],
            'disponivel' => $item['disponivel']
        ];
    }

    return array_values($agrupado);
}
?>
<div id="tab2" class="tab-content tab-embarques">
  <div class="embarque-container">

    <?php if ($embarques_detalhes && is_array($embarques_detalhes) && !empty($embarques_detalhes)): ?>
      
      <div class="filtro-header">
        <span>Filtre por <br />cidade:</span>
        <div class="filtro-wrapper">
          <button class="scroll-btn left" id="scrollLeft">&#9664;</button>
          <div class="filtro-scroll" id="filtroCidades">
            <button class="filtro-btn active" data-cidade="todas">Todas</button>
            <?php
            $cidades = array_unique(
              array_map(function ($_emb) {
                return strtolower(
                  trim(explode(' - ', $_emb->nome)[0])
                );
              }, $embarques_detalhes)
            );
            sort($cidades);

            foreach ($cidades as $cidade) { ?>
              <button class="filtro-btn" data-cidade="<?= $cidade ?>"><?= ucfirst($cidade) ?></button>
            <?php } ?>
          </div>
          <button class="scroll-btn right" id="scrollRight">&#9654;</button>
        </div>
      </div>

<?php if ($is_rock_in_rio): ?>
  <div class="rir-notice-box">
    <div class="rir-notice-icon">
      <i class="bi bi-exclamation-triangle-fill"></i>
    </div>
    <div class="rir-notice-content">
      <strong>Atenção com o Horário:</strong>
      <p>Os embarques se iniciam na <u>noite do dia anterior</u> à data escolhida para o festival. Verifique atentamente o horário de cada ponto abaixo para não perder o ônibus!</p>
    </div>
  </div>
<?php endif; ?>

      <div class="lista-embarque" id="listaEmbarque">
        <?php
        foreach ($embarques_detalhes as $i => $embarque) {
          $horarios_do_embarque = array();
          $embarque_id = $embarque->id;
          
          foreach ($var_embarque_settings as $emb_var) {
            $var_id = $emb_var['variation_id'];
            $var_dia = $emb_var['variation_dia'];
            $var_embarques = $emb_var['variation_embarques'];

            foreach ($var_embarques as $var_emb) {
              if ($var_emb['embarque_id'] == $embarque_id) {
                foreach ($var_emb['horarios'] as $horario_emb) {
                  array_push($horarios_do_embarque, array('dia' => $var_dia, ...$horario_emb));
                }
              }
            }
          }

          $exibe_horarios_inativos = true;
          $horarios_unicos = array_unique(array_map(function ($h_emb) {
            return $h_emb['horario'];
          }, $horarios_do_embarque));

          $set_horarios_iguais_nos_embarques = array_filter(
            agruparHorariosPorDia($horarios_do_embarque),
            function ($h_emb) use ($horarios_unicos, $exibe_horarios_inativos) {
              if ($exibe_horarios_inativos) {
                return count($h_emb['horarios']) == count($horarios_unicos);
              } else {
                $horarios_disponiveis = array_filter($h_emb['horarios'], function ($h) {
                  return $h['disponivel'];
                });
                if (count($horarios_disponiveis) !== count($h_emb['horarios'])) {
                  return false;
                }
              }
            }
          );
          
          $horarios_iguais_nos_embarques = count($set_horarios_iguais_nos_embarques) === count(agruparHorariosPorDia($horarios_do_embarque));
        ?>
          <div class="item-embarque" data-cidade="<?= strtolower(trim(explode(' - ', $embarque->nome)[0])) ?>">
            <div class="item-embarque-info">
              <p class="nome-embarque"><?= $embarque->nome ?></p>
              <span>Endereço:</span>
              <p><?= $embarque->endereco ?></p>
              <span>Referência para embarque:</span>
              <p><?= $embarque->obs ?></p>
              
              <?php if (count($horarios_unicos) > 1 && !$horarios_iguais_nos_embarques): ?>
                <div class="mapa"><a href="<?= $embarque->link_mapa ?>" target="_blank">Ver no mapa</a></div>
              <?php endif; ?>
            </div>
            
            <div class="detalhes">
              <div class="horario">
                <?php
                if (count($horarios_unicos) === 1) { 
                  echo $horarios_unicos[0] . '</p>';
                } elseif (count($horarios_unicos) > 1 && $horarios_iguais_nos_embarques) { 
                  ?>
                  <div class="dia-horarios-area">
                    <p class="area-header title">Horários</p>
                    <?php foreach ($horarios_unicos as $h_emb) { echo '<span>' . $h_emb . '</span>'; } ?>
                  </div>
                  <?php
                } else { 
                  ?> 
                  <p class="area-header title">Horários</p>
                  <div class="dia-horarios-inner">
                    <?php
                    $dias_agrupados = [];
                    $dados = agruparHorariosPorDia($horarios_do_embarque);

                    foreach ($dados as $dia) {
                      $horarios_exibidos = array_filter(
                        $dia['horarios'],
                        fn($h) => $exibe_horarios_inativos || $h['disponivel']
                      );
                      
                      $assinatura = md5(json_encode($horarios_exibidos));
                      if (!isset($dias_agrupados[$assinatura])) {
                        $dias_agrupados[$assinatura] = [
                          'dias' => [],
                          'horarios' => $horarios_exibidos,
                        ];
                      }
                      $dias_agrupados[$assinatura]['dias'][] = $dia['dia'];
                    }

                    foreach ($dias_agrupados as $grupo) : ?>
                      <div class="dia-horarios-area">
                        <p class="area-header">
                          <?php
                          $dias = array_map(fn($d) => substr($d, 0, -5), $grupo['dias']);
                          echo count($dias) > 1 ? 'Dias ' . implode(' e ', $dias) : 'Dia ' . $dias[0];
                          ?>
                        </p>
                        <?php foreach ($grupo['horarios'] as $h_emb) : ?>
                          <span><?= $h_emb['horario']; ?></span>
                        <?php endforeach; ?>
                      </div>
                    <?php endforeach; ?>
                  </div>
                  <?php
                }
                ?>
              </div>

              <?php 
              if ($is_rock_in_rio) {
                // Adaptação para ler do objeto ao invés do array antigo
                $current_cidade = trim(explode(' - ', $embarque->nome)[0]);
                if (in_array($current_cidade, $cidades_dia_anterior)) {
                  ?>
                  <span class="badge badge-dia-anterior mt-2">do dia anterior</span>
                  <?php
                }
              } 
              ?>

              <?php if (count($horarios_unicos) === 1 || $horarios_iguais_nos_embarques): ?>
                <div class="mapa mt-3"><a href="<?= $embarque->link_mapa ?>" target="_blank">Ver no mapa</a></div>
              <?php endif; ?>
            </div>
          </div>

        <?php } ?>
        <div class="mostrar-tudo-btn d-none" data-cidade="todas">Mostrar tudo</div>
      </div>
    
    <?php else: ?>
      <p class="text-center">Nenhum local de embarque cadastrado para esta excursão.</p>
    <?php endif; ?>
  </div>
</div>

<style>
  .horario > p {
    margin-bottom: 0px!important;
  }
  /* ==========================================================================
   CAIXA DE AVISO ESPECIAL - ROCK IN RIO (ESTILO AEROTOUR)
   ========================================================================== */
.rir-notice-box {
    display: flex;
    align-items: flex-start;
    background-color: #fffbeb !important; /* Fundo amarelo pastel bem suave */
    border: 1px solid #fef08a !important; /* Borda sutil amarela */
    border-left: 5px solid #eab308 !important; /* Destaque lateral no tom dourado da badge */
    padding: .8rem !important;
    margin-bottom: 1rem !important;
    border-radius: 12px !important;
    box-shadow: 0 4px 15px rgba(234, 179, 8, 0.06) !important; /* Sombra dourada cirúrgica */
}

/* Espaçamento e cor do ícone do Bootstrap */
.rir-notice-box .rir-notice-icon {
    margin-right: 1rem;
    color: #eab308 !important; /* Dourado */
    font-size: 1.4rem;
    line-height: 1;
    display: flex;
    align-items: center;
    padding-top: 2px;
}

/* Conteúdo de texto */
.rir-notice-box .rir-notice-content {
    font-size: 0.85rem;
    line-height: 1.2;
    color: #1e293b !important; /* Azul escuro/grafite legível */
}

.rir-notice-box .rir-notice-content strong {
    color: #0f172a !important; /* Destaque do título em quase preto */
    font-weight: 700;
    display: block;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    margin-bottom: .2rem
}

.rir-notice-box .rir-notice-content p {
    margin: 0 !important;
}

.rir-notice-box .rir-notice-content u {
    font-weight: 600;
    text-decoration-color: #eab308;
    text-decoration-thickness: 2px;
}
</style>
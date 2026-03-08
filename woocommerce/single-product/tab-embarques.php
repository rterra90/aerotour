<!-- TAB CONTENT EMBARQUES -->
<?php
$exc_embarques = $args['exc_embarques'];
$is_rock_in_rio = has_term('rock-in-rio', 'product_cat');
$cidades_dia_anterior = $is_rock_in_rio ? array('Campinas', 'Limeira', 'Americana', 'Sumaré', 'Itu', 'Salto', 'Indaiatuba') : null;
?>
<div id="tab2" class="tab-content tab-embarques">
  <div class="embarque-container">
    <div class="filtro-header">
      <span>Filtre por <br />cidade:</span>
      <div class="filtro-wrapper">
        <button class="scroll-btn left" id="scrollLeft">&#9664;</button>
        <div class="filtro-scroll" id="filtroCidades">
          <button class="filtro-btn active" data-cidade="todas">Todas</button>
          <?php
          //iterar $excursao['embarques'], obter a string $embarque['nome'], dividir essa string em ' - ', retornar o primeiro termo, armazenar em uma array única e ordenar em ordem alafabetica
          $cidades = array_unique(
            array_map(function ($_emb) {
              return strtolower(
                trim(explode(' - ', $_emb['nome'])[0])
              );
            }, $exc_embarques)
          );
          sort($cidades);

          foreach ($cidades as $cidade) { ?>
            <button class="filtro-btn" data-cidade="<?= $cidade ?>"><?= ucfirst(
                                                                      $cidade
                                                                    ) ?></button>


          <?php }
          ?>
        </div>
        <button class="scroll-btn right" id="scrollRight">&#9654;</button>
      </div>
    </div>

    <?php
    if ($is_rock_in_rio) {
    ?>
      <div class="rir-notice-box">
        <div class="rir-notice-icon">
          <i class="dashicons dashicons-warning"></i>
        </div>
        <div class="rir-notice-content">
          <strong>Atenção:</strong>
          <p>Os embarques se iniciam na <u>noite do dia anterior</u> à data escolhida do festival. Verifique atentamente o horário de cada ponto abaixo.</p>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="lista-embarque" id="listaEmbarque">
      <?php foreach ($exc_embarques as $i => $embarque) {
        $horarios_simples = array_unique(
          array_map(function ($_op) {
            return $_op['horario'];
          }, $embarque['horarios'])
        );
        // o single product antigo tem funções para lidar com múltiplos horários
      ?>
        <div class="item-embarque" data-cidade="<?= strtolower(
                                                  trim(explode(' - ', $embarque['nome'])[0])
                                                ) ?>">
          <div class="item-embarque-info">
            <p class="nome-embarque"><?= $embarque['nome'] ?></p>
            <span>Endereço:</span>
            <p><?= $embarque['endereco'] ?></p>
            <span>Referência para embarque:</span>
            <p><?= $embarque['obs'] ?></p>
          </div>
          <div class="detalhes">
            <div class="horario"><?= $horarios_simples[0] ?></div>
            <?php if ($is_rock_in_rio) {
              $current_cidade = explode(' - ', $embarque['nome'])[0];
              if (in_array($current_cidade, $cidades_dia_anterior)) {
            ?>
                <span class="badge badge-dia-anterior">do dia anterior</span>
              <?php
              }
              ?>

            <?php
            } ?>
            <div class="mapa"><a href="<?= $embarque['link_mapa'] ?>" target="_blank">Ver no mapa</a></div>
          </div>
        </div>

      <?php
      } ?>
      <div class="mostrar-tudo-btn d-none" data-cidade="todas">Mostrar tudo</div>
    </div>
  </div>
</div>

<style>
  .rir-notice-box {
    display: flex;
    align-items: center;
    background-color: #fff3cd;
    /* Amarelo suave de alerta */
    border-left: 5px solid #ffc107;
    padding: 15px 20px;
    border-radius: 8px;
    margin: 20px 0;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  }

  .rir-notice-icon {
    margin-right: 15px;
    color: #856404;
    font-size: 24px;
    display: flex;
    align-items: center;
  }

  /* Caso não tenha Dashicons carregado, usamos um fallback em texto ou emoji */
  .rir-notice-icon i:before {
    content: "⚠️";
    font-style: normal;
  }

  .rir-notice-content {
    color: #856404;
    font-size: 14px;
    line-height: 1.4;
  }

  .rir-notice-content strong {
    font-size: 15px;
    margin-bottom: 2px;
    display: inline-block;
  }

  .rir-notice-content p {
    margin: 0;
    display: inline;
  }

  /* Responsividade */
  @media (max-width: 600px) {
    .rir-notice-box {
      flex-direction: column;
      text-align: center;
    }

    .rir-notice-icon {
      margin-right: 0;
      margin-bottom: 10px;
    }
  }
</style>
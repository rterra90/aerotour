<!-- TAB CONTENT EMBARQUES -->
<?php
$exc_embarques = $args['exc_embarques'];
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

          <button class="filtro-btn" data-cidade="indaiatuba">Indaiatuba</button>
        </div>
        <button class="scroll-btn right" id="scrollRight">&#9654;</button>
      </div>
    </div>

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
            <div class="mapa"><a href="<?= $embarque['link_mapa'] ?>" target="_blank">Ver no mapa</a></div>
          </div>
        </div>

      <?php
      } ?>
      <div class="mostrar-tudo-btn d-none" data-cidade="todas">Mostrar tudo</div>
    </div>
  </div>
</div>
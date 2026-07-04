<!-- TAB CONTENT EMBARQUES -->

<?php
$embarques_detalhes = $args['embarques_detalhes'];
$var_embarque_settings = $args['embarques_por_variacao'];

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

    // Reindexa para retornar um array numérico
    return array_values($agrupado);
}

?>
<div id="tab2" class="tab-content tab-embarques">
  <div class="embarque-container">

    <?php if($embarques_detalhes && is_array($embarques_detalhes) && !empty($embarques_detalhes)): ?>
    <!-- Filtro de cidadess -->
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



    <div class="lista-embarque" id="listaEmbarque">
      <?php
      foreach ($embarques_detalhes as $i => $embarque) {
      $horarios_do_embarque = array();
      
      $embarque_id = $embarque -> id;
      foreach($var_embarque_settings as $emb_var){
        $var_id = $emb_var['variation_id'];
        $var_dia = $emb_var['variation_dia'];
        $var_embarques = $emb_var['variation_embarques'];
        
        foreach($var_embarques as $var_emb){
          if($var_emb['embarque_id'] == $embarque_id){
            foreach($var_emb['horarios'] as $horario_emb){
              array_push($horarios_do_embarque, array('dia' => $var_dia, ...$horario_emb));
            }
          }
        }
        

      }

      $exibe_horarios_inativos = true;

      //verifica a quantidade de horários únicos encontrados em todas as variações para esse embarque
      $horarios_unicos = array_unique(array_map(function($h_emb){
        return $h_emb['horario'];
      }, $horarios_do_embarque));

                  //verifica se todas as variações possuem horários idênticos para esse embarque
            $set_horarios_iguais_nos_embarques = array_filter(agruparHorariosPorDia($horarios_do_embarque),
              function($h_emb) use($horarios_unicos, $exibe_horarios_inativos){
                if($exibe_horarios_inativos){
                  return count($h_emb['horarios']) == count($horarios_unicos);
                }else{

                // mapear $h_emb['horarios'] para retornar apenas os os objetos em que 'disponivel' seja true ou 1
                $horarios_disponiveis = array_filter($h_emb['horarios'], function($h){
                  return $h['disponivel'];
                });
                
                if(count($horarios_disponiveis) !== count($h_emb['horarios'])){
                  return false;
                }
                
                }

            });

            $horarios_iguais_nos_embarques = count($set_horarios_iguais_nos_embarques) === count(agruparHorariosPorDia($horarios_do_embarque));
      ?>
        <div class="item-embarque" data-cidade="<?= strtolower(
                                                  trim(explode(' - ', $embarque -> nome)[0])
                                                ) ?>">
          <div class="item-embarque-info">
            <p class="nome-embarque"><?= $embarque -> nome ?></p>
            <span>Endereço:</span>
            <p><?= $embarque -> endereco ?></p>
            <span>Referência para embarque:</span>
            <p><?= $embarque -> obs ?></p>
            <?php
              if(count($horarios_unicos) > 1 && !$horarios_iguais_nos_embarques):
                ?>
                  <div class="mapa"><a href="<?= $embarque -> link_mapa ?>" target="_blank">Ver no mapa</a></div>
                <?php
              endif;
            ?>

          </div>
          <div class="detalhes">
            <div class="horario">
            <?php

            if(count($horarios_unicos) === 1){ // apenas um horário para o embarque
              echo $horarios_unicos[0] . '</p>';
            } elseif(count($horarios_unicos) > 1 && $horarios_iguais_nos_embarques){ // horários múltiplos iguais em todos os dias
              ?>
              <div class="dia-horarios-area">
                <p class="area-header title">Horários</p>

                <?php
                  foreach($horarios_unicos as $h_emb){ echo '<span>' . $h_emb . '</span>'; }
                ?>
              </div>
              <?php

            } else { // horários gerais múltiplos, mas diferentes entre os dias
            ?> <p class="area-header title">Horários</p>
            <div class="dia-horarios-inner">
              <?php

              $dias_agrupados = [];
              $dados = agruparHorariosPorDia($horarios_do_embarque);

              foreach ($dados as $dia) {

                  $horarios_exibidos = array_filter(
                      $dia['horarios'],
                      fn($h) => $exibe_horarios_inativos || $h['disponivel']
                  );

                  // Cria uma chave única baseada nos horários e disponibilidade
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
                        $dias = array_map(
                            fn($d) => substr($d, 0, -5),
                            $grupo['dias']
                        );

                        echo count($dias) > 1
                            ? 'Dias ' . implode(' e ', $dias)
                            : 'Dia ' . $dias[0];
                        ?>
                    </p>

                    <?php foreach ($grupo['horarios'] as $h_emb) : ?>
                        <span><?= $h_emb['horario']; ?></span>
                    <?php endforeach; ?>

                </div>

              <?php endforeach;
              ?>
              </div>
              <?php
            }

            ?>

            </div>
            <?php
            if(count($horarios_unicos) === 1 || $horarios_iguais_nos_embarques):
              ?>
                <div class="mapa mt-3"><a href="<?= $embarque -> link_mapa ?>" target="_blank">Ver no mapa</a></div>
              <?php
            endif;
            ?>
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
  .dia-horarios-area {
    margin-bottom: 4px;
    font-family: system-ui;
  } 
  .dia-horarios-area + .dia-horarios-area{
        border-top: 1px solid #ccc;
    margin-top: 8px;
    padding-top: 4px;
  }
  .area-header {
    font-weight: bold;
    margin-bottom: -2px;
    font-size: .675rem;
    text-transform: uppercase;
    opacity: .65;
  }
  .area-header.title{
        margin-bottom: 2px;
    color: var(--aer-accent);
    font-size: .825rem;
    opacity: initial;
    
  }
  .dia-horarios-area span {
    display: inline-block;
    margin-left: 5px;
    padding: 1px 6px;
    border-radius: 4px;
    color: var(--aer-accent);
    font-size: .85rem;
    border: 2px solid var(--aer-accent);
  }
  .dia-horarios-area span.disponivel {
    /* background-color: transparent; */
    border: 2px dashed var(--aer-accent);
    color: var(--aer-accent);
  }
  .dia-horarios-area span.indisponivel {
    background-color: #dc3545;
  }

  @media(max-width: 600px){
    .lista-embarque .item-embarque{
          flex-direction: column;
    align-items: start;
    position: relative;
    }
    .lista-embarque .item-embarque .mapa{
          position: absolute;
    right: 12px;
    bottom: 15px;
    }
    .lista-embarque .item-embarque .detalhes{
      margin-top: 0px;
    }
    .area-header.title{
      margin-bottom: 0px;
    }
    .dia-horarios-inner{
      display: flex;
    }
    .dia-horarios-inner .dia-horarios-area + .dia-horarios-area{
      border-top: none;
      margin-top: 0px;
      padding-top: 0px;
          margin-left: 12px;
    border-left: 1px solid #ccc;
    padding-left: 12px;
    }
    .dia-horarios-area span:first-of-type{
      margin-left: 0px;
    }

     .dia-horarios-inner .dia-horarios-area span{
      margin-left: 0px!important;
    }
  }
</style>
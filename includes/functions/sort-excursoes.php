<?php
function aer_proximas_excursoes($excursoes, $filter = null)
{
  if (empty($excursoes)) {
    return [];
  }

  $proximas_exc = [];
  $agora = time();

  foreach ($excursoes as $excursao) {
    $exc_id = $excursao->get_id();

    // Filtro de Destaque: aproveita o objeto já existente
    if ($filter === 'destaque') {
      // Usa o método nativo do WooCommerce para verificar se está em destaque
      if ($excursao->is_featured()) {
        $proximas_exc[] = $excursao;
      }
      continue;
    }

    // Filtro Em Breve: produtos sem embarques definidos
    if ($filter === 'em-breve') {
      if (get_post_meta($exc_id, 'exc_embarques', true) === '') {
        $proximas_exc[] = $excursao;
      }
      if (count($proximas_exc) >= 8) {
        break;
      } // Limite de performance
      continue;
    }

    // Caso padrão (Galeria ou nulo): apenas retorna o que já foi filtrado na home
    $proximas_exc[] = $excursao;
    if (count($proximas_exc) >= 8 && $filter !== 'galeria') {
      break;
    }
  }

  return $proximas_exc;
}

function aer_excursoes_apos_data($excursoes, $data_ref)
{
  $excs = [];
  $final_excs = [];
  foreach ($excursoes as $excursao) {
    $exc_id = $excursao->get_id();
    $variacoes = $excursao->get_available_variations();
    $data_inicial = $variacoes[0]['attributes']['attribute_dia'];
    $data_inicial =
      count(explode('/', $data_inicial)) == 3
        ? $data_inicial
        : $data_inicial . '/' . date('Y');
    $data_inicial_std =
      explode('/', $data_inicial)[2] .
      '-' .
      explode('/', $data_inicial)[1] .
      '-' .
      explode('/', $data_inicial)[0];
    if (strtotime($data_inicial_std) > strtotime(date($data_ref))) {
      $excs[$exc_id] = strtotime($data_inicial_std);
    }
  }
  asort($excs);
  $i = 0;
  foreach ($excs as $key => $exc) {
    if ($i < 8) {
      array_push($final_excs, wc_get_products(['include' => [$key]])[0]);
    }
    $i++;
  }
  return $final_excs;
}
?>

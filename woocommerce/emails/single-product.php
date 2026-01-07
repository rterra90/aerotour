<?php
get_header();
$user = wp_get_current_user();
$user_meta = get_user_meta($user->ID);
$user -> metafields = $user_meta;
$ja_comprado = false;
// $locais_embarque = json_decode(get_post_meta(get_the_ID(), 'exc_embarques', true), true);

function excursao_formatada($id){
  $_excursao = wc_get_product($id);
  $_excursao_img = wp_get_attachment_image_src($_excursao->get_image_id(), 'full');
  $data_final = $_excursao->get_available_variations()[count($_excursao->get_available_variations()) - 1]['attributes']['attribute_dia'];
  $data_final = count(explode('/', $data_final)) == 3 ? $data_final : $data_final . "/" .date("Y");
  $locais_embarque = json_decode(get_post_meta($id, 'exc_embarques', true), true);
  if($locais_embarque){
    usort($locais_embarque, function ($a, $b) {
      return strcmp($a["nome"], $b["nome"]);
    });
  }
  
  return [
    'id' => $id,
    'nome' => $_excursao->get_name(),
    'price' =>$_excursao->get_price(),
    'on_sale' => $_excursao->is_on_sale(),
    'regular_price' => $_excursao->get_regular_price(),
    'descricao' => $_excursao->get_description(),
    'img' => $_excursao_img ? $_excursao_img[0] : null,
    'variacoes' => $_excursao->get_available_variations(),
    'atributos' => $_excursao->get_attributes(),
    'embarques' => $locais_embarque ? $locais_embarque : null,
    'data_final' => $data_final,
  ];
}
$excursao = excursao_formatada(get_the_ID());

foreach($excursao['variacoes'] as $i => $var){
  $excursao['variacoes'][$i]['is_vendas_encerradas'] = get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes' ? true : false;
}
?>

  <section id="content-event" class="pb-5 aer-bg-light">
    
        <script>
          <?php if(is_user_logged_in()){ ?>
            window.sessionStorage.setItem('aer_user', JSON.stringify({nome_completo: '<?= $user_meta['first_name'][0] . " " . $user_meta['last_name'][0]; ?>', doc: '<?= $user_meta['nickname'][0]; ?>', telefone: '<?= $user_meta['billing_phone'][0]; ?>'}))
          <?php } else { ?>
            window.sessionStorage.removeItem('aer_user')
          <?php } ?>
        </script>
    
    <div class="container-lg container-fluid py-5">
      <div class="notices">
        <?php wc_print_notices(); ?>
      </div>
      <i class="pre-titulo">Excursão Aerotour</i>
      <h1><?= $excursao['nome'] ?></h1>

      <main class="row">
        <div class="col-md-7 event-details">
          <img class="main-image mt-3 mt-md-0" src="<?= $excursao['img'] ?>" alt="Imagem representativa de <?= $excursao['nome'] ?>" width="100%">
          <h2 class="mt-md-5 mb-md-3 my-4">Informações sobre a excursão</h2>
          <div class="info-exc-box">
            <h3>Local do evento</h3>
            <span><?= get_post_meta($excursao['id'], 'local_evento', true); ?></span>
          </div>
          <div class="info-exc-box">
            <h3>Locais de embarque</h3>
          <?php 
            if($excursao['embarques']){
              ?>
                <div class="accordion" id="accordionLocaisEmbarque">
                  <?php
                    $_i = 0;
                    foreach($excursao['embarques'] as $i => $embarque){
                      ?>
                      <div class="accordion-item">
                        <h4 class="accordion-header" id="panelsStayOpen-heading<?= $_i; ?>">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse<?= $_i; ?>" aria-expanded="false" aria-controls="panelsStayOpen-collapse<?= $_i; ?>">
                            <?= $embarque['nome'] . "    "; ?>
                            <span style="display: inline-block; font-weight: 500; font-size: .875rem; margin: 0 10px 0 auto;"><?= array_keys($embarque['dias'][$excursao['data_final']])[0]; ?></span>
                          </button>
                        </h4>
                        <div id="panelsStayOpen-collapse<?= $_i; ?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading<?= $_i; ?>">
                          <div class="accordion-body">
                          <?= $embarque['endereco']; ?>
                          </div>
                        </div>
                      </div>
                      <?php
                      $_i = $_i + 1;
                    }
                  ?>
                </div>
              <?php
            }else{
              ?>
                <p>Locais de embarque não definidos para essa excursão.</p>
              <?php
            }
          ?>
          </div>
          
        </div>
        <div class="col-md-5 col center-element reserva-box">
          <div class="excursao-details position-relative aer-box">
            <h3 class="mb-4">Faça aqui sua reserva</h3>


              <!-- RESERVA APP - REACT  -->
              <div id="reserva_app" data-variacoes='<?= json_encode($excursao['variacoes'], JSON_UNESCAPED_UNICODE); ?>' data-embarques='<?= json_encode($excursao['embarques'], JSON_UNESCAPED_UNICODE); ?>' data-product-id='<?= $excursao['id']; ?>'></div>
              <!-- FIM RESERVA APP - REACT  -->
          

          </div>
        </div>
      </main>
  </section>
<script>
</script>
  <script src="<?php echo get_stylesheet_directory_uri() ?>/js/single-product.js"></script>

<?php get_footer(); ?>
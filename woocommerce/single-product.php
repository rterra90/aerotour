<?php
get_header();
// JSON-LD
if ($product) {
  $jsonLd = [
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    'name' => 'Excursão ' . $product->get_name(),
    'image' => wp_get_attachment_url($product->get_image_id()),
    'description' => wp_strip_all_tags($product->get_short_description()),
    'brand' => [
      '@type' => 'Brand',
      'name' => 'Aerotour Excursões'
    ],
    'offers' => [
      '@type' => 'Offer',
      'priceCurrency' => 'BRL',
      'price' => $product->get_price() . '.00',
      'availability' => $product->is_in_stock()
        ? 'https://schema.org/InStock'
        : 'https://schema.org/OutOfStock',
      'url' => get_permalink($product->get_id()),
      'seller' => [
        '@id' => 'https://www.aerotour.com.br/'
      ]
    ]
  ];
}
echo '<script type="application/ld+json">' .
  json_encode(
    $jsonLd,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
  ) .
  '</script>';
// FIM JSON-LD

$user = wp_get_current_user();
$user_meta = get_user_meta($user->ID);
$user->metafields = $user_meta;
global $wpdb;
global $product;

function excursao_formatada($id)
{
  global $wpdb;
  $_excursao = wc_get_product($id);
  $_excursao_img = wp_get_attachment_image_src(
    $_excursao->get_image_id(),
    'full'
  );
  $locais_embarque = json_decode(get_post_meta($id, 'embarques', true), true);
  $exc_embarques = json_decode(get_post_meta($id, 'exc_embarques', true), true);

  if ($locais_embarque !== null) {
    $ids_embarques = array_map(function ($_emb) {
      return $_emb['embarqueId'];
    }, $locais_embarque);
    $_ids_str = implode(',', $ids_embarques);
  }

  $embarques_db = isset($_ids_str)
    ? $wpdb->get_results("SELECT * from aer_embarques WHERE id IN ($_ids_str)")
    : [];

  if (isset($locais_embarque)) {
    foreach ($locais_embarque as $_index => $_emb_exc) {
      foreach ($embarques_db as $_emb_db) {
        if ((int) $_emb_db->id === (int) $_emb_exc['embarqueId']) {
          $locais_embarque[$_index]['nome'] = $_emb_db->nome;
          $locais_embarque[$_index]['endereco'] = $_emb_db->endereco;
          $locais_embarque[$_index]['obs'] = $_emb_db->obs;
          $locais_embarque[$_index]['link_mapa'] = $_emb_db->link_mapa;
        }
      }
    }
  }

  // function disp_vagas($_e){
  //   $_variacoes = $_e->get_available_variations();
  //   if(count($_variacoes) == 1){
  //     $return = (int) trim(str_replace('</p>', '', substr($_variacoes[0]['availability_html'], 29)));
  //     return $return == '' ? 0 : $return;
  //   } else return false;
  // };

  return [
    'id' => $id,
    'nome' => $_excursao->get_name(),
    'price' => $_excursao->get_price(),
    'on_sale' => $_excursao->is_on_sale(),
    'regular_price' => $_excursao->get_regular_price(),
    'descricao' => $_excursao->get_description(),
    'img' => $_excursao_img ? $_excursao_img[0] : null,
    'variacoes' => $_excursao->get_available_variations(),
    'atributos' => $_excursao->get_attributes(),
    'embarques' => $locais_embarque ? $locais_embarque : null,
    'exc_embarques' => json_encode($exc_embarques, JSON_UNESCAPED_UNICODE)
    // 'data_final' => $data_final,
    // 'disp_vagas' => disp_vagas($_excursao),
  ];
}

$excursao = excursao_formatada(get_the_ID()); // print_r($excursao);

// Define se exibe número de lugares vendidos
$show_vendidos = get_post_meta($excursao['id'], 'show_vendidos', true);

//Define a propriedade 'encerrar_vendas' em cada variação
foreach ($excursao['variacoes'] as $i => $var) {
  $excursao['variacoes'][$i]['encerrar_vendas'] =
    get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes'
      ? true
      : false;
}

//Define e ordena a array de datas
$datas = array_map(function ($_var) {
  return $_var['attributes']['attribute_dia'];
}, $excursao['variacoes']);
usort($datas, function ($a, $b) {
  $dataA = DateTime::createFromFormat('d/m/Y', $a);
  $dataB = DateTime::createFromFormat('d/m/Y', $b);
  return $dataA <=> $dataB;
});
?>
<style>
  #avisoModal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #avisoModalContent {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    max-width: 500px;
    text-align: center;
    position: relative;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
  }
  #avisoModalContent h2 {
    color: #424d6d;
    margin-bottom: 20px;
  }
  #avisoModalContent p {
    margin-bottom: 25px;
    font-size: 1.075rem!important;
    line-height: 1.5;
  }
  #avisoModalContent a.whatsapp-btn {
    background-color: #25D366;
    color: white;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    display: inline-block;
  }
  #closeModalBtn {
    position: absolute;
    top: 10px;
    right: 15px;
    background: none;
    border: none;
    font-size: 22px;
    cursor: pointer;
    color: #999;
  }
  #closeModalBtn:hover {
    color: #333;
  }
</style>
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() ?>/css/woocommerce/single-product.min.css?ver=<?= time() ?>">
  <?php
  $redirect_link = get_post_meta(get_the_ID(), 'redirect_link', true);
  if ($redirect_link) { ?>
    <div id="avisoModal">
      <div id="avisoModalContent">
        <button id="closeModalBtn" aria-label="Fechar modal">&times;</button>
        <h2>Atenção</h2>
        <p class="mb-3">Essa página é de uma excursão passada. </p>
        <a class="d-block" style="text-decoration:underline" href="<?= $redirect_link ?>">Clique aqui para acessar a página atual para a excursão Ensaios da Anitta Campinas 2026.</a>
        
        <a class="whatsapp-btn main-close-btn mt-3" href="#">Fechar</a>
      </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
      const modal = document.getElementById("avisoModal");
      const closeBtn = document.getElementById("closeModalBtn");
      const closeMainBtn = document.querySelector(".main-close-btn");

      // Exibe o modal com pequeno delay
      setTimeout(() => {
        modal.style.display = "flex";
      }, 500);

      // Fecha ao clicar no botão
      closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
      });

      closeMainBtn.addEventListener("click", () => {
        modal.style.display = "none";
      });

      // Fecha ao clicar fora do conteúdo
      modal.addEventListener("click", (e) => {
        if (e.target === modal) {
          modal.style.display = "none";
        }
      });
    });
    </script>

    <?php }
  ?>
  <section id="content-event" class="pb-5 aer-bg-light">

    <script>
      <?php if (is_user_logged_in()) { ?>
        window.sessionStorage.setItem('aer_user', JSON.stringify({nome_completo: '<?= $user_meta[
          'first_name'
        ][0] .
          ' ' .
          $user_meta['last_name'][0] ?>', doc: '<?= $user_meta[
  'nickname'
][0] ?>', telefone: '<?= $user_meta['billing_phone'][0] ?>'}))
      <?php } else { ?>
        window.sessionStorage.removeItem('aer_user')
      <?php } ?>
    </script>

    <div class="hero-img">
      <img class="main-image" src="<?= $excursao[
        'img'
      ] ?>" alt="Imagem representativa da excursão <?= $excursao[
  'nome'
] ?> da Aerotour" width="100%" height="100%">
    </div>

    <!-- quando houver banner: py-md-3 -->
    <!-- quando NÃO houver banner: py-md-5 -->
    <div class="container-xxl py-md-3 py-3 excursao-wrapper"> 
      <div class="notices">
        <?php wc_print_notices(); ?>
      </div>

      <!-- BANNER ARTECULT -->
       <div id="topAdBanner">
        <small>PARCEIRO</small>
        <?php
        // Insere o banner ArteCult
        get_template_part('assets/banners/banner-artecult', null);

        // Insere o modal
        get_template_part('includes/modals/modal', null);
        ?>
       </div>
       
      
      <!-- quando houver banner: mt-md-3 -->
      <section class="row product-body mt-3">

        <!-- INFORMAÇÕES -->
        <div id="info-body" class="col-md-7 col">
          <div class="d-flex justify-content-between gap-2">
            <h1><span>Excursão<br/></span><?= $excursao['nome'] ?></h1>

            <!-- SOCIAL SHARE -->
            <div class="share">
              <span>Compartilhe</span>
              <div class="share-icons d-flex gap-2">
                <a href="https://api.whatsapp.com/send?text=<?php echo get_permalink(); ?>" aria-label="Botão compartilhar pelo WhatsApp"><?= aer_icons(
  'whatsapp',
  18,
  18
) ?></a>
                <a href="https://www.instagram.com/aerotour_excursoes/" aria-label="Botão compartilhar pelo Instagram"><?= aer_icons(
                  'instagram',
                  18,
                  18
                ) ?>
                </a>
                <a href="https://www.facebook.com/aerotourcampinas/" aria-label="Botão compartilhar pelo Facebook">
                  <?= aer_icons('facebook', 18, 18) ?>
                </a>
              </div>
            </div>
            <!-- FIM SOCIAL SHARE -->

          </div>
          

          <!-- CONTADOR DE RESERVAS -->
<div class="status-badges-container">
  <!-- Aviso de últimas vagas -->
  <!-- se houver apenas uma variação e ela tiver menos de 10 vagas disponíveis -->
  <?php
  $variacoes_disp = array_filter($excursao['variacoes'], function ($_var) {
    return get_post_meta($_var['variation_id'], 'encerrar_vendas', true) !==
      'yes';
  });

  if (count($variacoes_disp) == 1) {
    $vaga_var = $variacoes_disp[0];
    $disponibilidade_html = $vaga_var['availability_html'];
    preg_match('/\d+/', strip_tags($disponibilidade_html), $matches);
    $vagas_disponiveis = isset($matches[0]) ? (int) $matches[0] : 0;

    if ($vagas_disponiveis > 0 && $vagas_disponiveis <= 10) { ?>
      <div class="aviso-ultimas-vagas <?= $show_vendidos === 'yes'
        ? 'left'
        : '' ?>">
        <strong class="d-block">Últimos lugares!</strong> Apenas <?= $vagas_disponiveis ?> vagas disponíveis!
      </div>
      <?php } elseif (!$vagas_disponiveis) { ?>
      <div class="aviso-ultimas-vagas aviso-esgotado">
        <strong class="d-block">Esgotado!</strong> Não temos mais lugares disponíveis...
      </div>
      <?php }
  }
  ?>
  <!-- Contador de reservas realizadas -->
<?php if ($show_vendidos === 'yes') { ?>

              <!-- get na tabela reservas para contar quantas reservas existem para o produto atual -->
              <?php
              global $wpdb;
              $table_name = $wpdb->prefix . 'reservas';

              // se uma excursão tiver múltiplas datas, somar as reservas de todas as variações
              $variacao_ids = array_map(function ($_var) {
                return $_var['variation_id'];
              }, $excursao['variacoes']);
              $_ids_str = implode(',', $variacao_ids);
              $reservas_count = $wpdb->get_var(
                $wpdb->prepare(
                  "SELECT COUNT(*) FROM $table_name WHERE status = 'normal' AND variation_id IN ($_ids_str)"
                )
              );

              // obter o valor numérico no meta "vendidos_inc" e somar ao contador
              $incremento = get_post_meta(
                $excursao['id'],
                'vendidos_inc',
                true
              );
              if (is_numeric($incremento)) {
                $reservas_count += (int) $incremento;
              }
              ?>
              <div class="reservas-contador">
                <p><strong><?= aer_icons(
                  'banco',
                  16,
                  16,
                  '.webp'
                ) ?></strong><?= $reservas_count ?> lugares reservados!</p>
              </div> 
              
              <?php } ?>

</div>

          
          <!-- FIM CONTADOR DE RESERVAS -->


          
          <!-- info inner -->
          <div class="info">
            <!-- grid container -->
            <section class="grid-container">
              <!-- Box Datas -->
              <div class="box box1">
                <div class="label"><?= aer_icons('calendar-red', 22, 22) ?>
                  <span>Data</span>
                </div>
                
                  <?php if (count($datas) > 2) { ?>
                      <div class="pre-value">Entre</div>
                      <div class="value" style="margin-top: -6px"><?= $datas[0] ?></div>
                      <div class="pre-value">e</div>
                      <div class="value" style="margin-top: -6px"><?= $datas[
                        count($datas) - 1
                      ] ?></div>

                      <?php } elseif (count($datas) <= 2) {
                    foreach ($datas as $data) { ?>
                        <div class="value"><?= $data === '31/12/2026'
                          ? 'A definir...'
                          : $data ?></div>
                        <?php }
                  } ?>
                
              </div>

              <!-- Box Local -->
              <div class="box box2">
                <div class="label"><?= aer_icons('pin-red', 22, 22) ?>
                  <span>Local</span>
                </div>
                <?php
                $local = get_post_meta($excursao['id'], 'local_evento', true);
                $local_array = preg_split('/\s*\/\s*/', $local);
                ?>
                <div class="value"><?= $local_array[0] ?></div>
                <div class="post-value"><?= $local_array[1] ?></div>
              </div>

              <!-- Box Previsão chegada -->
              <div class="box box3">
                <div class="label"><?= aer_icons('clock-red', 15, 15) ?>
                  <span>Chegada prevista</span>
                </div>
                <div class="value"><?= get_post_meta(
                  get_the_ID(),
                  'previsao_chegada',
                  true
                ) ?></div>
              </div>

              <!-- Box Ingressos -->
              <div class="box box4">
                <div class="label"><?= aer_icons('ticket-red', 15, 15) ?>
                  <span>Ingressos</span>
                </div>
                <div class="value"><a class="ingressos-link" aria-label="Link para venda de ingressos" href="<?= get_post_meta(
                  get_the_ID(),
                  'ingressos_link',
                  true
                ) ?>" target="_blank"><?= get_post_meta(
  get_the_ID(),
  'ingressos_label',
  true
) ?></a></div>
              </div>
            </section>

            <!-- cta button -->
            <a href="#reservaBox" class="cta-button" aria-label="Reservar lugar na excursão <?= $excursao[
              'nome'
            ] ?>" onclick="gtag('event', 'clique_reservar_cta', {
                  'event_category': 'ads',
                  'event_label': 'clique_reservar_cta',
                  'value': 1
                })">
              <?= aer_icons('bookmark-light', 16, 16, '.webp') ?> Reservar agora
            </a>


            <h2>Informações sobre a excursão</h2>

            <!-- TABS NAVIGATION -->
            <div class="tab-container">
              <div class="tab-nav">
                <button class="tab-btn active" data-tab="tab1" onclick="gtag('event', 'tab_como_funciona', {
                  'event_category': 'ads',
                  'event_label': 'tab_como_funciona',
                  'value': 1
                })">Como funciona</button>
                <button class="tab-btn" data-tab="tab2" onclick="gtag('event', 'tab_locais_embarque', {
                  'event_category': 'ads',
                  'event_label': 'tab_locais_embarque',
                  'value': 1
                })">Locais de embarque</button>
                <button class="tab-btn" data-tab="tab3" onclick="gtag('event', 'tab_principais_duvidas', {
                  'event_category': 'ads',
                  'event_label': 'tab_principais_duvidas',
                  'value': 1
                })">Principais dúvidas</button>
              </div>

              <!-- TAB CONTENT COMO FUNCIONA -->
              <div id="tab1" class="tab-content tab-como-funciona active">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item bg-transparent">Transporte para o evento, ida e volta.</li>
                  <li class="list-group-item bg-transparent">Grupo exclusivo no WhatsApp para comunicação.</li>
                  <li class="list-group-item bg-transparent">Retorno logo após o final do evento. No caso de festivais, será considerado o final da última apresentação musical do palco principal.</li>
                  <li class="list-group-item bg-transparent">No retorno, os desembarques acontecem nos mesmos pontos.</li>
                  <li class="list-group-item bg-transparent">O desembarque e estacionamento do veículo no local do evento dependem das condições e orientações de trânsito local.</li>
                  <li class="list-group-item bg-transparent">Tolerância para retorno ao veículo a ser definida de acordo com as condições de cada evento. Em geral, é de 1h após o final do evento.</li>
                  <li class="list-group-item bg-transparent">Incluso monitoria e água a bordo.</li>
                  <li class="list-group-item bg-transparent">NÃO inclui ingresso para os eventos.</li>
                </ul>
              </div>

              <!-- TAB CONTENT EMBARQUES -->
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
                          }, $excursao['embarques'])
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
                    <?php foreach ($excursao['embarques'] as $i => $embarque) {
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
                          <div class="mapa"><a href="<?= $embarque[
                            'link_mapa'
                          ] ?>" target="_blank">Ver no mapa</a></div>
                        </div>
                      </div>

                      <?php
                    } ?>
                    <div class="mostrar-tudo-btn d-none" data-cidade="todas">Mostrar tudo</div>
                  </div>
                </div>
              </div>

              <!-- TAB CONTENT PRINCIPAIS DÚVIDAS -->
              <div id="tab3" class="tab-content tab-duvidas">
                <dl id="principaisDuvidasContent">
                  <dt class="text-start pergunta fw-bold mb-1">• A excursão inclui ingresso para os eventos?</dt>
                  <dd class="text-start resposta">Não. Nós não comercializamos ingressos, a menos que expressamente informado, e recomendamos a compra apenas em pontos de venda autorizados.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• É possível reservar apenas ida ou volta?</dt>
                  <dd class="text-start resposta">Sim, porém não há diferenciação nos valores. Cada reserva na excursão representa um lugar reservado por toda a viagem — ida e volta. Você poderá informar durante o processo de reserva se deseja utilizar o transporte em apenas um dos sentidos ou pela viagem toda. Essa informação é importante para controle do embarque de passageiros, mas não impede que o passageiro altere seus planos se precisar.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• Como saber se há disponibilidade de vagas?</dt>
                  <dd class="text-start resposta">As vagas são gerenciadas pelo próprio site. Enquanto houver vagas, estará disponível para reservas. Um aviso em amarelo surgirá quando estivermos na últimas vagas, e um aviso em vermelho indicará que as vagas estão esgotadas.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• É preciso encaminhar comprovante de pagamento por e-mail?</dt>
                  <dd class="text-start resposta">Não, você não precisa encaminhar nenhum tipo de comprovante após fazer sua reserva com a Aerotour. Você receberá um email de confirmação de reserva e você também poderá vê-la na página "Minhas reservas", na sua área logada aqui no site.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• Como acessar o grupo de WhatsApp da excursão?</dt>
                  <dd class="text-start resposta">Os grupos são criados 5 dias antes da data da excursão. Quem reservar antes desse período, receberá um e-mail com o link para acesso assim que o grupo for disponibilizado. Caso contrário, o link será enviado no e-mail de confirmação de reserva. Também será possível acessar o grupo por meio da página <b>Minhas reservas</b>.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• É permitido deixar pertences no veículo?</dt>
                  <dd class="text-start resposta">De forma geral, não há impedimentos para quem deseja deixar algum item no interior do veículo durante os eventos. No entanto, não dispomos de serviço de guarda de objetos e não assumimos a responsabilidade por eles. Por isso, não recomendamos que sejam deixados objetos de valor.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• Em qual tipo de veículo será feito o transporte?</dt>
                  <dd class="text-start resposta">As excursões podem acontecer em veículos como ônibus e micro-ônibus executivos ou vans. A definição depende da demanda de passageiros para cada excursão, visando garantir a eficiência, conforto e segurança da viagem</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• Qual o itinerário da viagem?.</dt>
                  <dd class="text-start resposta">Em excursões para São Paulo, organizamos as excursões em duas rotas. Uma delas inclui Sumaré, Hortolândia, Paulínia e Campinas(Unicamp). A outra inclui Salto, Indaiatuba e Campinas (Largo do Pará). Os passageiros de Valinhos, Vinhedo e Jundiaí são acomodados conforme a disponiblidade dos veículos. Para outros destinos, as definições ocorrem de acordo com a rota.</dd>
                </dl>
              </div>
            </div>
          </div>

        </div>
        <!-- FIM INFORMAÇÕES -->

        <!-- RESERVA REACT -->
        <div id="reservaBox" class="col-md-5 col center-element reserva-box">

          <!--<div id="bannerRoleta">-->
          <!--  <img class="w-100 mb-1" src="<?= get_stylesheet_directory_uri() ?>/assets/banners/banner-roleta.webp" alt="Banner roleta Aerotour">-->
          <!--</div>-->

          <!-- <div class="excursao-details position-relative aer-box mt-3 mt-sm-2"> -->
            
            <!-- <h2 class="mb-4">Faça aqui sua reserva</h2> -->

            <!-- RESERVA APP - REACT  -->
            <div id="reserva_app" data-cart-url='<?= wc_get_cart_url() ?>' data-ajax-url='<?php echo admin_url(
  'admin-ajax.php'
); ?>' data-variacoes='<?= json_encode(
  $excursao['variacoes'],
  JSON_UNESCAPED_UNICODE
) ?>' data-embarques='<?= json_encode(
  $excursao['embarques'],
  JSON_UNESCAPED_UNICODE
) ?>' data-product-id='<?= $excursao[
  'id'
] ?>' data-exc-embarques='<?= json_encode(
  $excursao['exc_embarques'],
  JSON_UNESCAPED_UNICODE
) ?>'></div>
            <!-- FIM RESERVA APP - REACT  -->
          

        </div>
        <!-- FIM RESERVA REACT -->

      </section>

      <!-- BOTÃO WHATSAPP -->
      <div id="exc-wpp-cta" class="desktop">
        <a href="https://api.whatsapp.com/send?phone=5519997477465&text=Olá. Estive no site da Aerotour e gostaria de saber mais sobre a excursão <?= $excursao[
          'nome'
        ] ?>" aria-label="Botão para chamar no WhatsApp">
          <div role="button" class="mt-5">
            <div class="wpp-icon">
              <?= aer_icons('whatsapp', 30, 30) ?>
            </div>
            <div class="wpp-text">
              <p>Dúvidas?</p>
              <span>Fale conosco no WhatsApp!</span>                
            </div>
          </div>
        </a>
      </div>
      <!-- FIM BOTÃO WHATSAPP -->

      <!-- EXCURSÕES RELACIONADAS -->
      <section id="excursoes-relacionadas" class="mt-5 py-md-3">
        <?php
        $product = wc_get_product(get_the_id());
        $cross_sells = $product->cross_sell_ids;
        if (sizeof($cross_sells) > 0) {
          $relateds = wc_get_products([
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish',
            'include' => $cross_sells,
            'limit' => -1
          ]);

          if (sizeof($relateds) > 0) {
            aer_cards_slider(
              aer_proximas_excursoes($relateds),
              'Veja também',
              'light'
            );
          }
        }
        ?> 
      </section>

      <!-- SOCIAL FOOTER -->
      <div id="social-footer" class="d-flex mt-sm-4 mt-5">
        <div class="instagram-feed col-md-6">
          <h2 class="bg-title">Siga a Aerotour</h2>
          <?php echo do_shortcode('[instagram feed="4017"]'); ?>
        </div>
        <div id="secaoFotos" col-md-6">
          <h2 class="bg-title">Fotos das excursões</h2>
          <div id="carouselExampleControls" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/jorgeemateus.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/linkinpark.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/redhot.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/knotfest19.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/anitta.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/straykids06.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/bmth.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/evanescence.webp" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="<?= get_stylesheet_directory_uri() ?>/assets/images/galeria/equipe_aerotour.webp" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </section>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/single-product.js?ver=<?= time() ?>"></script>
<!-- React e ReactDOM em produção -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin defer></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin defer></script>
<?php get_footer(); ?>

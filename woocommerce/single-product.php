<?php
get_header();
$user = wp_get_current_user();
$user_meta = get_user_meta($user->ID);
$user -> metafields = $user_meta;
$ja_comprado = false;
global $wpdb;

$exc_embarques = get_post_meta(get_the_ID(), 'exc_embarques', true);

function excursao_formatada($id){
  global $wpdb;
  $_excursao = wc_get_product($id);
  $_excursao_img = wp_get_attachment_image_src($_excursao->get_image_id(), 'full');
  $locais_embarque = json_decode(get_post_meta($id, 'embarques', true), true);
  
  
  if($locais_embarque !== null){
    $ids_embarques = array_map(function($_emb){
      return $_emb['embarqueId'];
    }, $locais_embarque);
    $_ids_str = implode(',', $ids_embarques);
  }

  $embarques_db = isset($_ids_str) ? $wpdb -> get_results("SELECT * from aer_embarques WHERE id IN ($_ids_str)") : [];

  if(isset($locais_embarque)){
    foreach($locais_embarque as $_index => $_emb_exc){
      foreach($embarques_db as $_emb_db){
        if((int)$_emb_db -> id === (int)$_emb_exc['embarqueId']){
          $locais_embarque[$_index]['nome'] = $_emb_db -> nome;
          $locais_embarque[$_index]['endereco'] = $_emb_db -> endereco;
          $locais_embarque[$_index]['obs'] = $_emb_db -> obs;
          $locais_embarque[$_index]['link_mapa'] = $_emb_db -> link_mapa;
        }
      }
    }
  }
  
  
  // if($locais_embarque){
  //   usort($locais_embarque, function ($a, $b) {
  //     $_a = isset($a["nome"]) ? $a["nome"] : $a["nome_embarque"];
  //     $_b = isset($b["nome"]) ? $b["nome"] : $b["nome_embarque"];
  //     return strcmp($_a, $_b);
  //   });
  // }
  
  function disp_vagas($_e){
    $_variacoes = $_e->get_available_variations();
    if(count($_variacoes) == 1){
      $return = (int) trim(str_replace('</p>', '', substr($_variacoes[0]['availability_html'], 29)));
      return $return == '' ? 0 : $return;
    } else return false;
  };

  
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
    // 'data_final' => $data_final,
    'disp_vagas' => disp_vagas($_excursao),
  ];
}

$excursao = excursao_formatada(get_the_ID());

//Define a propriedade 'encerrar_vendas' em cada variação
foreach($excursao['variacoes'] as $i => $var){
  $excursao['variacoes'][$i]['encerrar_vendas'] = get_post_meta($var['variation_id'], 'encerrar_vendas', true) === 'yes' ? true : false;

}
//Define e ordena a array de datas
$datas = array_map(function($_var){
  return $_var['attributes']['attribute_dia'];
}, $excursao['variacoes']);
usort($datas, function($a, $b) {
    $dataA = DateTime::createFromFormat('d/m/Y', $a);
    $dataB = DateTime::createFromFormat('d/m/Y', $b);
    return $dataA <=> $dataB;
})
?>
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri(); ?>/css/woocommerce/single-product.min.css?ver=<?= time(); ?>">

  <section id="content-event" class="pb-5 aer-bg-light">

    <script>
      <?php if(is_user_logged_in()){ ?>
        window.sessionStorage.setItem('aer_user', JSON.stringify({nome_completo: '<?= $user_meta['first_name'][0] . " " . $user_meta['last_name'][0]; ?>', doc: '<?= $user_meta['nickname'][0]; ?>', telefone: '<?= $user_meta['billing_phone'][0]; ?>'}))
      <?php } else { ?>
        window.sessionStorage.removeItem('aer_user')
      <?php } ?>
    </script>

    <div class="hero-img">
      <img class="main-image" src="<?= $excursao['img'] ?>" alt="Imagem representativa da excursão <?= $excursao['nome'] ?> da Aerotour" width="100%" height="100%">
    </div>


    <div class="container-xxl py-md-5 py-3 excursao-wrapper">
      <div class="notices">
        <?php wc_print_notices(); ?>
      </div>
      
      <section class="row product-body">
        <!-- INFORMAÇÕES -->
        <div id="info-body" class="col-md-7 col">
          <!-- <div id="mobile-sticky-res-btn">
            <?= aer_icons("form", 29, 29); ?>
            <span>Faça sua reserva!</span>
          </div> -->
          
          <?php
            if(gettype($excursao['disp_vagas']) == 'integer' && (int)$excursao['disp_vagas'] <= 10){
              ?>
              <div class="disp-header <?= (int)$excursao['disp_vagas'] === 0 ? 'esgotado' : 'ultimos'; ?> mb-3">
              <?php
                if((int)$excursao['disp_vagas'] === 0){ ?>Vagas esgotadas...<?php
                }else{ ?>Últimos lugares!<?php }
                ?>
              </div>
              <?php
            };
          ?>
          <div class="d-flex justify-content-between gap-2">
            <h1><span>Excursão<br/></span><?= $excursao['nome'] ?></h1>

            <div class="share">
            <span>Compartilhe</span>
            <div class="share-icons d-flex gap-2">
              <a href="https://api.whatsapp.com/send?text=<?php echo get_permalink(); ?>" aria-label="Botão compartilhar pelo WhatsApp"><?= aer_icons('whatsapp', 18, 18)?></a>
              <a href="https://www.instagram.com/aerotour_excursoes/" aria-label="Botão compartilhar pelo Instagram"><?= aer_icons('instagram', 18, 18)?>
              </a>
              <a href="https://www.facebook.com/aerotourcampinas/" aria-label="Botão compartilhar pelo Facebook">
                <?= aer_icons('facebook', 18, 18)?>
              </a>
            </div>
          </div>
          </div>
          
          <?php
              if(get_the_ID() == 4893){
                $total_reservas = $wpdb -> get_results("SELECT status FROM aer_reservas WHERE variation_id = 4894 AND status = 'normal'");
                $total_reservas_count = count($total_reservas) + 15;

                ?>
              <div class="lugares-reservados gap-1"><?= aer_icons('banco', 15, 15, '.png'); ?><p class="mb-0 ms-2"><?= $total_reservas_count; ?> lugares reservados</p></div>
                <?php
              } else if(get_the_ID() == 2606){
              $total_reservas = $wpdb -> get_results("SELECT status FROM aer_reservas WHERE variation_id IN (2607, 2608, 2609, 2610, 2611) AND status = 'normal'");
              $total_reservas_count = count($total_reservas) + 10;
                ?>
              <div class="lugares-reservados gap-1"><?= aer_icons('banco', 15, 15, '.png'); ?><p class="mb-0 ms-2"><?= $total_reservas_count; ?> lugares reservados</p></div>

                <?php
              }
            ?>
          
          <div class="info">
            <section class="grid-container">
              <!-- Box Datas -->
              <div class="box box1">
                <div class="label"><?= aer_icons('calendar-red', 22, 22)?>
                  <span>Data</span>
                </div>
                
                  <?php 
                    if(count($datas) > 2){
                      ?>
                      <div class="pre-value">Entre</div>
                      <div class="value" style="margin-top: -6px"><?= $datas[0]; ?></div>
                      <div class="pre-value">e</div>
                      <div class="value" style="margin-top: -6px"><?= $datas[count($datas) - 1]; ?></div>

                      <?php

                    }else if(count($datas) <= 2){
                      foreach($datas as $data){
                        ?>
                        <div class="value"><?= $data; ?></div>
                        <?php
                      }
                    }
                  ?>
                
              </div>

              <!-- Box Local -->
              <div class="box box2">
                <div class="label"><?= aer_icons('pin-red', 22, 22)?>
                  <span>Local</span>
                </div>
                <?php
                $local = get_post_meta($excursao['id'], 'local_evento', true);
                $local_array = preg_split('/\s*\/\s*/', $local);
                ?>
                <div class="value"><?= $local_array[0]; ?></div>
                <div class="post-value"><?= $local_array[1]; ?></div>
              </div>

              <!-- Box Previsão chegada -->
              <div class="box box3">
                <div class="label"><?= aer_icons('clock-red', 15, 15)?>
                  <span>Chegada prevista</span>
                </div>
                <div class="value"><?= get_post_meta(get_the_ID(), 'previsao_chegada', true); ?></div>
              </div>

              <!-- Box Ingressos -->
              <div class="box box4">
                <div class="label"><?= aer_icons('ticket-red', 15, 15)?>
                  <span>Ingressos</span>
                </div>
                <div class="value"><a class="ingressos-link" aria-label="Link para venda de ingressos" href="<?= get_post_meta(get_the_ID(), 'ingressos_link', true); ?>" target="_blank"><?= get_post_meta(get_the_ID(), 'ingressos_label', true); ?></a></div>
              </div>
            </section>

            <!-- CTA BUTTON -->
            <a href="#reservaBox" class="cta-button">
              <?= aer_icons('bookmark-light', 16, 16, '.webp'); ?> Reservar agora
            </a>


            <h2>Informações sobre a excursão</h2>

            <!-- TABS NAVIGATION -->
            <div class="tab-container">
              <div class="tab-nav">
                <button class="tab-btn active" data-tab="tab1">Como funciona</button>
                <button class="tab-btn" data-tab="tab2">Locais de embarque</button>
                <button class="tab-btn" data-tab="tab3">Principais dúvidas</button>
              </div>

              <!-- TAB CONTENT COMO FUNCIONA -->
              <div id="tab1" class="tab-content active">
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
              <div id="tab2" class="tab-content">
                <div class="embarque-container">
                  <div class="filtro-header">
                    <span>Filtre por <br />cidade:</span>
                    <div class="filtro-wrapper">
                      <button class="scroll-btn left" id="scrollLeft">&#9664;</button>
                      <div class="filtro-scroll" id="filtroCidades">
                        <button class="filtro-btn active" data-cidade="todas">Todas</button>
                        <?php 
                        //iterar $excursao['embarques'], obter a string $embarque['nome'], dividir essa string em ' - ', retornar o primeiro termo, armazenar em uma array única e ordenar em ordem alafabetica
                        $cidades = array_unique(array_map(function($_emb){
                          return strtolower(trim(explode(' - ', $_emb['nome'])[0]));
                        }, $excursao['embarques']));
                        sort($cidades);
                        
                        foreach($cidades as $cidade){
                          ?>
                            <button class="filtro-btn" data-cidade="<?= $cidade; ?>"><?= ucfirst($cidade); ?></button>


                          <?php
                        }

                        ?>
                        
                        <button class="filtro-btn" data-cidade="indaiatuba">Indaiatuba</button>
                      </div>
                      <button class="scroll-btn right" id="scrollRight">&#9654;</button>
                    </div>
                  </div>

                  <div class="lista-embarque" id="listaEmbarque">
                    <?php
                    foreach($excursao['embarques'] as $i => $embarque){
                      $horarios_simples = array_unique(array_map(function($_op){
                        return $_op['horario'];
                      }, $embarque['horarios']));

                      // o single product antigo tem funções para lidar com múltiplos horários

                      ?>
                      <div class="item-embarque" data-cidade="<?= strtolower(trim(explode(' - ', $embarque['nome'])[0])); ?>">
                        <div class="item-embarque-info">
                          <p class="nome-embarque"><?= $embarque['nome']; ?></p>
                          <span>Endereço:</span> 
                          <p><?= $embarque['endereco']; ?></p>
                          <span>Referência para embarque:</span>
                          <p><?= $embarque['obs']; ?></p>
                        </div>
                        <div class="detalhes">
                          <div class="horario"><?= $horarios_simples[0]; ?></div>
                          <div class="mapa"><a href="<?= $embarque['link_mapa']; ?>" target="_blank"></a>Ver no mapa</div>
                        </div>
                      </div>

                      <?php
                    }
                    ?>
                    <div class="mostrar-tudo-btn d-none" data-cidade="todas">Mostrar tudo</div>
                  </div>
                </div>
              </div>

              <!-- TAB CONTENT PRINCIPAIS DÚVIDAS -->
              <div id="tab3" class="tab-content">
                <dl id="principaisDuvidasContent">
                  <dt class="text-start pergunta fw-bold mb-1">• A excursão inclui ingresso para os eventos?</dt>
                  <dd class="text-start resposta">Não. Nós não comercializamos ingressos, a menos que expressamente informado, e recomendamos a compra apenas em pontos de venda autorizados.</dd>
                  <dt class="text-start pergunta fw-bold mb-1">• É possível reservar apenas ida ou volta?</dt>
                  <dd class="text-start resposta">Não oferecemos opções de reserva para apenas um dos sentidos. As excursões compreendem ida e volta, portanto, cada reserva representa um lugar reservado por toda a viagem. No entanto, você pode fazer sua reserva normalmente e utilizar o transporte em apenas um dos sentidos, sem problemas.</dd>
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
            
            

            <!-- Accordion -->
            <div class="accordion accordion-flush d-none" id="infos-accordion">
              <div class="accordion-item">
                <h3 class="accordion-header" id="infos-headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Locais de embarque e horários
                  </button>
                </h3>
                <div id="flush-collapseOne" class="accordion-collapse collapse info-exc-box"" aria-labelledby="flush-headingOne" data-bs-parent="#infos-accordion">
                <?php 
                if($excursao['embarques']){
                ?>
                  <div id="locaisEmbarqueContainer">
                    <div>
                      <?php
                        $_i = 0;
                        foreach($excursao['embarques'] as $i => $embarque){

                          $horarios_simples = array_unique(array_map(function($_op){
                            // print_r($_op);
                            return $_op['horario'];
                          }, $embarque['horarios']));

                          if(count($horarios_simples) > 1){
                            $horarios_full = array_map(function($_op){
                              $return = array($_op['horario']);
                              foreach($_op['disponibilidade'] as $_disp){
                                if($_disp['status'] === 'disponivel'){
                                  $return[] = $_disp['disp_dia'];
                                }
                              }
                              
                              return $return; // array('hh:mm', 'dd/mm/yyyy', 'dd/mm/yyyy')
                            }, $embarque['horarios']);
                          }
                          ?>

                            <div class="col-6 embarque-box">
                              <div>                              
                                <p class="nome_embarque"><?= $embarque['nome']; ?></p>
                                <div class="endereco_container">
                                  <span><?= aer_icons('pin', 14, 14); ?></span><div class="endereco_embarque"><p>v</p><p><?= $embarque['obs']; ?></p></div>
                                </div>
                                <?php
                                  if(!isset($horarios_full)){
                                    ?>
                                    <div class="d-flex gap-1 horario_container">
                                      <span><?= aer_icons('clock', 12, 12); ?></span><p class="horario_embarque"><?= implode(' - ', $horarios_simples); ?></p>
                                    </div>

                                    <?php
                                  }
                                ?>
                                

                                <?php
                                if(isset($embarque['link_mapa']) && $embarque['link_mapa'] !== "#"){
                                ?>
                                <a href="<?= $embarque['link_mapa']; ?>" target="_blank">
                                  <div class="mapa_container<?= isset($horarios_full) ? ' temMultiplo': ''?>">
                                    <div><?= aer_icons('map', 16, 16); ?></div>
                                    <span>Ver no mapa</span>
                                  </div>
                                </a>
                                
                                <?php
                                }

                                if(isset($horarios_full)){
                                  ?>
                                    <div class="horariosMulti mt-2">
                                      <?php
                                      foreach($horarios_full as $_horario){
                                        ?>
                                        <div class="mt-1">
                                          
                                          <span class="d-block">
                                            <?= aer_icons('calendar', 12, 12); ?><?php foreach($_horario as $_i => $_dia){if($_i > 0){echo ' <b>' . substr($_dia, 0, 5) . '</b> ';}}; ?>
                                          </span>
                                          <span class="horariosMultiHor d-block mt-1"><?= aer_icons('clock', 12, 12); ?><?= $_horario[0]; ?></span>

                                        </div>
                                        <?php
                                      }
                                      ?>
                                    </div>
                                  <?php
                                }
                                ?>

                                
                              </div>
                                
                            </div>

                          <?php
                          $_i = $_i + 1;
                        }
                      ?>
                    </div>
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
              <div class="accordion-item">
                <h3 class="accordion-header" id="infos-headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-item-duvidas" aria-expanded="false" aria-controls="accordion-item-duvidas">
                    Principais dúvidas
                  </button>
                </h3>
                <div id="accordion-item-duvidas" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#infos-accordion">
                  
                </div>
              </div>
              <div class="accordion-item">
                <h3 class="accordion-header" id="infos-headingValores">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#infos-valores" aria-expanded="false" aria-controls="infos-valores">
                    Valores
                  </button>
                </h3>
                <div id="infos-valores" class="accordion-collapse collapse" aria-labelledby="infos-headingValores" data-bs-parent="#infos-accordion">
                <div class="info-exc-box"><p class="mb-0">Selecione seu ponto de embarque na seção de reservas para ver o valor.</p></div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- RESERVA -->
        <div id="reservaBox" class="col-md-5 col center-element reserva-box">

          <!--<div id="bannerRoleta">-->
          <!--  <img class="w-100 mb-1" src="<?= get_stylesheet_directory_uri()?>/assets/banners/banner-roleta.webp" alt="Banner roleta Aerotour">-->
          <!--</div>-->

          <!-- <?php
            if ( has_term( 'rodeios', 'product_cat' ) ) {
              ?>
                <div id="bannerRoleta">
                  <img class="w-100 mb-1" src="<?= get_stylesheet_directory_uri()?>/assets/banners/aerotour-rodeio10.webp" alt="Banner promoção cupom RODEIO10">
                </div>
              <?php
            }
          
          ?> -->

          <!-- <div class="excursao-details position-relative aer-box mt-3 mt-sm-2"> -->
            
            <!-- <h2 class="mb-4">Faça aqui sua reserva</h2> -->

            <!-- RESERVA APP - REACT  -->
            <div id="reserva_app" data-cart-url='<?= wc_get_cart_url(); ?>' data-ajax-url='<?php echo admin_url( 'admin-ajax.php' ); ?>' data-variacoes='<?= json_encode($excursao['variacoes'], JSON_UNESCAPED_UNICODE); ?>' data-embarques='<?= json_encode($excursao['embarques'], JSON_UNESCAPED_UNICODE); ?>' data-product-id='<?= $excursao['id']; ?>'></div>
            <!-- FIM RESERVA APP - REACT  -->
          

        </div>
      </section>
          <div id="exc-wpp-cta" class="desktop">
            <a href="https://api.whatsapp.com/send?phone=5519997477465&text=Olá. Estive no site da Aerotour e gostaria de saber mais sobre a excursão <?= $excursao['nome']; ?>" aria-label="Botão para chamar no WhatsApp">
              <div role="button" class="mt-5">
                <div class="wpp-icon">
                  <?= aer_icons('whatsapp', 30, 30); ?>
                </div>
                <div class="wpp-text">
                  <p>Dúvidas?</p>
                  <span>Fale conosco no WhatsApp!</span>                
                </div>
              </div>
            </a>
          </div>
      <!-- EXCURSÕES RELACIONADAS -->
      <section id="excursoes-relacionadas" class="mt-5 py-md-3">
        <?php 
        $product = wc_get_product(get_the_id());
        $cross_sells = $product -> cross_sell_ids;
        if(sizeof($cross_sells) > 0){
          $relateds = wc_get_products(array(
            'orderby' => 'date',
            'order' => 'DESC',
            'status' => 'publish',
            'include' => $cross_sells,
            'limit' => -1,
          ));
          
          if(sizeof($relateds) > 0){
            aer_cards_slider(aer_proximas_excursoes($relateds), 'Veja também');
          }
        }
        
        ?> 
      </section>

      <div id="social-footer" class="d-flex mt-sm-4 mt-5">
        <div class="instagram-feed col-md-6">
          <h2>Siga a Aerotour</h2>
          <?php
          echo do_shortcode( '[instagram feed="4017"]' );
          ?>
        </div>
        <div id="secaoFotos" col-md-6">
          <h2>Fotos das excursões</h2>
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
      </div>
    </div>

  
  </section>
  <script src="<?php echo get_stylesheet_directory_uri() ?>/js/single-product.js"></script>
<script>
//   const stickyElement = document.querySelector('#mobile-sticky-res-btn');
//   const buttonValores = document.querySelector('.accordion-item:nth-child(3)');

//   const observer = new IntersectionObserver((entries) => {
//       entries.forEach(entry => {
//           if (!entry.isIntersecting && entry.boundingClientRect.top <= 0) {
//             stickyElement.classList.remove('reshow');
//             stickyElement.classList.add('remove');
//           }else if(entry.isIntersecting && entry.boundingClientRect.top <= 0){
//             stickyElement.classList.remove('remove');
//             stickyElement.classList.add('reshow');
//           }
//       });
//   });
// observer.observe(buttonValores);

// stickyElement.addEventListener('click', ({currentTarget}) => {
//   const targetElement = document.querySelector('#reservaBox');
//   setTimeout(() => {currentTarget.classList.remove('reshow'); currentTarget.classList.add('remove')}, 150);
//   setTimeout(() => targetElement.scrollIntoView({behavior: 'smooth', block: 'center'}), 500);
// })

</script>
  

<?php get_footer(); ?>
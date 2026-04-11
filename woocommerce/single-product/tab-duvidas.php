<!-- TAB CONTENT PRINCIPAIS DÚVIDAS -->
<?php
$grupo_escolhido = $args['grupo_escolhido'];
$grupos_faq = get_option('grupos_faq', []);
$grupo_padrao_id = get_option('faq_padrao', '');
?>
<div id="tab3" class="tab-content tab-duvidas">
  <dl id="principaisDuvidasContent">

    <?php
    if ($grupo_escolhido && isset($grupos_faq[$grupo_escolhido])) {
      $items = $grupos_faq[$grupo_escolhido]['itens'];
      foreach ($items as $item):
    ?>
        <dt class="text-start pergunta fw-bold mb-1">• <?= $item['pergunta'] ?></dt>
        <dd class="text-start resposta"><?= $item['resposta'] ?></dd>
      <?php endforeach;
    } else if ($grupo_padrao_id && isset($grupos_faq[$grupo_padrao_id])) {
      // Se não houver grupo escolhido, utiliza grupo padrão
      $items = $grupos_faq[$grupo_padrao_id]['itens'];
      foreach ($items as $item):
      ?>
        <dt class="text-start pergunta fw-bold mb-1">• <?= $item['pergunta'] ?></dt>
        <dd class="text-start resposta"><?= $item['resposta'] ?></dd>
      <?php endforeach;
    } else {
      // Se não houver grupos de FAQ registrados, exibe placeholder
      ?>
      <div id="sem-padrao-placeholder">Nenhum FAQ cadastrado...</div>
    <?php
    }
    ?>

    <!-- <dl id="principaisDuvidasContent">
    <dt class="text-start pergunta fw-bold mb-1">• A excursão inclui ingresso para os eventos??</dt>
    <dd class="text-start resposta">Não. Nós não comercializamos ingressos, a menos que expressamente informado, e recomendamos a compra apenas em pontos de venda autorizados.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• É possível reservar apenas ida ou volta??</dt>
    <dd class="text-start resposta">Sim, porém não há diferenciação nos valores. Cada reserva na excursão representa um lugar reservado por toda a viagem — ida e volta. Você poderá informar durante o processo de reserva se deseja utilizar o transporte em apenas um dos sentidos ou pela viagem toda. Essa informação é importante para controle do embarque de passageiros, mas não impede que o passageiro altere seus planos se precisar.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• Como saber se há disponibilidade de vagas??</dt>
    <dd class="text-start resposta">As vagas são gerenciadas pelo próprio site. Enquanto houver vagas, estará disponível para reservas. Um aviso em amarelo surgirá quando estivermos na últimas vagas, e um aviso em vermelho indicará que as vagas estão esgotadas.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• É preciso encaminhar comprovante de pagamento por e-mail??</dt>
    <dd class="text-start resposta">Não, você não precisa encaminhar nenhum tipo de comprovante após fazer sua reserva com a Aerotour. Você receberá um email de confirmação de reserva e você também poderá vê-la na página "Minhas reservas", na sua área logada aqui no site.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• Como acessar o grupo de WhatsApp da excursão??</dt>
    <dd class="text-start resposta">Os grupos são criados 5 dias antes da data da excursão. Quem reservar antes desse período, receberá um e-mail com o link para acesso assim que o grupo for disponibilizado. Caso contrário, o link será enviado no e-mail de confirmação de reserva. Também será possível acessar o grupo por meio da página <b>Minhas reservas</b>.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• É permitido deixar pertences no veículo??</dt>
    <dd class="text-start resposta">De forma geral, não há impedimentos para quem deseja deixar algum item no interior do veículo durante os eventos. No entanto, não dispomos de serviço de guarda de objetos e não assumimos a responsabilidade por eles. Por isso, não recomendamos que sejam deixados objetos de valor.</dd>
    <dt class="text-start pergunta fw-bold mb-1">• Em qual tipo de veículo será feito o transporte??</dt>
    <dd class="text-start resposta">As excursões podem acontecer em veículos como ônibus e micro-ônibus executivos ou vans. A definição depende da demanda de passageiros para cada excursão, visando garantir a eficiência, conforto e segurança da viagem</dd>
    <dt class="text-start pergunta fw-bold mb-1">• Qual o itinerário da viagem??.</dt>
    <dd class="text-start resposta">Em excursões para São Paulo, organizamos as excursões em duas rotas. Uma delas inclui Sumaré, Hortolândia, Paulínia e Campinas(Unicamp). A outra inclui Salto, Indaiatuba e Campinas (Largo do Pará). Os passageiros de Valinhos, Vinhedo e Jundiaí são acomodados conforme a disponiblidade dos veículos. Para outros destinos, as definições ocorrem de acordo com a rota.</dd>
  </dl> -->
  </dl>
</div>
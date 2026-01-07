<p class="woocommerce-form-row woocommerce-form-row--wide form-row mb-0">
    <label><?= $campo[0]; ?></label>
    <div class="custom-select" id="custom-select">
    <div class="select-input" id="selected">Selecione sua cidade</div>
    <!-- input hidden para envio no form -->
    <input type="hidden" name="<?= $campo[1]; ?>" id="cidade-hidden">
    
    <div class="options-container" id="options">
      <input type="text" class="search-input" id="search" placeholder="Buscar cidade...">
      
      <div class="option-group" id="common-group">
        <div class="option-group-label">Mais escolhidas</div>
        <div class="option highlight">Campinas - SP</div>
        <div class="option highlight">Indaiatuba - SP</div>
        <div class="option highlight">Jundiaí - SP</div>
        <div class="option highlight">Sumaré - SP</div>
        <div class="option highlight">Paulínia - SP</div>
        <div class="option highlight">Hortolândia - SP</div>
      </div>
    
      <div class="option-group-label">Outras cidades</div>
      <div id="all-cities"></div>
    </div>
    </div>
</p>
<style>
    
    .custom-select {
      position: relative;
      width: 320px;
    }
    
    .select-input {
      width: 100%;
      padding: 10px;
      border: 1px solid #bbb;
      border-radius: 8px;
      cursor: pointer;
      background: #fff;
    }
    
    .options-container {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      max-height: 260px;
      overflow-y: auto;
      overflow-x: hidden;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      z-index: 100;
      display: none;
    }
    
    .options-container.active {
      display: block;
    }
    
    .search-input {
      width: 100%;
      padding: 8px;
      border: none;
      border-bottom: 1px solid #ddd;
      outline: none;
    }
    
    .option-group {
      transition: all 0.2s ease;
    }
    
    .option-group-label {
      font-size: 12px;
      color: #666;
      background: #f7f7f7;
      padding: 6px 10px;
      border-bottom: 1px solid #eee;
      font-style: italic;
    }
    
    .option {
      padding: 10px;
      cursor: pointer;
      transition: background 0.2s;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
    
    .option:hover {
      background: #f0f0f0;
    }
    
    .highlight {
      background: #f9f9f9;
      border-left: 3px solid #007bff;
    }
</style>

<script>
  const currentCity = "<?= $value; ?>";
  const selected = document.getElementById('selected');
  const optionsContainer = document.getElementById('options');
  const searchInput = document.getElementById('search');
  const allCitiesContainer = document.getElementById('all-cities');
  const commonGroup = document.getElementById('common-group');
  const customSelect = document.getElementById('custom-select');
  const hiddenInput = document.getElementById('cidade-hidden');

  const cities = [
  "Adamantina - SP",
  "Adolfo - SP",
  "Aguaí - SP",
  "Águas da Prata - SP",
  "Águas de Lindóia - SP",
  "Águas de Santa Bárbara - SP",
  "Águas de São Pedro - SP",
  "Agudos - SP",
  "Alambari - SP",
  "Alfredo Marcondes - SP",
  "Altair - SP",
  "Altinópolis - SP",
  "Alto Alegre - SP",
  "Alumínio - SP",
  "Álvares Florence - SP",
  "Álvares Machado - SP",
  "Álvaro de Carvalho - SP",
  "Alvinlândia - SP",
  "Americana - SP",
  "Amparo - SP",
  "Analândia - SP",
  "Andradina - SP",
  "Angatuba - SP",
  "Anhembi - SP",
  "Anhumas - SP",
  "Aparecida - SP",
  "Aparecida d'Oeste - SP",
  "Apiaí - SP",
  "Araçariguama - SP",
  "Araçatuba - SP",
  "Araçoiaba da Serra - SP",
  "Aramina - SP",
  "Arandu - SP",
  "Arapeí - SP",
  "Araraquara - SP",
  "Araras - SP",
  "Arco-Íris - SP",
  "Arealva - SP",
  "Areias - SP",
  "Areiópolis - SP",
  "Ariranha - SP",
  "Artur Nogueira - SP",
  "Arujá - SP",
  "Aspásia - SP",
  "Assis - SP",
  "Atibaia - SP",
  "Auriflama - SP",
  "Avaí - SP",
  "Avanhandava - SP",
  "Avaré - SP",
  "Bady Bassitt - SP",
  "Balbinos - SP",
  "Bálsamo - SP",
  "Bananal - SP",
  "Barão de Antonina - SP",
  "Barbosa - SP",
  "Bariri - SP",
  "Barra Bonita - SP",
  "Barra do Chapéu - SP",
  "Barra do Turvo - SP",
  "Barretos - SP",
  "Barrinha - SP",
  "Barueri - SP",
  "Bastos - SP",
  "Batatais - SP",
  "Bauru - SP",
  "Bebedouro - SP",
  "Bento de Abreu - SP",
  "Bernardino de Campos - SP",
  "Bertioga - SP",
  "Bilac - SP",
  "Birigui - SP",
  "Biritiba Mirim - SP",
  "Boa Esperança do Sul - SP",
  "Bocaina - SP",
  "Bofete - SP",
  "Boituva - SP",
  "Bom Jesus dos Perdões - SP",
  "Bom Sucesso de Itararé - SP",
  "Borá - SP",
  "Boracéia - SP",
  "Borborema - SP",
  "Borebi - SP",
  "Botucatu - SP",
  "Bragança Paulista - SP",
  "Braúna - SP",
  "Brejo Alegre - SP",
  "Brodowski - SP",
  "Brotas - SP",
  "Buri - SP",
  "Buritama - SP",
  "Buritizal - SP",
  "Cabrália Paulista - SP",
  "Cabreúva - SP",
  "Caçapava - SP",
  "Cachoeira Paulista - SP",
  "Caconde - SP",
  "Cafelândia - SP",
  "Caiabu - SP",
  "Caieiras - SP",
  "Caiuá - SP",
  "Cajamar - SP",
  "Cajati - SP",
  "Cajobi - SP",
  "Cajuru - SP",
  "Campina do Monte Alegre - SP",
  "Campinas - SP",
  "Campo Limpo Paulista - SP",
  "Campos do Jordão - SP",
  "Campos Novos Paulista - SP",
  "Cananéia - SP",
  "Canas - SP",
  "Cândido Mota - SP",
  "Cândido Rodrigues - SP",
  "Canitar - SP",
  "Capão Bonito - SP",
  "Capela do Alto - SP",
  "Capivari - SP",
  "Caraguatatuba - SP",
  "Carapicuíba - SP",
  "Cardoso - SP",
  "Casa Branca - SP",
  "Cássia dos Coqueiros - SP",
  "Castilho - SP",
  "Catanduva - SP",
  "Catiguá - SP",
  "Cedral - SP",
  "Cerqueira César - SP",
  "Cerquilho - SP",
  "Cesário Lange - SP",
  "Charqueada - SP",
  "Chavantes - SP",
  "Clementina - SP",
  "Colina - SP",
  "Colômbia - SP",
  "Conchal - SP",
  "Conchas - SP",
  "Cordeirópolis - SP",
  "Coroados - SP",
  "Coronel Macedo - SP",
  "Corumbataí - SP",
  "Cosmópolis - SP",
  "Cosmorama - SP",
  "Cotia - SP",
  "Cravinhos - SP",
  "Cristais Paulista - SP",
  "Cruzália - SP",
  "Cruzeiro - SP",
  "Cubatão - SP",
  "Cunha - SP",
  "Descalvado - SP",
  "Diadema - SP",
  "Dirce Reis - SP",
  "Divinolândia - SP",
  "Dobrada - SP",
  "Dois Córregos - SP",
  "Dolcinópolis - SP",
  "Dourado - SP",
  "Dracena - SP",
  "Duartina - SP",
  "Dumont - SP",
  "Echaporã - SP",
  "Eldorado - SP",
  "Elias Fausto - SP",
  "Elisiário - SP",
  "Embaúba - SP",
  "Embu das Artes - SP",
  "Embu-Guaçu - SP",
  "Emilianópolis - SP",
  "Engenheiro Coelho - SP",
  "Espírito Santo do Pinhal - SP",
  "Espírito Santo do Turvo - SP",
  "Estiva Gerbi - SP",
  "Estrela d'Oeste - SP",
  "Estrela do Norte - SP",
  "Euclides da Cunha Paulista - SP",
  "Fartura - SP",
  "Fernandópolis - SP",
  "Fernando Prestes - SP",
  "Fernão - SP",
  "Ferraz de Vasconcelos - SP",
  "Flora Rica - SP",
  "Floreal - SP",
  "Flórida Paulista - SP",
  "Florínea - SP",
  "Franca - SP",
  "Francisco Morato - SP",
  "Franco da Rocha - SP",
  "Gabriel Monteiro - SP",
  "Gália - SP",
  "Garça - SP",
  "Gastão Vidigal - SP",
  "Gavião Peixoto - SP",
  "General Salgado - SP",
  "Getulina - SP",
  "Glicério - SP",
  "Guaiçara - SP",
  "Guaimbê - SP",
  "Guaíra - SP",
  "Guapiaçu - SP",
  "Guapiara - SP",
  "Guará - SP",
  "Guaraçaí - SP",
  "Guaraci - SP",
  "Guarani d'Oeste - SP",
  "Guarantã - SP",
  "Guararapes - SP",
  "Guararema - SP",
  "Guaratinguetá - SP",
  "Guareí - SP",
  "Guariba - SP",
  "Guarujá - SP",
  "Guarulhos - SP",
  "Guatapará - SP",
  "Guzolândia - SP",
  "Herculândia - SP",
  "Holambra - SP",
  "Hortolândia - SP",
  "Iacanga - SP",
  "Iacri - SP",
  "Iaras - SP",
  "Ibaté - SP",
  "Ibirá - SP",
  "Ibirarema - SP",
  "Ibitinga - SP",
  "Ibiúna - SP",
  "Icém - SP",
  "Iepê - SP",
  "Igaraçu do Tietê - SP",
  "Igarapava - SP",
  "Igaratá - SP",
  "Iguape - SP",
  "Ilha Comprida - SP",
  "Ilha Solteira - SP",
  "Ilhabela - SP",
  "Indaiatuba - SP",
  "Indiana - SP",
  "Indiaporã - SP",
  "Inúbia Paulista - SP",
  "Ipaussu - SP",
  "Iperó - SP",
  "Ipeúna - SP",
  "Ipiguá - SP",
  "Iporanga - SP",
  "Ipuã - SP",
  "Iracemápolis - SP",
  "Irapuã - SP",
  "Irapuru - SP",
  "Itaberá - SP",
  "Itaí - SP",
  "Itajobi - SP",
  "Itaju - SP",
  "Itanhaém - SP",
  "Itaóca - SP",
  "Itapecerica da Serra - SP",
  "Itapetininga - SP",
  "Itapeva - SP",
  "Itapevi - SP",
  "Itapira - SP",
  "Itapirapuã Paulista - SP",
  "Itápolis - SP",
  "Itaporanga - SP",
  "Itapuí - SP",
  "Itapura - SP",
  "Itaquaquecetuba - SP",
  "Itararé - SP",
  "Itariri - SP",
  "Itatiba - SP",
  "Itatinga - SP",
  "Itirapina - SP",
  "Itirapuã - SP",
  "Itobi - SP",
  "Itu - SP",
  "Itupeva - SP",
  "Ituverava - SP",
  "Jaborandi - SP",
  "Jaboticabal - SP",
  "Jacareí - SP",
  "Jaci - SP",
  "Jacupiranga - SP",
  "Jaguariúna - SP",
  "Jales - SP",
  "Jambeiro - SP",
  "Jandira - SP",
  "Jardinópolis - SP",
  "Jarinu - SP",
  "Jaú - SP",
  "Jeriquara - SP",
  "Joanópolis - SP",
  "João Ramalho - SP",
  "José Bonifácio - SP",
  "Júlio Mesquita - SP",
  "Jumirim - SP",
  "Jundiaí - SP",
  "Junqueirópolis - SP",
  "Juquiá - SP",
  "Juquitiba - SP",
  "Lagoinha - SP",
  "Laranjal Paulista - SP",
  "Lavínia - SP",
  "Lavrinhas - SP",
  "Leme - SP",
  "Lençóis Paulista - SP",
  "Limeira - SP",
  "Lindóia - SP",
  "Lins - SP",
  "Lorena - SP",
  "Lourdes - SP",
  "Louveira - SP",
  "Lucélia - SP",
  "Lucianópolis - SP",
  "Luís Antônio - SP",
  "Luiziânia - SP",
  "Lupércio - SP",
  "Lutécia - SP",
  "Macatuba - SP",
  "Macaubal - SP",
  "Macedônia - SP",
  "Magda - SP",
  "Mairinque - SP",
  "Mairiporã - SP",
  "Manduri - SP",
  "Marabá Paulista - SP",
  "Maracaí - SP",
  "Marapoama - SP",
  "Mariápolis - SP",
  "Marília - SP",
  "Marinópolis - SP",
  "Martinópolis - SP",
  "Matão - SP",
  "Mauá - SP",
  "Mendonça - SP",
  "Meridiano - SP",
  "Mesópolis - SP",
  "Miguelópolis - SP",
  "Mineiros do Tietê - SP",
  "Mira Estrela - SP",
  "Miracatu - SP",
  "Mirandópolis - SP",
  "Mirante do Paranapanema - SP",
  "Mirassol - SP",
  "Mirassolândia - SP",
  "Mococa - SP",
  "Mogi das Cruzes - SP",
  "Mogi Guaçu - SP",
  "Mogi Mirim - SP",
  "Mombuca - SP",
  "Monções - SP",
  "Mongaguá - SP",
  "Monte Alegre do Sul - SP",
  "Monte Alto - SP",
  "Monte Aprazível - SP",
  "Monte Azul Paulista - SP",
  "Monte Castelo - SP",
  "Monte Mor - SP",
  "Monteiro Lobato - SP",
  "Morro Agudo - SP",
  "Morungaba - SP",
  "Motuca - SP",
  "Murutinga do Sul - SP",
  "Nantes - SP",
  "Narandiba - SP",
  "Natividade da Serra - SP",
  "Nazaré Paulista - SP",
  "Neves Paulista - SP",
  "Nhandeara - SP",
  "Nipoã - SP",
  "Nova Aliança - SP",
  "Nova Campina - SP",
  "Nova Canaã Paulista - SP",
  "Nova Castilho - SP",
  "Nova Europa - SP",
  "Nova Granada - SP",
  "Nova Guataporanga - SP",
  "Nova Independência - SP",
  "Nova Luzitânia - SP",
  "Nova Odessa - SP",
  "Novais - SP",
  "Novo Horizonte - SP",
  "Nuporanga - SP",
  "Ocauçu - SP",
  "Óleo - SP",
  "Olímpia - SP",
  "Onda Verde - SP",
  "Oriente - SP",
  "Orindiúva - SP",
  "Orlândia - SP",
  "Osasco - SP",
  "Oscar Bressane - SP",
  "Osvaldo Cruz - SP",
  "Ourinhos - SP",
  "Ouro Verde - SP",
  "Ouroeste - SP",
  "Pacaembu - SP",
  "Palestina - SP",
  "Palmares Paulista - SP",
  "Palmeira d'Oeste - SP",
  "Palmital - SP",
  "Panorama - SP",
  "Paraguaçu Paulista - SP",
  "Paraibuna - SP",
  "Paraíso - SP",
  "Paranapanema - SP",
  "Paranapuã - SP",
  "Parapuã - SP",
  "Pardinho - SP",
  "Pariquera-Açu - SP",
  "Parisi - SP",
  "Patrocínio Paulista - SP",
  "Paulicéia - SP",
  "Paulínia - SP",
  "Paulistânia - SP",
  "Paulo de Faria - SP",
  "Pederneiras - SP",
  "Pedra Bela - SP",
  "Pedranópolis - SP",
  "Pedregulho - SP",
  "Pedreira - SP",
  "Pedrinhas Paulista - SP",
  "Pedro de Toledo - SP",
  "Penápolis - SP",
  "Pereira Barreto - SP",
  "Pereiras - SP",
  "Peruíbe - SP",
  "Piacatu - SP",
  "Piedade - SP",
  "Pilar do Sul - SP",
  "Pindamonhangaba - SP",
  "Pindorama - SP",
  "Pinhalzinho - SP",
  "Piquerobi - SP",
  "Piquete - SP",
  "Piracaia - SP",
  "Piracicaba - SP",
  "Piraju - SP",
  "Pirajuí - SP",
  "Pirangi - SP",
  "Pirapora do Bom Jesus - SP",
  "Pirapozinho - SP",
  "Pirassununga - SP",
  "Piratininga - SP",
  "Pitangueiras - SP",
  "Planalto - SP",
  "Platina - SP",
  "Poá - SP",
  "Poloni - SP",
  "Pompéia - SP",
  "Pongaí - SP",
  "Pontal - SP",
  "Pontalinda - SP",
  "Pontes Gestal - SP",
  "Populina - SP",
  "Porangaba - SP",
  "Porto Feliz - SP",
  "Porto Ferreira - SP",
  "Potim - SP",
  "Potirendaba - SP",
  "Pracinha - SP",
  "Pradópolis - SP",
  "Praia Grande - SP",
  "Pratânia - SP",
  "Presidente Alves - SP",
  "Presidente Bernardes - SP",
  "Presidente Epitácio - SP",
  "Presidente Prudente - SP",
  "Presidente Venceslau - SP",
  "Promissão - SP",
  "Quadra - SP",
  "Quatá - SP",
  "Queiroz - SP",
  "Queluz - SP",
  "Quintana - SP",
  "Rafard - SP",
  "Rancharia - SP",
  "Redenção da Serra - SP",
  "Regente Feijó - SP",
  "Reginópolis - SP",
  "Registro - SP",
  "Restinga - SP",
  "Ribeira - SP",
  "Ribeirão Bonito - SP",
  "Ribeirão Branco - SP",
  "Ribeirão Corrente - SP",
  "Ribeirão do Sul - SP",
  "Ribeirão dos Índios - SP",
  "Ribeirão Grande - SP",
  "Ribeirão Pires - SP",
  "Ribeirão Preto - SP",
  "Rifaina - SP",
  "Rincão - SP",
  "Rinópolis - SP",
  "Rio Claro - SP",
  "Rio das Pedras - SP",
  "Rio Grande da Serra - SP",
  "Riolândia - SP",
  "Riversul - SP",
  "Rosana - SP",
  "Roseira - SP",
  "Rubiácea - SP",
  "Rubinéia - SP",
  "Sabino - SP",
  "Sagres - SP",
  "Sales - SP",
  "Sales Oliveira - SP",
  "Salesópolis - SP",
  "Salmourão - SP",
  "Saltinho - SP",
  "Salto - SP",
  "Salto de Pirapora - SP",
  "Salto Grande - SP",
  "Sandovalina - SP",
  "Santa Adélia - SP",
  "Santa Albertina - SP",
  "Santa Bárbara d'Oeste - SP",
  "Santa Branca - SP",
  "Santa Clara d'Oeste - SP",
  "Santa Cruz da Conceição - SP",
  "Santa Cruz da Esperança - SP",
  "Santa Cruz das Palmeiras - SP",
  "Santa Cruz do Rio Pardo - SP",
  "Santa Ernestina - SP",
  "Santa Fé do Sul - SP",
  "Santa Gertrudes - SP",
  "Santa Isabel - SP",
  "Santa Lúcia - SP",
  "Santa Maria da Serra - SP",
  "Santa Mercedes - SP",
  "Santa Rita d'Oeste - SP",
  "Santa Rita do Passa Quatro - SP",
  "Santa Rosa de Viterbo - SP",
  "Santa Salete - SP",
  "Santana da Ponte Pensa - SP",
  "Santana de Parnaíba - SP",
  "Santo Anastácio - SP",
  "Santo André - SP",
  "Santo Antônio da Alegria - SP",
  "Santo Antônio de Posse - SP",
  "Santo Antônio do Aracanguá - SP",
  "Santo Antônio do Jardim - SP",
  "Santo Antônio do Pinhal - SP",
  "Santo Expedito - SP",
  "Santópolis do Aguapeí - SP",
  "Santos - SP",
  "São Bento do Sapucaí - SP",
  "São Bernardo do Campo - SP",
  "São Caetano do Sul - SP",
  "São Carlos - SP",
  "São Francisco - SP",
  "São João da Boa Vista - SP",
  "São João das Duas Pontes - SP",
  "São João de Iracema - SP",
  "São João do Pau d'Alho - SP",
  "São Joaquim da Barra - SP",
  "São José da Bela Vista - SP",
  "São José do Barreiro - SP",
  "São José do Rio Pardo - SP",
  "São José do Rio Preto - SP",
  "São José dos Campos - SP",
  "São Lourenço da Serra - SP",
  "São Luís do Paraitinga - SP",
  "São Manuel - SP",
  "São Miguel Arcanjo - SP",
  "São Paulo - SP",
  "São Pedro - SP",
  "São Pedro do Turvo - SP",
  "São Roque - SP",
  "São Sebastião - SP",
  "São Sebastião da Grama - SP",
  "São Simão - SP",
  "São Vicente - SP",
  "Sarapuí - SP",
  "Sarutaiá - SP",
  "Sebastianópolis do Sul - SP",
  "Serra Azul - SP",
  "Serra Negra - SP",
  "Serrana - SP",
  "Sertãozinho - SP",
  "Sete Barras - SP",
  "Severínia - SP",
  "Silveiras - SP",
  "Socorro - SP",
  "Sorocaba - SP",
  "Sud Mennucci - SP",
  "Sumaré - SP",
  "Suzanápolis - SP",
  "Suzano - SP",
  "Tabapuã - SP",
  "Tabatinga - SP",
  "Taboão da Serra - SP",
  "Taciba - SP",
  "Taguaí - SP",
  "Taiaçu - SP",
  "Taiúva - SP",
  "Tambaú - SP",
  "Tanabi - SP",
  "Tapiraí - SP",
  "Tapiratiba - SP",
  "Taquaral - SP",
  "Taquaritinga - SP",
  "Taquarituba - SP",
  "Taquarivaí - SP",
  "Tarabai - SP",
  "Tarumã - SP",
  "Tatuí - SP",
  "Taubaté - SP",
  "Tejupá - SP",
  "Teodoro Sampaio - SP",
  "Terra Roxa - SP",
  "Tietê - SP",
  "Timburi - SP",
  "Torre de Pedra - SP",
  "Torrinha - SP",
  "Trabiju - SP",
  "Tremembé - SP",
  "Três Fronteiras - SP",
  "Tuiuti - SP",
  "Tupã - SP",
  "Tupi Paulista - SP",
  "Turiúba - SP",
  "Turmalina - SP",
  "Ubarana - SP",
  "Ubatuba - SP",
  "Ubirajara - SP",
  "Uchoa - SP",
  "União Paulista - SP",
  "Urânia - SP",
  "Uru - SP",
  "Urupês - SP",
  "Valentim Gentil - SP",
  "Valinhos - SP",
  "Valparaíso - SP",
  "Vargem - SP",
  "Vargem Grande do Sul - SP",
  "Vargem Grande Paulista - SP",
  "Várzea Paulista - SP",
  "Vera Cruz - SP",
  "Vinhedo - SP",
  "Viradouro - SP",
  "Vista Alegre do Alto - SP",
  "Vitória Brasil - SP",
  "Votorantim - SP",
  "Votuporanga - SP",
  "Zacarias - SP"
];

  
    console.log(currentCity);

  function renderCities(filter = "") {
    allCitiesContainer.innerHTML = "";
    cities
      .filter(city => city.toLowerCase().includes(filter.toLowerCase()))
      .forEach(city => {
        const div = document.createElement("div");
        div.classList.add("option");
        div.textContent = city;
        div.onclick = () => selectOption(city);
        allCitiesContainer.appendChild(div);
      });

    // Exibir ou esconder grupo "Mais escolhidas"
    commonGroup.style.display = filter.trim() !== "" ? "none" : "block";
  }

  function selectOption(city) {
    selected.textContent = city;
    hiddenInput.value = city; // atualiza o valor do hidden input
    optionsContainer.classList.remove("active");
  }

  // Ativa opções fixas também
  document.querySelectorAll("#common-group .option").forEach(opt => {
    opt.onclick = () => selectOption(opt.textContent);
  });

  selected.onclick = () => {
    optionsContainer.classList.toggle("active");
    searchInput.value = "";
    renderCities();
    searchInput.focus();
  };

  searchInput.oninput = () => renderCities(searchInput.value);

  // Fecha ao clicar fora
  document.addEventListener("click", (event) => {
    if (!customSelect.contains(event.target)) {
      optionsContainer.classList.remove("active");
    }
  });
  
  //Preenche se já houver valor
  if(currentCity != "") selectOption(currentCity);

  // Inicializa lista
  renderCities();
</script>


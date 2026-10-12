<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 400" width="100%" height="100%">
  <defs>
    <style>
      .body { fill: #000000; }
      .window { fill: #ffffff; }
      .wheel-out { fill: #ffffff; }
      .wheel-in { fill: #000000; }
      .wheel-rim { fill: #cccccc; }
      .detail { fill: #ffffff; }
      .taillight { fill: #ffffff; }
    </style>
  </defs>

  <!-- Corpo do Ônibus (Silhueta Principal) -->
  <path class="body" d="M 60,300 C 60,320 70,330 90,330 L 130,330 C 130,330 140,360 170,360 C 200,360 210,330 210,330 L 590,330 C 590,330 600,360 630,360 C 660,360 670,330 670,330 L 710,330 C 730,330 740,320 740,300 L 740,150 C 740,100 700,70 650,70 L 150,70 C 100,70 60,100 60,150 Z" />

  <!-- Rodas e Arcos (Vazados e Pneus) -->
  <circle class="wheel-out" cx="170" cy="330" r="38" />
  <circle class="wheel-in" cx="170" cy="330" r="30" />
  <circle class="wheel-rim" cx="170" cy="330" r="14" />

  <circle class="wheel-out" cx="630" cy="330" r="38" />
  <circle class="wheel-in" cx="630" cy="330" r="30" />
  <circle class="wheel-rim" cx="630" cy="330" r="14" />

  <!-- Janelas (Perfil Lateral) -->
  <!-- Janela do Motorista -->
  <path class="window" d="M 75,160 L 130,160 L 125,90 L 95,110 Z" />
  
  <!-- Janelas dos Passageiros -->
  <rect class="window" x="145" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="225" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="305" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="385" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="465" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="545" y="90" width="70" height="70" rx="4" />
  <rect class="window" x="625" y="90" width="50" height="70" rx="4" />

  <!-- Detalhes de Lataria (Faixas) -->
  <rect class="detail" x="70" y="240" width="660" height="4" />
  <rect class="detail" x="70" y="250" width="660" height="4" />

  <!-- Faróis Dianteiros -->
  <circle class="detail" cx="75" cy="280" r="8" />
  <circle class="detail" cx="95" cy="280" r="8" />
  
  <!-- Lanterna Traseira -->
  <rect class="taillight" x="730" y="275" width="10" height="15" rx="2" />
</svg>
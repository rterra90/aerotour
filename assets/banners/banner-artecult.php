<style>
    /* Variáveis e Cores */
  :root {
    --ac-accent-color: #DC9A3A; /* Cor da borda e destaque */
      /* --slide-duration: 4s; Duração de exibição de cada slide */
  }
  .artecult-banner-container {
    display: block;
    overflow: hidden;
    background-color: #f9f9f9;
    border: 1px solid #ddd; /* Borda sutil para contexto */
    text-decoration: none; /* Remove sublinhado do link */
    cursor: pointer;
    box-shadow: inset 0 0 0 2px var(--ac-accent-color);
    display: block;
    margin: -4px auto 0;
    user-select: none;
  }

  /* Tamanho Desktop (728x90) */
  .artecult-banner-container {
      width: 728px;
      height: 90px;
  }

  /* Tamanho Mobile (320x50) */
  @media (max-width: 767px) {
      .artecult-banner-container {
          /* width: 320px; */
          height: 74px; 
          width: 100%;
      }
      #topAdBanner{
        width: 100%;
      }
  }


  .color-accent { color: var(--ac-accent-color); }
  .weight-bold { font-weight: 700; }
  .text-center { text-align: center; }
  .text-right { text-align: right; }

  .banner-inner {
      width: 100%;
      height: 100%;
      position: relative;
  }

  .banner-slide {
      position: absolute;
      top: 0;
      left: 0;
    box-sizing: border-box;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center; /* Alinha todo o conteúdo verticalmente */
      opacity: 0;
      pointer-events: none; /* Desativa interação em slides inativos */
      transition: opacity 0.5s ease-in-out;
      padding: 0 10px; /* Pequeno respiro lateral */
  }

  .banner-slide.active {
      opacity: 1;
      pointer-events: auto; /* Permite interação no slide ativo */
  }

  /* --- Layout dos Componentes --- */

  /* Logo (728x90) */
  .banner-logo {
      flex-shrink: 0; /* Não permite encolher */
      height: 100%;
      display: flex;
      align-items: center;
      padding-right: 15px; /* Espaço entre logo e texto */
  }
  .banner-logo img {
      height: 80%; /* Altura do logo */
      width: auto;
  }

  /* Texto (728x90) */
  .banner-text {
      flex-grow: 1; /* Ocupa o espaço restante */
      display: flex;
      flex-direction: column;
      justify-content: center;
      line-height: 1.2;
  }
  .banner-text p {
      margin: 0;
      color: #333;
      font-weight: 300; /* Leve */
      text-transform: uppercase;
      /* Configuração inicial para animação de slide-in */
      transform: translateY(100%);
      opacity: 0;
      transition: transform 0.4s ease-out, opacity 0.4s ease-out;
  }

  .banner-text .line-1 {
      font-size: 1.15rem;
  }
  .banner-text .line-2 {
      font-size: 1rem;
  }
  .banner-text .smaller-text {
      font-size: .9rem; /* Para a CTA */
      font-weight: 400;
  }
  .banner-text .line-2 span{
      background-color: var(--ac-accent-color);
      padding: 1px 2px;
      color: #F9F9F9;
      font-weight: 500;
      white-space: nowrap;
  }
  /* Animação do Texto - Somente no slide ATIVO */
  .banner-slide.active .banner-text p {
      transform: translateY(0);
      opacity: 1;
  }

  /* Delay para a segunda linha animar após a primeira (efeito cascata) */
  .banner-slide.active .banner-text .line-2 {
      transition-delay: 0.1s;
  }

  /* --- Responsividade Mobile (320x50) --- */

  @media (max-width: 767px) {
      .banner-logo {
          padding-right: 8px;
          width: 60px;
          height: 60px;
      }
      .banner-logo img {
          height: 70%;
      }

      .banner-text .line-1 {
          font-size: 1rem;
      }
      .banner-2 .banner-text {
          max-width: 400px;
          margin: 0 auto;
      }
      .banner-2 .banner-text .line-1 {
          font-size: .9rem;
      }
      .banner-text .line-2 {
          font-size: .775rem;
      }
      .banner-text .smaller-text {
          font-size: .65rem;
      }
  }
</style>

<a id="arteCultBanner" class="artecult-banner-container">
    <div class="banner-inner">
        <div class="banner-slide active banner-1" data-animation-delay="0.2s">
            <div class="banner-logo">
                <img src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/parceiros/artecult.webp" alt="ArteCult Logo">
            </div>
            <div class="banner-text text-center">
                <p class="line-1">Seu site sobre</p>
                <p class="line-2 color-accent weight-bold">Arte, conhecimento e transformação</p>
            </div>
        </div>

        <div class="banner-slide banner-2" data-animation-delay="0.2s">
            <div class="banner-logo">
                <img src="https://aerotour.com.br/wp-content/themes/Aerotour/assets/images/parceiros/artecult.webp" alt="ArteCult Logo">
            </div>
            <div class="banner-text">
                <p class="line-1">A ArteCult é parceira da Aerotour</p>
                <p class="line-2 color-accent text-right smaller-text">Clique e saiba como ganhar um <span>cupom exclusivo</span></p>
            </div>
        </div>
    </div>
</a>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.banner-slide');
    if (slides.length < 2) return; // Precisa de pelo menos 2 slides

    let currentSlide = 0;
    const slideDuration = 4000; // 4 segundos

    function showSlide(index) {
        // Remove a classe 'active' de todos os slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });

        // Adiciona a classe 'active' ao slide atual
        slides[index].classList.add('active');

        // Calcula o próximo slide
        currentSlide = (index + 1) % slides.length;
    }

    // Inicia o ciclo de slides
    function startBannerCycle() {
        showSlide(currentSlide);
        setInterval(() => {
            showSlide(currentSlide);
        }, slideDuration);
    }

    // Começa o ciclo assim que o DOM carregar
    startBannerCycle();

    const arteCultbanner = document.querySelector('#arteCultBanner');
    arteCultbanner.addEventListener('click', () => {
        //Instancia um novo modal
        const modalElement = new Modal('generalModal', '.modal-content-body');
        modalElement.open('promoArteCult', {rootUrl: '<?= get_stylesheet_directory_uri(); ?>'});

        //Registra evento no Google Analytics
        gtag('event', 'click_banner_artecult', {
            'event_category': 'ads',
            'event_label': 'click_banner_artecult',
            'value': 1
        })

    })
});
</script>
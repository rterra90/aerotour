<div id="tab1" class="rir-features-wrapper tab-content tab-como-funciona active">
  <div class="rir-features-flex">
    <div class="rir-feature-box">

      <h4>Transporte Premium</h4>
      <p>Ida e volta em ônibus <strong>semileito</strong> moderno, com banheiro, ar-condicionado e USB.</p>
    </div>

    <div class="rir-feature-box">

      <h4>Segurança Total</h4>
      <p><strong>Seguro Viagem</strong> incluso para todos os passageiros.</p>
    </div>

    <div class="rir-feature-box">

      <h4>Experiência VIP</h4>
      <p>Monitoria dedicada e suporte especializado no evento.</p>
    </div>
  </div>

  <div class="rir-extra-info">
    <ul class="rir-info-list">
      <li><i class="rir-dot"></i> Água cortesia a bordo durante o trajeto.</li>
      <li><i class="rir-dot"></i> Grupo exclusivo de WhatsApp para comunicação e avisos.</li>
      <li><i class="rir-dot"></i> Parada estratégica para alimentação durante a viagem.</li>
      <li><i class="rir-dot"></i> Estacionamento próximo ao local do evento.</li>
      <li><i class="rir-dot"></i> Assistência remota durante toda a permanência no Rio.</li>
      <li><i class="rir-dot"></i> Retorno em até 1h após o término do último show do Palco Mundo.</li>
    </ul>

    <!-- <p class="rir-disclaimer">
      <small>* O desembarque e estacionamento no local dependem das orientações dos órgãos de trânsito locais.</small>
    </p> -->
  </div>
</div>

<style>
  .tab-content.rir-features-wrapper {
    max-height: unset;
  }

  /* Estilização rápida para garantir o visual moderno */
  .rir-features-flex {
    display: flex;
    gap: 16px;
    flex-direction: column;
    margin-bottom: 20px;
    cursor: default;
  }

  .rir-feature-box {
    background: #f9f9f9;
    padding: 16px 16px 16px 32px;
    position: relative;
    border-radius: 12px;
    border: 1px solid #eee;
    transition: transform 0.3s ease;
    box-shadow: 0px 0px 4px 2px #f0f0f0;
  }

  .rir-feature-box:hover {
    box-shadow: 0px 0px 2px 2px #f0f0f0;
    transform: translateY(-3px);
    /* box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05); */
    /* background-color: var(--aer-accent); */
    border: none;
    background: #f6f6f6;
  }

  .rir-feature-box::before {
    content: '';
    display: block;
    width: 2px;
    height: 60%;
    background: var(--aer-accent);
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
  }

  .rir-feature-box p {
    margin-bottom: 0;
        font-size: .95rem;
  }

  .rir-feature-box strong,
  .rir-feature-box h4 {
    color: var(--aer-accent);
  }



  .rir-feature-box h4 {
    font-size: 1.25rem;
  }

  .rir-section-title {
    margin-bottom: 25px;
    font-weight: 700;
    color: #111;
  }

  .rir-info-list {
    list-style: none;
    padding: 0;
  }

  .rir-info-list li {
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    align-items: center;
  }

  .rir-dot {
    width: 8px;
    height: 8px;
    background: var(--aer-accent);
    /* Cor de destaque (pode ser a cor do RIR) */
    border-radius: 50%;
    margin-right: 15px;
    flex-shrink: 0;
  }

  .rir-disclaimer {
    margin-top: 20px;
    color: #666;
    font-style: italic;
  }
</style>
/**
 * Classe Modal: Responsável por gerenciar a exibição e o conteúdo de um modal.
 */
class Modal {
  // #modalElement é uma propriedade privada para armazenar a referência ao elemento DOM do modal.
  #modalElement;
  #contentContainer;
  /**
   * Construtor da classe Modal.
   * @param {string} modalId - O ID do elemento HTML que serve como contêiner principal do modal.
   * @param {string} contentSelector - O seletor CSS para o elemento dentro do modal onde o conteúdo será injetado.
   */
  constructor(
    modalId = 'generalModal',
    contentSelector = '.modal-content-body',
  ) {
    // Busca e armazena a referência ao elemento modal principal
    this.#modalElement = document.getElementById(modalId);
    if (!this.#modalElement) {
      throw new Error(`Elemento modal com ID "${modalId}" não encontrado.`);
    }

    // Busca e armazena a referência ao contêiner de conteúdo
    this.#contentContainer = this.#modalElement.querySelector(contentSelector);
    if (!this.#contentContainer) {
      throw new Error(
        `Contêiner de conteúdo com seletor "${contentSelector}" não encontrado dentro do modal.`,
      );
    }

    // Adiciona um listener para fechar o modal quando clicar no botão de fechar (opcional)
    // Você pode adaptar isso (ex: fechar ao clicar fora, etc.)
    const closeButton = this.#modalElement.querySelector('.close-button');
    if (closeButton) {
      closeButton.addEventListener('click', () => this.close());
    }

    // Adiciona um listener para fechar o modal ao pressionar 'Escape'
    document.addEventListener('keydown', (event) => {
      if (
        event.key === 'Escape' &&
        this.#modalElement.classList.contains('open')
      ) {
        this.close();
      }
    });

    // Opcional: Fechar ao clicar fora do conteúdo
    this.#modalElement.addEventListener('click', (event) => {
      // Se o clique foi no próprio backdrop (o elemento modal principal)
      if (event.target === this.#modalElement) {
        this.close();
      }
    });
  }

  /**
   * Método privado para renderizar o conteúdo com base no tipo.
   * @param {string} contentType - O tipo de conteúdo (ex: 'alerta', 'confirmacao', 'info').
   * @param {Object} data - Dados adicionais a serem usados na renderização.
   * @returns {string} O HTML gerado.
   */
  #renderContent(contentType, data = {}) {
    let html = '';
    const title = data.title || 'Título Padrão';
    const bodyText = data.body || null;
    const rootUrl = data.rootUrl || null;
    const nomeParceiro = data.nomeParceiro || null;

    // Lógica de Condicionamento de Conteúdo
    switch (contentType) {
      case 'promoArteCult':
        {
          html = `  <div class="artecult-promo">
                    <h3 class="modal-title alert-title">Cupom ArteCult + Aerotour</h3>
                    <p>Quer ganhar um cupom exclusivo e garantir 10% de desconto na reserva da sua excursão? Veja como é fácil!</p>
                    <ul>
                    <li><div>Siga as páginas da Aerotour <a href="https://instagram.com/aerotour_excursoes" target="_blank" aria-label="Link para seguir a Aerotour">(@aerotour_excursoes)</a>, ArteCult <a href="https://instagram.com/artecult" target="_blank" aria-label="Link para seguir a ArteCult">(@artecult)</a> e Bandas Novas <a href="https://instagram.com/bandasnovas.oficial" target="_blank" aria-label="Link para seguir a Bandas Novas">(@bandasnovas.oficial)</a> no Instagram</div></li>
                    <li><div><a href="https://aerotour.com.br" target="_blank" aria-label="Link para se cadastrar no site da Aerotour">Cadastre-se </a> no site da Aerotour</div></li>
                    <li><div>Envie seu <i>@username</i> para o e-mail da Aerotour (contato@aerotour.com.br)</div></li>
                    <li>Aguarde nosso retorno com a liberação do cupom e utilize no carrinho.</li>
                    </ul>
                    <div class="promo-email-cta">
                      <a href="mailto:contato@aerotour.com.br
?subject=Solicitação%20de%20cupom%20ArteCult
&body=Olá,%0AGostaria%20de%20participar%20da%20promoção%20ArteCult%20%2B%20Aerotour.%0A
Meu%20@%20no%20Instagram%20é:%20"
>Já sigo as páginas, quero enviar meu @ para participar! >></a>
                    </div>
                    <button class="modal-button modal-button-ok"><img src="${rootUrl}/assets/images/parceiros/artecult.webp"/ width="44px" height="44px"><a href="https://artecult.com/" target="_blank" atia-label="Link para visitar o blog da ArteCult" onclick="gtag('event', 'btn_artecult', {
                  'event_category': 'ads',
                  'event_label': 'btn_artecult',
                  'value': 1
                })">Visite o site da ArteCult</a></button></div>
                `;
        }
        break;
      case 'desconto_antecipado':
        html = `  <div id="descontoAntecipadoModal">
                    <h3 class="modal-title">Ganhe 5% off na sua reserva</h3>
                    <p class="desconto-atecipado-body">
                    Desconto válido para reservas feitas com 30 dias ou mais de antecedência da data da excursão. Aproveite essa oportunidade de garantir sua vaga com um preço especial!
                    </p>
                    <p>Para a excursão escolhida, a validade do desconto é: ${
                      data.data_limite || null
                    }</p>
                    <div class="desconto-regras">
                    <ul>
                      <li>Desconto aplicado automaticamente para pedidos concluídos no período de validade.</li>
                      <li>Em excursões para eventos com múltiplas datas, não será possível trocar a reserva para uma data em que o desconto não seja aplicável.</li>
                      <li>Em caso de adiamento do evento de destino, não haverá concessão de desconto retroativo.</li>
                    </ul>
                    </div>
                    <div class="modal-actions">
                        <button class="modal-button modal-button-confirm">Fechar</button>
                    </div>
                  </div>
                `;
        break;
      case 'parceiroPDV':
        html = `<div id="parceiroPDVModal">
          <h3 class="heading" role="heading">Seja bem-vindo(a) ao site da Aerotour Excursões.</h3>
          <p>Você está acessando através do ponto de venda do nosso parceiro <strong>${nomeParceiro}</strong></p>
          <div class="aviso-prazo">O acesso por esse ponto de venda é válido por uma hora.</div>
          <div class="modal-actions">
              <button class="modal-button modal-button-confirm">Entendi</button>
          </div>
        </div>`;
        break;
      default:
        html = `
                    <h3 class="modal-title info-title">${title} || Informação</h3>
                    <p class="modal-body info-body">${bodyText}</p>
                    <p class="modal-body info-body">${contentType}</p>
                    <button class="modal-button modal-button-close-info">Fechar</button>
                `;
        break;
    }

    return html;
  }

  /**
   * Abre o modal, renderizando o conteúdo antes de exibi-lo.
   * @param {string} contentType - O tipo de conteúdo que você deseja renderizar (ex: 'alerta', 'confirmacao').
   * @param {Object} data - Dados adicionais para o conteúdo (ex: { title: 'Aviso!', body: 'Tem certeza?' }).
   */
  open(contentType, data = {}) {
    // 1. Renderiza o novo conteúdo
    const newContent = this.#renderContent(contentType, data);
    this.#contentContainer.innerHTML = newContent;

    // 2. Adiciona a classe 'open' para exibir o modal (geralmente via CSS)
    this.#modalElement.classList.add('open');
    document.body.classList.add('modal-open'); // Opcional: evita que o corpo role

    // 3. Adiciona listeners para os novos botões (exemplo: botões "Confirmar" e "Entendi")
    this.#attachContentListeners();
  }

  /**
   * Fecha o modal, removendo a classe de exibição.
   */
  close() {
    this.#modalElement.classList.remove('open');
    document.body.classList.remove('modal-open');
    // Opcional: Limpa o conteúdo após fechar
    this.#contentContainer.innerHTML = '';
  }

  /**
   * Anexa listeners aos botões dentro do conteúdo recém-renderizado.
   * Esta é uma forma de garantir que o modal feche ao clicar em botões como 'Entendi', 'Fechar', 'Cancelar'.
   */
  #attachContentListeners() {
    const buttonsToClose = this.#contentContainer.querySelectorAll(
      '.modal-button-ok, .modal-button-cancel, .modal-button-close-info',
    );

    buttonsToClose.forEach((button) => {
      // Remove o listener anterior para evitar duplicação, se você estiver reabrindo o modal
      button.removeEventListener('click', this.closeHandler);
      // Cria uma referência para o método 'close' vinculado à instância da classe
      // Isso garante que 'this' dentro de 'close' aponte para a instância 'Modal'
      this.closeHandler = this.close.bind(this);
      button.addEventListener('click', this.closeHandler);
    });

    // Adicionar lógica específica para o botão de confirmação (que geralmente exige mais código)
    const confirmButton = this.#contentContainer.querySelector(
      '.modal-button-confirm',
    );
    if (confirmButton) {
      confirmButton.addEventListener('click', () => {
        console.log('Ação de Confirmação Executada!');
        // Aqui você chamaria um callback ou emitiria um evento
        this.close();
      });
    }
  }
}

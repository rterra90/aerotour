/**
 * Classe Modal: Responsável por gerenciar a exibição e o conteúdo de um modal.
 */
class Modal {
  // #modalElement é uma propriedade privada para armazenar a referência ao elemento DOM do modal.
  #modalElement;
  #contentContainer;
  #templatePath;
  /**
   * Construtor da classe Modal.
   * @param {string} modalId - O ID do elemento HTML que serve como contêiner principal do modal.
   * @param {string} contentSelector - O seletor CSS para o elemento dentro do modal onde o conteúdo será injetado.
   */
  constructor(
    modalId = 'generalModal',
    contentSelector = '.modal-content-body'
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

    // Define o caminho base para os templates de modal
    this.#templatePath = window.themeLinks.stylesheetUrl + '/includes/modals';

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
  // #renderContent(contentType, data = {}) {
  //   let html = await this.#fetchTemplate(contentType);
  //   const title = data.title || 'Título Padrão';
  //   const bodyText = data.body || null;
  //   const nomeParceiro = data.nomeParceiro || null;

  //   // Lógica de Condicionamento de Conteúdo
  //   switch (contentType) {
  //     case 'parceiroPDV':
  //       html = `<div id="parceiroPDVModal">
  //         <h3 class="heading" role="heading">Seja bem-vindo(a) ao site da Aerotour Excursões.</h3>
  //         <p>Você está acessando através do ponto de venda do nosso parceiro <strong>${nomeParceiro}</strong></p>
  //         <div class="aviso-prazo">O acesso por esse ponto de venda é válido por uma hora.</div>
  //         <div class="modal-actions">
  //             <button class="modal-button modal-button-confirm">Entendi</button>
  //         </div>
  //       </div>`;
  //       break;
  //     default:
  //       html = `
  //                   <h3 class="modal-title info-title">${title} || Informação</h3>
  //                   <p class="modal-body info-body">${bodyText}</p>
  //                   <p class="modal-body info-body">${contentType}</p>
  //                   <button class="modal-button modal-button-close-info">Fechar</button>
  //               `;
  //       break;
  //   }

  //   return html;
  // }

  
  async #renderContent(contentType, data = {}) {
    let html = await this.#fetchTemplate(contentType);

    // Substituição dinâmica de variáveis no HTML
    Object.keys(data).forEach(key => {
      const regex = new RegExp(`{{${key}}}`, 'g');
      html = html.replace(regex, data[key]);
    });

    return html;
  }

  /**
   * Abre o modal, renderizando o conteúdo antes de exibi-lo.
   * @param {string} contentType - O tipo de conteúdo que você deseja renderizar (ex: 'alerta', 'confirmacao').
   * @param {Object} data - Dados adicionais para o conteúdo (ex: { title: 'Aviso!', body: 'Tem certeza?' }).
   */
  async open(contentType, data = {}) {
    this.#modalElement.style.display = 'flex'; // Garante que o display mude antes da opacidade

    // 1. Renderiza o novo conteúdo
    const newContent = await this.#renderContent(contentType, data);
    this.#contentContainer.innerHTML = newContent;

    // 2. Adiciona a classe 'open' para exibir o modal (geralmente via CSS)
    this.#modalElement.classList.add('open');
    document.body.classList.add('modal-open'); // Opcional: evita que o corpo role

    // 3. Adiciona listeners para os novos botões (exemplo: botões "Confirmar" e "Entendi")
    this.#attachContentListeners();

    // Executar scripts injetados para rodarem após inserção no DOM por innerHTML
    const scripts = this.#contentContainer.querySelectorAll('script');
    scripts.forEach(oldScript => {
        const newScript = document.createElement('script');
        Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
        newScript.appendChild(document.createTextNode(oldScript.innerHTML));
        oldScript.parentNode.replaceChild(newScript, oldScript);
    });

  }

  /**
   * Fecha o modal, removendo a classe de exibição.
   */
  close() {
    this.#modalElement.classList.remove('open');
    document.body.classList.remove('modal-open');
    
    // Espera a animação de 0.3s acabar para dar display none
    setTimeout(() => {
        this.#modalElement.style.display = 'none';
        this.#contentContainer.innerHTML = '';
    }, 300);
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

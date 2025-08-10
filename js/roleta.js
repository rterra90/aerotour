document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('modal');
  const fecharModal = document.getElementById('fechar-modal');
  const minhaContaBtn = document.getElementById('modal-minha-conta-btn');
  const camp_id = modal.dataset.campanha;
  const roolUrl = 'https://aerotour.com.br';
  // const roolUrl = 'http://localhost/aerotour_dev';

  const bannerRoleta = document.querySelector('#bannerRoleta img');

  // Mostrar o modal após 2 segundos
  const podeAbrirModal = () => {
    if (
      window.sessionStorage.getItem('roleta_aguardando_login') == 'true' &&
      modal.classList.contains('not-logged-in')
    )
      return false;

    if (window.localStorage.getItem('mostra_roleta_aerotour_1') == 'false')
      return false;

    return true; //apenas esse deve ser true
  };

  function abreModal() {
    if (modal.querySelector('.wrap')) modal.querySelector('.wrap').remove();
    if (modal.querySelector('.final-result-container'))
      modal.querySelector('.final-result-container').remove();
    if (modal.querySelector('.ja-participou-aviso'))
      modal.querySelector('.ja-participou-aviso').remove();
    if (modal.querySelector('#modalBotoesFinais'))
      modal.querySelector('#modalBotoesFinais').remove();

    modal.classList.add('show');
    window.sessionStorage.removeItem('roleta_aguardando_login');

    if (modal.classList.contains('logged-in')) {
      async function getParticipantes() {
        const infoContainer = document.querySelector('.roleta-info');
        const loadingElement = document.createElement('span');
        loadingElement.classList.add('loadingElement');
        infoContainer.appendChild(loadingElement);
        const response = await fetch(
          `${roolUrl}/wp-json/api/db?camp_id=${camp_id}`,
          {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json',
            },
          },
        );

        if (!response.ok) {
          console.error('Erro:', response.statusText);
        } else {
          const result = await response.json();
          const campanha = JSON.parse(result)[0];

          //verifica se o usuário já participou
          const participantes = JSON.parse(campanha.participantes);
          const ja_participou = participantes.some(
            (_p) => _p.user_id == modal.dataset.user,
          );

          if (ja_participou) {
            const jaParticipouAviso = document.createElement('p');
            jaParticipouAviso.classList.add('ja-participou-aviso');
            jaParticipouAviso.innerText =
              'Parece que você já participou. Confira seu cupom em sua conta e insira no carrinho para utilizá-lo.';
            infoContainer.appendChild(jaParticipouAviso);
            fecharModal.innerText = 'Fechar';

            //CRIAR FUNÇÃO
            setTimeout(() => {
              window.localStorage.setItem('mostra_roleta_aerotour_1', false);
              const botoesFinais = document.createElement('div');
              botoesFinais.id = 'modalBotoesFinais';
              botoesFinais.innerHTML = `<a href='${window.location.origin}/minha-conta'>Ver cupom</a>`;
              document.querySelector('.roleta-info').appendChild(botoesFinais);

              const continuarBtn = document.createElement('button');
              continuarBtn.innerText = 'Continuar navegando >';
              continuarBtn.addEventListener('click', () => {
                if (window.location.pathname.includes('minha-conta')) {
                  window.location.reload();
                } else {
                  modal.classList.remove('show');
                }
              });
              //CRIAR FUNÇÃO

              botoesFinais.appendChild(continuarBtn);
            }, 1000);
          } else {
            const btnWrapper = document.createElement('div');
            btnWrapper.classList.add('wrap');
            const _btnGirarCriado = document.createElement('button');
            _btnGirarCriado.id = 'girar';
            _btnGirarCriado.innerText = 'Girar';
            _btnGirarCriado.dataset.user = modal.dataset.user;
            _btnGirarCriado.addEventListener('click', girarRoleta);
            btnWrapper.appendChild(_btnGirarCriado);
            infoContainer.appendChild(btnWrapper);
          }
          infoContainer.querySelector('.loadingElement').remove();
        }
      }

      getParticipantes();
    }
  }
  if (podeAbrirModal()) setTimeout(() => abreModal(), 2000);
  if (bannerRoleta) bannerRoleta.addEventListener('click', () => abreModal());
  // Fechar o modal ao clicar no botão
  if (fecharModal) {
    fecharModal.addEventListener('click', ({ target }) => {
      if (target.dataset.status === '1') {
        window.localStorage.setItem('mostra_roleta_aerotour_1', false);
      }
      modal.classList.remove('show'); // Animação reversa para fechar
    });

    //Comportamento ao clicar para página Minha conta
    if (minhaContaBtn) {
      minhaContaBtn.addEventListener('click', () => {
        window.sessionStorage.setItem('roleta_aguardando_login', true);
      });
    }
  }

  //LÓGICA DA ROLETA
  // const girarBtn = document.getElementById('girar');
  const roda = document.getElementById('roda');
  let isSpinning = false; // Evitar múltiplos cliques

  function girarRoleta({ target }) {
    const girarBtn = target;
    if (isSpinning) return; // Impedir cliques repetidos
    isSpinning = true;
    girarBtn.disabled = true; // Desabilitar o botão enquanto gira
    girarBtn.innerText = 'Aguarde';
    fecharModal.style.display = 'none';
    // Geração de rotação aleatória (mínimo de 3 voltas completas + ângulo aleatório)
    const randomDegree = Math.floor(360 * 3 + Math.random() * 360);

    // Atualiza a rotação da roda
    roda.style.animation = `giraRoleta 5s forwards`;
    roda.style.setProperty('--final-rotate', randomDegree + 'deg');

    // Determinar o resultado após o giro
    setTimeout(() => {
      const userID = girarBtn.dataset.user;
      const result = (randomDegree % 360) / 40; // Cada fatia tem 40 graus
      const premioIndex =
        9 - Math.ceil(result) === 0 ? 9 : 9 - Math.ceil(result); // Calcular qual fatia foi sorteada
      const premioFinal =
        document.getElementById('roda').children[premioIndex - 1].children[0]
          .dataset.premio; //O DATASET PREMIO DO ELEMENTO QUE TEM O NOME DO CUPOM
      const valorCupom = premioFinal.replace('off', '');
      const premioContainer = girarBtn.parentElement.parentElement;

      girarBtn.parentElement.remove();

      const _aguarde = document.createElement('div');
      _aguarde.classList.add('modal-aguarde');
      _aguarde.innerHTML = `Aguarde...`;
      premioContainer.appendChild(_aguarde);

      async function putParticipantes(data) {
        const response = await fetch(`${roolUrl}/wp-json/api/db`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        });
        if (!response.ok) {
          console.error('Erro:', response.statusText);
        } else {
          const result = await response.json();
          console.log(result);
        }
      }

      async function putCupom(data) {
        const response = await fetch(`${roolUrl}/wp-json/api/cupom`, {
          method: 'PUT', // ou 'PUT' para atualizações
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify(data),
        });

        if (!response.ok) {
          console.error('Erro:', response.statusText);
        } else {
          const result = await response.json();
          premioContainer.querySelector('.modal-aguarde').remove();

          if (result == 'Cupom obtido com sucesso!') {
            putParticipantes({
              camp_id: camp_id,
              user_id: userID,
              cupom_obtido: premioFinal,
              timestamp: Date.now(),
            });
            const finalResultContainer = document.createElement('div');
            finalResultContainer.classList.add('final-result-container');
            finalResultContainer.innerHTML = `<p class="premio">Parabéns! Você ganhou um cupom de ${valorCupom}% de desconto!</p>
              <div class="cupom-icon">${premioFinal}</div>
              <p class="descricao">Válido para qualquer excursão no site. Basta adicionar ao carrinho. </p>`;

            premioContainer.appendChild(finalResultContainer);

            //CRIAR FUNÇÃO
            setTimeout(() => {
              window.localStorage.setItem('mostra_roleta_aerotour_1', false);
              const botoesFinais = document.createElement('div');
              botoesFinais.id = 'modalBotoesFinais';
              botoesFinais.innerHTML = `<a href='${window.location.origin}/minha-conta'>Ver cupom</a>`;
              document.querySelector('.roleta-info').appendChild(botoesFinais);

              const continuarBtn = document.createElement('button');
              continuarBtn.innerText = 'Continuar navegando >';
              continuarBtn.addEventListener('click', () => {
                if (window.location.pathname.includes('minha-conta')) {
                  window.location.reload();
                } else {
                  modal.classList.remove('show');
                }
              });

              botoesFinais.appendChild(continuarBtn);
            }, 1000);
          }
        }
        //CRIAR FUNÇÃO
      }
      putCupom({ user_id: userID, cupom_code: premioFinal });

      // Reativar o botão após o giro
      isSpinning = false;
      // girarBtn.disabled = false;
    }, 4500); // Tempo da transição CSS (4 segundos)
  }
});

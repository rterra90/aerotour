/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const ItemReserva = ({ reserva, excDetails, adminAjax, setToast }) => {
  const orderLink = `https://aerotour.com.br/wp-admin/post.php?post=${reserva.order_id}&action=edit`;
  const dia = excDetails['id_' + reserva.variation_id]
    ? excDetails['id_' + reserva.variation_id][1]
    : '';
  const [updateDone, setUpdateDone] = React.useState(false);

  function getAncestorByTag(element, tagName) {
    let ancestor = element;
    tagName = tagName.toLowerCase();
    while (ancestor) {
      if (ancestor.tagName.toLowerCase() === tagName) return ancestor;
      ancestor = ancestor.parentElement;
    }
    return null;
  }
  async function copyToClipboard(textToCopy) {
    try {
      await navigator.clipboard.writeText(textToCopy);
    } catch (err) {
      console.error('Falha ao copiar: ', err);
    }
  }

  function _closeMenu() {
    const _menu = document.querySelectorAll('.menu-reserva');
    _menu.forEach((_m) => {
      _m.parentElement.classList.remove('menu-ativo');
      document.body.classList.remove('tem-menu-ativo');
      document.body.removeEventListener('click', closeOptionsMenu);
      _m.remove();
    });
  }

  function closeOptionsMenu({ target }) {
    if (document.body.classList.contains('tem-menu-ativo')) {
      const targetMenu = document.querySelector('tr .menu-reserva');
      if (targetMenu && !target.classList.contains('menu-reserva-component'))
        //clique fora do menu
        _closeMenu();
      else {
        switch (target.dataset.opcao) {
          case 'Cancelar reserva':
            target.parentElement.classList.add('loading');
            adminAjax.update_reserva(reserva.ID, 'cancelar', setUpdateDone);
            break;
          case 'Reativar reserva':
            target.parentElement.classList.add('loading');
            adminAjax.update_reserva(reserva.ID, 'reativar', setUpdateDone);
            break;

          case 'Copiar dados':
            copyToClipboard(
              getAncestorByTag(target, 'tr').childNodes[2].innerText +
                ' — ' +
                getAncestorByTag(target, 'tr').childNodes[3].innerText +
                ' — ' +
                getAncestorByTag(target, 'tr').childNodes[4].innerText,
            );

            _closeMenu();
            setToast('Dados copiados com sucesso');
            break;

          default:
            console.log(target.dataset.opcao);
            break;
        }
      }
    }
  }

  function openOptionsMenu({ clientX, currentTarget }) {
    const xInicial = currentTarget.getBoundingClientRect().x;
    const posX = clientX - xInicial;

    if (!document.body.classList.contains('tem-menu-ativo')) {
      currentTarget.classList.add('menu-ativo');
      let menuElement = document.createElement('div');
      menuElement.classList.add('menu-reserva', 'menu-reserva-component');
      menuElement.appendChild(document.createElement('ul'));

      //Adiciona as opções do menu de reserva
      const opcoes = [
        'Copiar dados',
        'Ver pedido',
        'Alterar embarque',
        'Cancelar reserva',
        'Reativar reserva',
      ];
      const menuOption = (_op) => {
        const _element = document.createElement('li');
        _element.dataset.opcao = _op;
        _element.innerText = _op;
        _element.classList.add('menu-reserva-component');
        menuElement.querySelector('ul').appendChild(_element);
      };
      opcoes.forEach((_opcao) => {
        switch (_opcao) {
          case 'Reativar reserva':
            if (reserva.status === 'cancel') menuOption(_opcao);
            break;
          case 'Cancelar reserva':
            if (reserva.status !== 'cancel') menuOption(_opcao);
            break;
          default:
            menuOption(_opcao);
        }
      });

      // Define a posição do menu conforme o local do clique
      if (posX < currentTarget.offsetWidth * 0.75)
        menuElement.style.left = `${posX + 6}px`;
      else
        menuElement.style.right = `${currentTarget.offsetWidth - posX + 6}px`;

      // Insere o menu no DOM
      currentTarget.appendChild(menuElement);

      //Adiciona listener ao body para fechar o menu
      setTimeout(() => {
        document.body.addEventListener('click', closeOptionsMenu);
        document.body.classList.add('tem-menu-ativo');
      }, 80);
    }
  }

  React.useEffect(() => {
    if (updateDone) {
      switch (updateDone) {
        case 'cancelar':
          reserva.status = 'cancel';
          setToast('Reserva cancelada');

          break;
        case 'reativar':
          reserva.status = 'normal';
          setToast('Reserva reativada');

          break;
        default:
          break;
      }
      _closeMenu();
      setTimeout(() => setUpdateDone(false), 3000);
    }
  }, [updateDone]);

  return (
    <tr onClick={openOptionsMenu} data-reserva-id={reserva.ID}>
      <td data-coluna="order-id">
        <a href={orderLink}>{reserva.order_id}</a>
      </td>
      <td data-coluna="excursao">
        {excDetails['id_' + reserva.variation_id]
          ? excDetails['id_' + reserva.variation_id][0]
          : ''}{' '}
        - {dia.substring(0, 5)}
      </td>
      <td data-coluna="nome-completo">{reserva.p_nome}</td>
      <td data-coluna="cpf">{reserva.p_cpf}</td>
      <td data-coluna="telefone">{reserva.p_telefone}</td>
      <td data-coluna="embarque">{reserva.embarque}</td>
      <td data-coluna="horario">{reserva.horario.slice(0, -3)}</td>
      <td data-coluna="status">{reserva.status}</td>
    </tr>
  );
};

ItemReserva.propTypes = {
  reserva: PropTypes.object.isRequired,
  excDetails: PropTypes.object.isRequired,
  adminAjax: PropTypes.object.isRequired,
  setToast: PropTypes.func,
};

export default ItemReserva;

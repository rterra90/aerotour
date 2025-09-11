/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import { convertDate } from '../Utilities';

const PaxCard = ({ pax, index, setPassageiros, openPaxModal }) => {
  const cardRef = React.useRef(null);

  function removePax() {
    const card = cardRef.current;
    if (window.confirm('Remover passageiro?')) {
      if (card) {
        card.classList.add('removing');
        setTimeout(() => {
          // remove o card da lista
          setPassageiros((_current) => {
            return _current.filter((_pax, _i) => _i != index);
          });
        }, 500); // tempo igual ao da animação
      }
    }
  }

  React.useEffect(() => {
    const card = cardRef.current;
    if (card) {
      const timeout = setTimeout(() => {
        card.classList.add('highlight');
        setTimeout(() => {
          card.classList.remove('highlight');
        }, 900); // duração do efeito de destaque
      }, 250); // espera o modal fechar completamente

      return () => clearTimeout(timeout);
    }
  }, []);

  return (
    <article className="passenger-card" ref={cardRef}>
      <div className="avatar">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
        >
          <path
            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 
          1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 
          1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
          />
        </svg>
      </div>
      <div className="info">
        <div className="top-row">
          <div>
            <div className="name" tabIndex="0">
              <p className="my-0" data-fullname={pax.nome_completo}>
                {pax.nome_completo}
              </p>
            </div>
            <div className="meta">
              {pax.tripType == 'ida-e-volta'
                ? 'Ida e volta'
                : 'Apenas ' + pax.tripType}
            </div>
          </div>
          <div className="pill">Passageiro #{index + 1}</div>
        </div>
        <div style={{ marginTop: '12px' }}>
          <dl>
            <div>
              <dt>CPF</dt>
              <dd>{pax.cpf}</dd>
            </div>
            <div>
              <dt>Contato</dt>
              <dd>{pax.celular}</dd>
            </div>
            <div>
              <dt>Nasc.</dt>
              <dd>{convertDate(pax.data_nascimento, 'DMY')}</dd>
            </div>
          </dl>
        </div>
      </div>
      <button
        className="edit-pencil"
        onClick={() => openPaxModal('edit', pax, index)}
      >
        ✏️
      </button>
      <button className="remove-pencil" onClick={removePax}>
        🗑️
      </button>
    </article>
  );
};

PaxCard.propTypes = {
  pax: PropTypes.object,
  index: PropTypes.number,
  setPassageiros: PropTypes.func.isRequired,
  openPaxModal: PropTypes.func.isRequired,
};

export default PaxCard;

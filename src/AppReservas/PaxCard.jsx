/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const PaxCard = ({ pax, index, setPassageiros, openPaxModal }) => {
  function removePax() {
    if (window.confirm('Remover passageiro?')) {
      setPassageiros((_current) => {
        return _current.filter((_pax, _i) => _i != index);
      });
    }
  }

  return (
    <article className="passenger-card">
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
            <div className="name">{pax.nome_completo}</div>
            <div className="meta">{'role'}</div>
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
              <dd>{pax.data_nascimento}</dd>
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
  pax: PropTypes.obj,
  index: PropTypes.number,
  setPassageiros: PropTypes.func.isRequired,
  openPaxModal: PropTypes.func.isRequired,
};

export default PaxCard;

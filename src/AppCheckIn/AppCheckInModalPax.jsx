/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import { Phone, Send } from 'lucide-react';

const AppCheckInModalPax = ({ setModalPax, modalPax }) => {
  return (
    <div className="pax-modal-backdrop" onClick={() => setModalPax(null)}>
      <div
        className="pax-modal"
        onClick={(e) => e.stopPropagation()} // evitar fechar ao clicar dentro
      >
        <h3>{modalPax.p_nome}</h3>
        <p>
          <strong>CPF:</strong> {modalPax.p_cpf}
        </p>
        <p className="pax-telefone">
          <span>
            <strong>Celular:</strong> {modalPax.p_telefone}
          </span>
          <span className="pax-btns">
            <a
              href={`https://wa.me/${modalPax.p_telefone.replace(/\D/g, '')}`}
              target="_blank"
              rel="noopener noreferrer"
              title="Abrir no WhatsApp"
            >
              <Send size={26} />
              <div>WhatsApp</div>
            </a>
            <a href={`tel:${modalPax.p_telefone}`} title="Ligar">
              <Phone size={26} />
              <div>Ligar</div>
            </a>
          </span>
        </p>
        <p>
          <strong>Embarque:</strong> {modalPax.embarque}
        </p>

        <button className="modal-close-btn" onClick={() => setModalPax(null)}>
          Fechar
        </button>
      </div>
    </div>
  );
};

AppCheckInModalPax.propTypes = {
  setModalPax: PropTypes.func.isRequired,
  modalPax: PropTypes.oneOfType([PropTypes.bool, PropTypes.object]).isRequired,
};

export default AppCheckInModalPax;

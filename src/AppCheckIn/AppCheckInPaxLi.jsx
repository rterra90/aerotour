/* eslint-disable react/react-in-jsx-scope */

import PropTypes from 'prop-types';
import { Check } from 'lucide-react';

const AppCheckInPaxLi = ({ pax, setModalPax, toggleCheck }) => {
  return (
    <li key={pax.ID} className="pax-item">
      <span
        className="pax-nome"
        onClick={() => setModalPax(pax)}
        title="Ver detalhes"
      >
        {pax.p_nome}
      </span>

      <div className="check-group">
        <button
          className={`check-box ${pax.saida ? 'checked' : ''} ${
            pax.rota == 3 ? 'disabled' : ''
          }`}
          onClick={({ currentTarget }) =>
            pax.rota != 3 &&
            toggleCheck(pax.ID, 'saida', !pax.saida, currentTarget)
          }
        >
          {pax.saida && <Check size={14} strokeWidth={5} />}
        </button>
        <button
          className={`check-box ${pax.volta ? 'checked' : ''} ${
            pax.rota == 2 ? 'disabled' : ''
          }`}
          onClick={({ currentTarget }) =>
            pax.rota != 2 &&
            toggleCheck(pax.ID, 'volta', !pax.volta, currentTarget)
          }
        >
          {pax.volta && <Check size={14} strokeWidth={5} />}
        </button>
      </div>
    </li>
  );
};

AppCheckInPaxLi.propTypes = {
  pax: PropTypes.object.isRequired,
  setModalPax: PropTypes.func.isRequired,
  toggleCheck: PropTypes.func.isRequired,
};
export default AppCheckInPaxLi;

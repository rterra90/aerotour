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
            pax.ida_desativado ? 'disabled' : ''
          }`}
          onClick={({ currentTarget }) =>
            !pax.ida_desativado &&
            toggleCheck(pax.ID, 'saida', !pax.saida, currentTarget)
          }
        >
          {pax.saida && <Check size={14} strokeWidth={5} />}
        </button>
        <button
          className={`check-box ${pax.volta ? 'checked' : ''} ${
            pax.volta_desativado ? 'disabled' : ''
          }`}
          onClick={({ currentTarget }) =>
            !pax.volta_desativado &&
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

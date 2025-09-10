/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const PrecoReservas = ({
  passageiros,
  selectedDates,
  precoUnitario,
  totalCost,
}) => {
  return (
    <>
      {/* Valor da reserva */}
      {passageiros.length > 0 && (
        <div className="passenger-card total-reservation">
          <div className="coluna-esquerda">
            {/* 1 passageiro e 1 data */}
            {selectedDates.length == 1 && passageiros.length == 1 ? (
              <div className="item">Valor:</div>
            ) : null}
            {/* multi passageiro e 1 data */}
            {selectedDates.length == 1 && passageiros.length > 1 ? (
              <>
                <div className="item small-info">
                  Valor unit.: R${precoUnitario},00
                </div>
                <div className="item small-info">
                  Passageiros: {passageiros.length}
                </div>
              </>
            ) : null}
            {/* 1 passageiro e multi data */}
            {selectedDates.length > 1 && passageiros.length == 1 ? (
              <>
                <div className="item small-info">
                  Valor unit.: R${precoUnitario},00
                </div>
                <div className="item small-info">
                  Dias: {selectedDates.length}
                </div>
              </>
            ) : null}
            {/* multi passageiro e multi data */}
            {selectedDates.length > 1 && passageiros.length > 1 ? (
              <>
                <div className="item small-info">
                  Valor unit.: R${precoUnitario},00
                </div>
                <div className="item small-info">
                  Passageiros: {passageiros.length}
                </div>
                <div className="item small-info">
                  Dias: {selectedDates.length}
                </div>
              </>
            ) : null}
          </div>
          <div className="coluna-direita">
            {passageiros.length > 1 || selectedDates.length > 1 ? (
              <div className="total">Total</div>
            ) : null}
            <div className="total">R${totalCost},00</div>
          </div>
        </div>
      )}
    </>
  );
};
PrecoReservas.propTypes = {
  passageiros: PropTypes.array.isRequired,
  selectedDates: PropTypes.array.isRequired,
  precoUnitario: PropTypes.number.isRequired,
  totalCost: PropTypes.number.isRequired,
};

export default PrecoReservas;

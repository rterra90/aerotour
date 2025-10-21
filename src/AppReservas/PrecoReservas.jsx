/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import { convertDate } from '../Utilities';
const PrecoReservas = ({
  passageiros,
  selectedDates,
  precoUnitario,
  totalCost,
  discountCost,
  dataLimiteDesconto,
}) => {
  return (
    <>
      {/* Valor da reserva */}
      {passageiros.length > 0 && precoUnitario > 0 ? (
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
            {discountCost ? (
              <>
                <div
                  className="discount-price-container"
                  onClick={() => {
                    const descontoAntModal = new Modal(
                      'generalModal',
                      '.modal-content-body',
                    );
                    descontoAntModal.open('desconto_antecipado', {
                      data_limite: convertDate(dataLimiteDesconto[0], 'dmy'),
                    });
                  }}
                >
                  <div className="total">Total</div>

                  <div className="total values-comp">
                    <span className="original-price">{totalCost}</span>
                    <span>{discountCost}</span>
                  </div>
                </div>
              </>
            ) : (
              <>
                {passageiros.length > 1 || selectedDates.length > 1 ? (
                  <div className="total">Total</div>
                ) : null}
                <div className="total">{totalCost}</div>
              </>
            )}
          </div>
        </div>
      ) : null}
    </>
  );
};
PrecoReservas.propTypes = {
  passageiros: PropTypes.array.isRequired,
  selectedDates: PropTypes.array.isRequired,
  precoUnitario: PropTypes.number.isRequired,
  totalCost: PropTypes.string.isRequired,
  dataLimiteDesconto: PropTypes.string.isRequired,
  discountCost: PropTypes.oneOfType([PropTypes.string, PropTypes.bool])
    .isRequired,
};

export default PrecoReservas;

/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const DatesModal = ({
  setDateModalOpen,
  availableDates,
  selectedDates,
  toggleDate,
  getVarIdByDate,
}) => {
  const [preData, setPreData] = React.useState([]);
  const preDataRef = React.useRef(preData);

  function closeDateModal() {
    setDateModalOpen(false);
  }

  React.useEffect(() => {
    preDataRef.current = preData;
  }, [preData]);

  React.useEffect(() => {
    /* Preenche preData com as datas já selecionadas */
    if (selectedDates.length > 0) {
      selectedDates.forEach((date) => {
        setPreData((_p) => [..._p, [date, getVarIdByDate(date)]]);
      });
    }
    return () => {
      if (preDataRef.current.length > 0) {
        toggleDate(preDataRef.current);
      } else toggleDate('', '');
    };
  }, []);

  return (
    <div className="modal-overlay" onClick={closeDateModal}>
      <div
        className="modal-content"
        data-modal="dates"
        onClick={(e) => e.stopPropagation()}
      >
        <h3>Selecionar Datas</h3>
        <form className="date-list many">
          {availableDates.map((dateObj) => (
            <label
              key={dateObj.dia}
              className={
                dateObj.encerrado || dateObj.disponiveis === ''
                  ? 'disabled'
                  : ''
              }
              data-ultimas={dateObj.disponiveis < 10 ? 'true' : 'false'}
              data-ultimas-vagas={
                dateObj.disponiveis < 10
                  ? dateObj.disponiveis + ' ' + 'vagas restantes'
                  : 'false'
              }
              data-esgotado={dateObj.disponiveis === '' ? 'true' : 'false'}
            >
              {dateObj.encerrado || dateObj.disponiveis === '' ? (
                <input type="checkbox" disabled />
              ) : (
                <input
                  type="checkbox"
                  // checked={selectedDates.includes(dateObj.dia)}
                  checked={preData.some((_item) => _item[0] == dateObj.dia)}
                  // onChange={() => toggleDate(dateObj.dia, dateObj.variacao)}
                  onChange={() => {
                    setPreData(() => {
                      if (preData.some((_item) => _item[0] == dateObj.dia)) {
                        return preData.filter(
                          (_item) => _item[0] !== dateObj.dia,
                        );
                      } else {
                        return [
                          ...preData,
                          [dateObj.dia, getVarIdByDate(dateObj.dia)],
                        ];
                      }
                    });
                  }}
                />
              )}
              <span>{dateObj.dia}</span>
            </label>
          ))}
        </form>
        <div className="modal-buttons">
          <button type="button" onClick={closeDateModal}>
            Concluído
          </button>
        </div>
      </div>
    </div>
  );
};

export default DatesModal;
DatesModal.propTypes = {
  setDateModalOpen: PropTypes.func.isRequired,
  availableDates: PropTypes.array.isRequired,
  selectedDates: PropTypes.array.isRequired,
  toggleDate: PropTypes.func.isRequired,
  getVarIdByDate: PropTypes.func.isRequired,
};

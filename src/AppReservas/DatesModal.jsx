/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const DatesModal = ({
  setDateModalOpen,
  availableDates,
  selectedDates,
  toggleDate,
  getVarIdByDate,
  getAvailabilityById,
  passageiros,
}) => {
  const [preData, setPreData] = React.useState([]);
  const [visible, setVisible] = React.useState(false);
  const [initial, setInitial] = React.useState(false);
  const preDataRef = React.useRef(preData); //para utilizar no return do useEffect principal
  const saveBtnRef = React.useRef();

  function closeDateModal(_save) {
    const hasUpdatedData = preDataRef.current.toString() != initial.toString();
    if (_save && hasUpdatedData) {
      if (preDataRef.current.length > 0) {
        toggleDate(preDataRef.current);
      } else toggleDate('', '');
    } else setVisible(false);
    setTimeout(() => {
      setDateModalOpen(false);
    }, 300);
  }

  function changeCheckbox(_dateObj, _element) {
    setPreData(() => {
      const dataJaSelecionada = preData.some(
        (_item) => _item[0] == _dateObj.dia,
      );

      if (dataJaSelecionada) {
        return preData.filter((_item) => _item[0] !== _dateObj.dia);
      } else {
        if (_dateObj.disponiveis < passageiros.length) {
          window.alert(
            'Vagas insuficientes nessa data para o número de passageiros informados.',
          );
          _element.setAttribute('checked', 'false');
          console.log('aviso de vagas insuficientes');
          return preData;
        }
        return [
          ...preData,
          [_dateObj.dia, getVarIdByDate(_dateObj.dia), _dateObj.disponiveis],
        ];
      }
    });
  }

  React.useEffect(() => {
    preDataRef.current = preData;
    if (preData.length < 1) saveBtnRef.current.setAttribute('disabled', '');
    else saveBtnRef.current.removeAttribute('disabled');
  }, [preData]);

  React.useEffect(() => {
    setVisible(true);
    /* Preenche preData com as datas já selecionadas */
    if (selectedDates.length > 0) {
      const mapped = selectedDates.map((date) => [
        date,
        getVarIdByDate(date),
        getAvailabilityById(getVarIdByDate(date)),
      ]);

      setPreData((prev) => {
        if (!initial) setInitial(() => [...prev, ...mapped]);
        return [...prev, ...mapped];
      });
    }
  }, []);

  return (
    <div
      className={`modal-overlay ${visible ? 'show' : ''}`}
      onClick={() => closeDateModal(false)}
    >
      <div
        className={`modal-content ${visible ? 'show' : ''}`}
        data-modal="dates"
        onClick={(e) => e.stopPropagation()}
      >
        <h3>Selecionar Datas</h3>
        <form
          className={`date-list${availableDates.length > 1 ? ' many' : ''}`}
        >
          {availableDates.map((dateObj) => (
            <label
              key={dateObj.dia}
              className={
                dateObj.encerrado || dateObj.disponiveis === 0 ? 'disabled' : ''
              }
              data-ultimas={dateObj.disponiveis < 10 ? 'true' : 'false'}
              data-ultimas-vagas={
                dateObj.disponiveis < 10
                  ? dateObj.disponiveis + ' ' + 'vagas restantes'
                  : 'false'
              }
              data-esgotado={dateObj.disponiveis === 0 ? 'true' : 'false'}
            >
              {dateObj.encerrado || dateObj.disponiveis === 0 ? (
                <input type="checkbox" disabled />
              ) : (
                <input
                  type="checkbox"
                  checked={preData.some((_item) => _item[0] == dateObj.dia)}
                  onChange={({ target }) => changeCheckbox(dateObj, target)}
                />
              )}
              <span>{dateObj.dia}</span>
            </label>
          ))}
        </form>
        <div className="modal-buttons">
          <button
            type="button"
            className="saveBtn"
            ref={saveBtnRef}
            onClick={() => closeDateModal(true)}
          >
            Salvar
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
  passageiros: PropTypes.array.isRequired,
  toggleDate: PropTypes.func.isRequired,
  getVarIdByDate: PropTypes.func.isRequired,
  getAvailabilityById: PropTypes.func.isRequired,
};

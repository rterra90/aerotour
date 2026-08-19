/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import {
  convertDate,
  dataTrintaDiasAntes,
  dataTemDescontoHoje,
} from '../Utilities';

const DatesModal = ({
  setDateModalOpen,
  availableDates,
  selectedDates,
  toggleDate,
  getVarIdByDate,
  getAvailabilityById,
  passageiros,
  setDataLimiteDesconto,
  dataLimiteDesconto,
  productId
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
        //Remove a data limite de desconto se necessário
        setDataLimiteDesconto((prev) => {
          const arr = Array.isArray(prev) ? [...prev] : [];
          const prev_index = arr.indexOf(_dateObj.desconto_antecipado_val);
          if (prev_index !== -1) arr.splice(prev_index, 1);
          arr.sort((a, b) => new Date(b) - new Date(a));
          return arr;
        });

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

        // Altera a data limite de desconto se necessário
        setDataLimiteDesconto((prev) => {
          const arr = Array.isArray(prev) ? [...prev] : [];
          const novaData = _dateObj.desconto_antecipado_val;

          // só adiciona se houver valor e ainda não existir no array
          if (
            novaData &&
            !arr.includes(novaData) &&
            _dateObj.desconto_antecipado === true
          ) {
            arr.push(novaData);
          }

          // ordena da mais recente para a mais antiga
          arr.sort((a, b) => new Date(b) - new Date(a));

          return arr;
        });

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
    setDataLimiteDesconto([]);
    /* Preenche preData com as datas já selecionadas */
    if (selectedDates.length > 0) {
      const mapped = selectedDates.map((date) => [
        date,
        getVarIdByDate(date),
        getAvailabilityById(getVarIdByDate(date)),
      ]);
      selectedDates.forEach((date) => {
        if (dataTemDescontoHoje(convertDate(date, 'iso'))) {
          setDataLimiteDesconto((_prev) => [
            dataTrintaDiasAntes(convertDate(date, 'iso')),
            ..._prev,
          ]);
        }
      });

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
        {productId == '6555' ? <p class="mb-0 small text-center">⚠️ Atenção: escolha a <b>mesma data do seu ingresso</b> para o festival!
</p> : null}
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
              data-desconto-antecipado={dateObj.desconto_antecipado}
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
              <span>
                {dateObj.dia === '31/12/2026' ? 'A definir...' : dateObj.dia}
              </span>
            </label>
          ))}
        </form>

        <div className="desconto-data-limite">
          {dataLimiteDesconto.length > 0 && preData.length > 0 ? (
            <p>
              5% off válido até {convertDate(dataLimiteDesconto[0], 'dmy')} para
              a data selecionada
            </p>
          ) : null}
        </div>
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
  setDataLimiteDesconto: PropTypes.func.isRequired,
  dataLimiteDesconto: PropTypes.array.isRequired,
  productId: PropTypes.string.isRequired,
};

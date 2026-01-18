/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import useAdminAjax from '../Hooks/useAdminAjax';
import SelectLiveSearch from './SelectLiveSearch';
import ItemReserva from './ItemReserva';
import PropTypes from 'prop-types';
import Toast from './Toast';
import BotaoExportarXLS from './BotaoExportarXLS';

function AppReservasAdmin({ ajaxUrl }) {
  const [toast, setToast] = React.useState(false);
  const [reservas, setReservas] = React.useState(null);
  const [reservas_f, setReservas_f] = React.useState([]);
  const [excDetails, setExcDetails] = React.useState(null);
  const [excDetails2, setExcDetails2] = React.useState(null);
  const [filter, setFilter] = React.useState(0);
  const tableToSheetRef = React.useRef(null);
  const adminAjax = useAdminAjax(ajaxUrl);

  React.useEffect(() => {
    adminAjax.get_reservas(setReservas, setExcDetails);
  }, []);

  React.useEffect(() => {
    if (excDetails) setExcDetails2(Object.values(excDetails));
  }, [excDetails]);

  React.useEffect(() => {
    const sheetBtn = document.querySelector('#exportSheetBtn');
    const thead_embarque = document.querySelector(
      '#adminReservasTable thead th[data-coluna="embarque"]',
    );

    if (filter > 0) {
      //se tiver filtro
      setReservas_f(
        reservas.filter((r) => {
          if (r.variation_id == filter) return r;
        }),
      );
      if (thead_embarque) thead_embarque.classList.add('sort-enabled');
      if (sheetBtn) sheetBtn.removeAttribute('disabled');
    } else {
      //se NÃO tiver filtro
      setReservas_f([]);
      if (thead_embarque) thead_embarque.classList.remove('sort-enabled');
      if (sheetBtn) sheetBtn.setAttribute('disabled', 'true');
    }
  }, [filter]);

  function ordenarPassageiros({ target }) {
    if (target.classList.contains('sort-enabled')) {
      // const _by = target.dataset.coluna;
      let reservas_ordenadas = {};
      reservas_f.forEach((_reserva) => {
        if (typeof reservas_ordenadas[_reserva.embarque] == 'undefined') {
          reservas_ordenadas[_reserva.embarque] = [];
        }
        reservas_ordenadas[_reserva.embarque].push(_reserva);
      });

      let _res_fil_ord = []; //reservas filtradas por excursão e ordenadas por embarque
      Object.keys(reservas_ordenadas).forEach((_local_emb) => {
        _res_fil_ord = [..._res_fil_ord, ...reservas_ordenadas[_local_emb]];
      });
      setReservas_f(_res_fil_ord);
    }
  }

  return (
    <div id="adminReservasTable">
      {toast ? <Toast message={toast} setToast={setToast} /> : null}
      <div className="filtros">
        <div className="exc-search">
          {excDetails2 ? (
            <SelectLiveSearch
              srcArray={excDetails2}
              setFilter={setFilter}
              filter={filter}
            />
          ) : (
            'carregado excursões...'
          )}
        </div>
        <BotaoExportarXLS _ref={tableToSheetRef} />
      </div>
      {reservas ? (
        <p>
          {reservas_f.length > 0 ? reservas_f.length : reservas.length} reservas
        </p>
      ) : null}

      <table ref={tableToSheetRef}>
        <thead>
          <tr>
            <th data-coluna="order-id">Pedido</th>
            <th data-coluna="excursao">Excursão</th>
            <th data-coluna="nome-completo">Nome Completo</th>
            <th data-coluna="cpf">CPF</th>
            <th data-coluna="telefone">Telefone</th>
            <th data-coluna="embarque" onClick={ordenarPassageiros}>
              Embarque
            </th>
            <th data-coluna="horario">Horário</th>
          </tr>
        </thead>
        <tbody>
          {reservas && reservas_f.length > 0
            ? reservas_f.map((reserva, _i) => {
                return (
                  <ItemReserva
                    key={_i}
                    reserva={reserva}
                    excDetails={excDetails}
                    setToast={setToast}
                  />
                );
              })
            : null}

          {reservas && reservas_f.length == 0
            ? reservas.map((reserva) => {
                return (
                  <ItemReserva
                    key={reserva.ID}
                    reserva={reserva}
                    excDetails={excDetails}
                    adminAjax={adminAjax}
                    setToast={setToast}
                  />
                );
              })
            : null}
        </tbody>
      </table>
    </div>
  );
}

AppReservasAdmin.propTypes = {
  ajaxUrl: PropTypes.string.isRequired,
};

const reserva_admin_app_root = document.getElementById('adminReservasApp');
if (reserva_admin_app_root) {
  ReactDOM.createRoot(reserva_admin_app_root).render(
    <AppReservasAdmin ajaxUrl={reserva_admin_app_root.dataset.ajaxUrl} />,
  );
}

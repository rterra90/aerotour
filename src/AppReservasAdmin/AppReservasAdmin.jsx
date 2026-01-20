/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import useAdminAjax from '../Hooks/useAdminAjax';
import SelectLiveSearch from './SelectLiveSearch';
import PageNavigation from './PageNavigation';
import ItemReserva from './ItemReserva';
import PropTypes from 'prop-types';
import Toast from './Toast';
import BotaoExportarXLS from './BotaoExportarXLS';

function AppReservasAdmin({ ajaxUrl }) {
  const [toast, setToast] = React.useState(false);
  const [reservas, setReservas] = React.useState([]);
  const [excDetails, setExcDetails] = React.useState(null);
  const [filter, setFilter] = React.useState(0);
  const [currentPage, setCurrentPage] = React.useState(1);
  const [pageSize, setPageSize] = React.useState(25); // padrão inicial

  const tableToSheetRef = React.useRef(null);

  const adminAjax = useAdminAjax(ajaxUrl);

  React.useEffect(() => {
    adminAjax.get_reservas(setReservas, setExcDetails);
  }, [adminAjax]);

  const reservasFiltradas = React.useMemo(() => {
    if (!reservas) return [];
    return filter > 0
      ? reservas.filter(r => r.variation_id == filter)
      : reservas;
  }, [reservas, filter]);

    // calcular total de páginas
  const totalPages = Math.ceil(reservasFiltradas.length / pageSize);

  // calcular registros da página atual
  const reservasPaginadas = React.useMemo(() => {
    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    return reservasFiltradas.slice(start, end);
  }, [reservasFiltradas, currentPage, pageSize]);


  return (
    <div id="adminReservasTable">
      {toast && <Toast message={toast} setToast={setToast} />}
      <div className="filtros">
        {excDetails && (
          <div className="filtros-interno">
            <SelectLiveSearch
              srcArray={Object.values(excDetails)}
              setFilter={setFilter}
              filter={filter}
            />
            {filter > 0 && <BotaoExportarXLS _ref={tableToSheetRef} />}
            
          </div>
        )}
              {/* navegação entre páginas */}
      <PageNavigation
        currentPage={currentPage}
        setCurrentPage={setCurrentPage}
        totalPages={totalPages}
        pageSize={pageSize}
        setPageSize={setPageSize}
        showPageSize={false}


      />
        
      </div>

      <p>{reservasFiltradas.length} reservas</p>

      <table ref={tableToSheetRef}>
        <thead>
          <tr>
            <th>Pedido</th>
            <th>Excursão</th>
            <th>Nome Completo</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th>Embarque</th>
            <th>Horário</th>
          </tr>
        </thead>
        <tbody>
          {reservasPaginadas.map(reserva => (
            <ItemReserva
              key={reserva.ID}
              reserva={reserva}
              excDetails={excDetails}
              setToast={setToast}
              adminAjax={adminAjax}
            />
          ))}
        </tbody>
      </table>

      {/* navegação entre páginas */}
      <PageNavigation
        currentPage={currentPage}
        setCurrentPage={setCurrentPage}
        totalPages={totalPages}
        pageSize={pageSize}
        setPageSize={setPageSize}
      />

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

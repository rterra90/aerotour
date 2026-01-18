/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const PageNavigation = ({currentPage, setCurrentPage, totalPages, pageSize, setPageSize, showPageSize = true}) => {
  return (
    <div id="tablePagination">
      {/* Controle de paginação */}
      <div className="pagination-nav">
        <button
          disabled={currentPage === 1}
          onClick={() => setCurrentPage(p => p - 1)}
        >
          Anterior
        </button>
        <span>Página {currentPage} de {totalPages}</span>
        <button
          disabled={currentPage === totalPages}
          onClick={() => setCurrentPage(p => p + 1)}
        >
          Próxima
        </button>
      </div>
      {/* seletor de limite por página */}
      {showPageSize ? 
      <div className="pagination-controls">
        <label>
          Registros por página:
          <select
            value={pageSize}
            onChange={e => {
              const val = parseInt(e.target.value, 10);
              setPageSize(val > 500 ? 500 : val);
              setCurrentPage(1); // resetar para primeira página
            }}
          >
            {[10, 25, 50, 100, 250, 500].map(opt => (
              <option key={opt} value={opt}>{opt}</option>
            ))}
          </select>
        </label>
      </div> : null}
    
    </div>
    
    
  )
}

PageNavigation.propTypes = {
  currentPage: PropTypes.number,
  setCurrentPage: PropTypes.func,
  totalPages: PropTypes.number,
  pageSize: PropTypes.number,
  setPageSize: PropTypes.func,
};

export default PageNavigation
/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const SelectLiveSearch = ({ srcArray, setFilter, filter }) => {
  const [status, setStatus] = React.useState('próximas');
  const [searchTerm, setSearchTerm] = React.useState('');
  const [isOpen, setIsOpen] = React.useState(false);
  const [selectedLabel, setSelectedLabel] = React.useState('');
  const wrapperRef = React.useRef(null);

  // Ordena excursões por data
  const sortedData = React.useMemo(() => {
    return [...srcArray].sort((a, b) => {
      const dateA = new Date(a[1].split('/').reverse().join('/'));
      const dateB = new Date(b[1].split('/').reverse().join('/'));
      return dateA - dateB;
    });
  }, [srcArray]);

  // Filtra excursões conforme status e busca
  const filteredOptions = React.useMemo(() => {
    const now = new Date().getTime();

    let data = sortedData.filter(item => {
      const diaTimestamp = new Date(item[1].split('/').reverse().join('/')).getTime();

      // aplica filtro de status
      if (status === 'próximas' && diaTimestamp + 172800000 < now) {
        return false;
      }
      if (status === 'passadas' && diaTimestamp > now) {
        return false;
      }

      // aplica filtro de busca
      if (searchTerm) {
        const texto = `${item[0]} ${item[1]}`.toLowerCase();
        return texto.includes(searchTerm.toLowerCase());
      }

      return true;
    });

    // se status = passadas, ordenar ao inverso (mais recentes primeiro)
    if (status === 'passadas') {
      data.sort((a, b) => {
        const dateA = new Date(a[1].split('/').reverse().join('/'));
        const dateB = new Date(b[1].split('/').reverse().join('/'));
        return dateB - dateA; // invertido
      });
    }

    return data;
  }, [sortedData, status, searchTerm]);

  // Fecha dropdown ao clicar fora
  React.useEffect(() => {
    function handleClickOutside(e) {
      if (wrapperRef.current && !wrapperRef.current.contains(e.target)) {
        setIsOpen(false);
      }
    }
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  // Seleciona opção
  function handleSelect(item) {
    setFilter(+item[2]);
    setSelectedLabel(`${item[0]} - ${item[1]}`);
    setSearchTerm('');
    setIsOpen(false);
  }

  // Limpar seleção
  function clearSelection() {
    setFilter(0);
    setSelectedLabel('');
    setSearchTerm('');
    setIsOpen(false);
  }

  return (
    <div className="live-search-wrapper" ref={wrapperRef}>
      <div className="live-search-header">
        <p>Filtre por excursão</p>
        {/* Alternador próximas/passadas */}
        <div className="selec-prox-pass">
          <span
            className={status === 'próximas' ? 'ativo' : ''}
            onClick={() => setStatus('próximas')}
          >
            próximas
          </span>{' '}
          |{' '}
          <span
            className={status === 'passadas' ? 'ativo' : ''}
            onClick={() => setStatus('passadas')}
          >
            passadas
          </span>
        </div>
      </div>
      

      {/* Campo de busca com botão limpar */}
      <div className="live-search-input-wrapper">
        <input
          type="text"
          placeholder={selectedLabel || "Buscar excursão..."}
          value={searchTerm}
          onFocus={() => setIsOpen(true)}
          onChange={e => setSearchTerm(e.target.value)}
          className="live-search-input"
        />
        {selectedLabel && (
          <button
            type="button"
            className="clear-btn"
            onClick={clearSelection}
          >
            ×
          </button>
        )}
      </div>

      {/* Dropdown de opções */}
      {isOpen && (
        <div className="live-search-options">
          {filteredOptions.length > 0 ? (
            filteredOptions.map(item => (
              <div
                key={item[2]}
                className={`dropdown-menu-item ${filter === +item[2] ? 'selected' : ''}`}
                onClick={() => handleSelect(item)}
              >
                {item[0]} - {item[1]}
              </div>
            ))
          ) : (
            <div className="no-results">Nenhuma excursão encontrada</div>
          )}
        </div>
      )}

      
    </div>
  );
};

SelectLiveSearch.propTypes = {
  srcArray: PropTypes.array.isRequired,
  setFilter: PropTypes.func.isRequired,
  filter: PropTypes.number.isRequired,
};

export default SelectLiveSearch;
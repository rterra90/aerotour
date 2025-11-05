/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import AppCheckInModalPax from './AppCheckInModalPax';
import AppCheckInPaxLi from './AppCheckInPaxLi';
import { convertDate } from '../Utilities';

const AppCheckInModal = ({
  setModalOpen,
  modalOpen,
  listaExcursoesElement,
}) => {
  const [variationId, excDetalhes] = modalOpen;
  const [modalLoading, setModalLoading] = React.useState(true);
  const [passageiros, setPassageiros] = React.useState([]);
  const [modalPax, setModalPax] = React.useState(null);
  const [sortType, setSortType] = React.useState('alphabetical');
  const [filterType, setFilterType] = React.useState('all');
  const modalElement = React.useRef(null);

  // 🔹 Função de ordenação
  const sortPassageiros = (list, _type = null) => {
    const _sortType = _type || sortType;
    setSortType(_sortType);

    if (_sortType === 'alphabetical') {
      return [...list].sort((a, b) =>
        a.p_nome.localeCompare(b.p_nome, 'pt-BR', { sensitivity: 'base' }),
      );
    }

    if (_sortType === 'boarding') {
      // cria um objeto agrupado por embarque
      const agrupado = list.reduce((acc, pax) => {
        const embarque = pax.embarque || 'Sem embarque';
        if (!acc[embarque]) acc[embarque] = [];
        acc[embarque].push(pax);
        return acc;
      }, {});

      // transforma em uma lista ordenada por nome do ponto de embarque
      const embarquesOrdenados = Object.keys(agrupado)
        .sort((a, b) => a.localeCompare(b, 'pt-BR'))
        .map((ponto) => ({
          embarque: ponto,
          passageiros: agrupado[ponto].sort((a, b) =>
            a.p_nome.localeCompare(b.p_nome, 'pt-BR'),
          ),
        }));
      return embarquesOrdenados;
    }

    return list;
  };

  // 🔹 Função de filtro
  const filterPassageiros = (list) => {
    if (filterType === 'sem-ida') return list.filter((p) => !p.saida);
    if (filterType === 'sem-volta') return list.filter((p) => !p.volta);
    return list;
  };

  // 🔹 Aplicar filtro + ordenação combinados
  const passageirosProcessados = React.useMemo(() => {
    const filtrados = filterPassageiros(passageiros);
    console.log(sortPassageiros(filtrados));
    return sortPassageiros(filtrados);
  }, [passageiros, sortType, filterType]);

  React.useEffect(() => {
    //utilizar adminApiFetch para pegar as reservas da excursão de id variationId
    adminApiFetch(
      'get_reservas',
      { variation_id: variationId },
      (success, data) => {
        console.log('get_reservas', success, data);
        const _passageiros = success && Array.isArray(data) ? data[0] : [];
        _passageiros.forEach((passageiro) => {
          passageiro.saida = passageiro.saida === '1';
          passageiro.volta = passageiro.volta === '1';
        });

        setPassageiros(success && Array.isArray(data) ? data[0] : []);
        setModalLoading(false);
      },
      'GET',
    );
    return () => {
      //limpeza se necessário
      setPassageiros([]);
      setModalLoading(true);
      listaExcursoesElement.current.style.display = 'block';
    };
  }, []);

  const toggleCheck = (paxId, sentido, valor, element) => {
    if (element.classList.contains('loading')) return; // evita cliques múltiplos
    element.classList.add('loading');
    if (element.children[0] && element.children[0].tagName === 'svg')
      element.children[0].style.visibility = 'hidden';
    adminApiFetch(
      'check_in',
      { pax_id: paxId, sentido: sentido, valor: valor ? '1' : '0' },
      (success) => {
        successCheckIn(success, paxId, sentido, valor);
        element.classList.remove('loading');
      },
      'POST',
    );
  };

  function successCheckIn(success, paxId, sentido, valor) {
    console.log('check_in', success);
    setPassageiros((prev) =>
      prev.map((p) => (p.ID === paxId ? { ...p, [sentido]: valor } : p)),
    );
  }
  return (
    <div id="checkInModal" ref={modalElement}>
      <div className="check-in-modal-inner">
        <span className="close" onClick={() => setModalOpen(false)}>
          Fechar
        </span>
        <h1>Check-in</h1>
        <h2>
          {excDetalhes.nome} -{' '}
          {convertDate(excDetalhes.dia, 'dmy').slice(0, -5)}
        </h2>
        {modalLoading && (
          <div>
            <span className="spinner is-active"></span>
          </div>
        )}

        {passageiros.length > 0 && !modalLoading && (
          <>
            <div className="check-in-header">
              <div className="header-options">
                <div>
                  <div className="option-wrapper">
                    <label htmlFor="sortSelect">Ordenar por:</label>
                    <select
                      id="sortSelect"
                      name="sortSelect"
                      value={sortType}
                      onChange={(e) =>
                        sortPassageiros(passageiros, e.target.value)
                      }
                    >
                      <option value="alphabetical">Ordem alfabética</option>
                      <option value="boarding">Embarque</option>
                    </select>
                  </div>

                  <div className="option-wrapper">
                    <label htmlFor="filterSelect">Filtrar:</label>
                    <select
                      id="filterSelect"
                      name="filterSelect"
                      value={filterType}
                      onChange={(e) => setFilterType(e.target.value)}
                    >
                      <option value="all">Todos</option>
                      <option value="sem-ida">Sem IDA</option>
                      <option value="sem-volta">Sem VOLTA</option>
                    </select>
                  </div>
                </div>
              </div>
              <div className="header-resume">
                <span>Passageiros: {passageiros.length}</span>
                <span>
                  Check ida: {passageiros.filter((pax) => pax.saida).length}
                </span>
                <span>
                  Check volta: {passageiros.filter((pax) => pax.volta).length}
                </span>
              </div>
            </div>
            <div className="check_in_lista_wrapper">
              <ul className="lista-check-in">
                {sortType === 'boarding' ? (
                  <>
                    {passageirosProcessados.map((grupo) => (
                      <div key={grupo.embarque} className="embarque-grupo">
                        <h4>
                          <div>
                            {grupo.embarque} &nbsp; {grupo.passageiros.length}
                          </div>
                          <span
                            onClick={({ target }) => {
                              const ul = target
                                .closest('.embarque-grupo')
                                .querySelector('ul');
                              if (ul.style.display === 'none') {
                                ul.style.display = 'block';
                                target.innerHTML = '-';
                              } else {
                                ul.style.display = 'none';
                                target.innerHTML = '+';
                              }
                            }}
                          >
                            -
                          </span>
                        </h4>
                        <ul>
                          {grupo.passageiros.map((pax) => (
                            <AppCheckInPaxLi
                              key={pax.ID}
                              pax={pax}
                              setModalPax={setModalPax}
                              toggleCheck={toggleCheck}
                            />
                          ))}
                        </ul>
                      </div>
                    ))}
                  </>
                ) : (
                  <>
                    {passageirosProcessados.map((pax) => {
                      return (
                        <AppCheckInPaxLi
                          key={pax.ID}
                          pax={pax}
                          setModalPax={setModalPax}
                          toggleCheck={toggleCheck}
                        />
                      );
                    })}
                  </>
                )}
              </ul>
            </div>
          </>
        )}
      </div>

      {modalPax && (
        <AppCheckInModalPax setModalPax={setModalPax} modalPax={modalPax} />
      )}
    </div>
  );
};

AppCheckInModal.propTypes = {
  setModalOpen: PropTypes.func.isRequired,
  modalOpen: PropTypes.oneOfType([PropTypes.bool, PropTypes.array]).isRequired,
  listaExcursoesElement: PropTypes.object.isRequired,
};

export default AppCheckInModal;

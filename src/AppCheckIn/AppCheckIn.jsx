/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import AppCheckInModal from './AppCheckInModal';
import { convertDate } from '../Utilities';

const AppCheckIn = () => {
  const [loading, setLoading] = React.useState(false);
  const [excursoes, setExcursoes] = React.useState(null);
  const [error, setError] = React.useState(null);
  const [modalOpen, setModalOpen] = React.useState(false);
  const listaExcursoesElement = React.useRef(null);

  function openCheckInModal(variation_id, data) {
    if (modalOpen) return; // já aberto
    listaExcursoesElement.current.scrollIntoView({
      behavior: 'smooth',
      block: 'start',
    });
    listaExcursoesElement.current.style.display = 'none';

    setModalOpen([variation_id, data]);
  }

  React.useEffect(() => {
    let cancelled = false; // evita atualização em unmount
    setLoading(true);
    //faz fetch para get_excursoes
    adminApiFetch(
      'get_excursoes',
      { filter: 'variacoes' },
      (success, data) => {
        if (cancelled) return;
        if (success && data?.atuais) {
          console.log('get_excursoes', success, data);
          setExcursoes(data.atuais);
        } else {
          console.error('Erro ao obter excursões:', data);
          setError('Erro ao obter excursões');
          setExcursoes([]); // evita null
        }
        setLoading(false);
      },
      'GET',
    );
    return () => {
      cancelled = true;
    };
  }, []);

  return (
    <div className="check-in-app-inner">
      {loading && (
        <div className="loading-indicator">
          <span className="spinner is-active"></span>
          <p>Carregando...</p>
        </div>
      )}

      {Array.isArray(excursoes) && excursoes.length > 0 && (
        <ul id="listaExcursoesCheckIn" ref={listaExcursoesElement}>
          <li>
            <span className="exc_name">Excursão</span>
            <span className="exc_total_passageiros">Passageiros</span>
            <span className="icone">Check-in</span>
          </li>
          {excursoes.map((_excursao) => (
            <li key={_excursao.variation_id}>
              <span className="exc_name">
                <a
                  href={`https://aerotour.com.br/wp-admin/post.php?post=${_excursao.parent_id}&action=edit`}
                >
                  {_excursao.nome} - {convertDate(_excursao.dia, 'dmy')}
                </a>
              </span>
              <span className="exc_total_passageiros">{_excursao.pax_qty}</span>
              <span
                className="icone dashicons dashicons-clipboard"
                onClick={() =>
                  openCheckInModal(_excursao.variation_id, {
                    nome: _excursao.nome,
                    dia: _excursao.dia,
                  })
                }
              ></span>
            </li>
          ))}
        </ul>
      )}

      {Array.isArray(excursoes) && excursoes.length === 0 && (
        <p>Nenhuma excursão disponível para check-in.</p>
      )}

      {error && <p>Erro ao obter as excursões...</p>}

      {modalOpen && Array.isArray(modalOpen) ? (
        <AppCheckInModal
          setModalOpen={setModalOpen}
          modalOpen={modalOpen}
          listaExcursoesElement={listaExcursoesElement}
        />
      ) : null}
    </div>
  );
};

const checkin_app_root = document.getElementById('checkInWidget');
if (checkin_app_root) {
  ReactDOM.createRoot(checkin_app_root).render(
    <AppCheckIn ajaxUrl={checkin_app_root.dataset.ajaxUrl} />,
  );
}

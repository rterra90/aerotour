/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import { Check } from 'lucide-react';
import AppCheckInModalPax from './AppCheckInModalPax';

const AppCheckInModal = ({ setModalOpen, modalOpen }) => {
  const [variationId, excDetalhes] = modalOpen;
  const [modalLoading, setModalLoading] = React.useState(true);
  const [passageiros, setPassageiros] = React.useState([]);
  const [modalPax, setModalPax] = React.useState(null);

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
    <div id="checkInModal">
      <div className="check-in-modal-inner">
        <span className="close" onClick={() => setModalOpen(false)}>
          Fechar
        </span>
        <h1>Check-in</h1>
        <h2>
          {excDetalhes.nome} - {excDetalhes.dia}
        </h2>
        {modalLoading && <p>Carregando...</p>}

        {passageiros.length > 0 && !modalLoading && (
          <>
            <div className="check_in_lista_wrapper">
              <ul className="lista-check-in">
                {passageiros.map((pax) => {
                  return (
                    <li key={pax.ID} className="pax-item">
                      <span
                        className="pax-nome"
                        onClick={() => setModalPax(pax)}
                        title="Ver detalhes"
                      >
                        {pax.p_nome}
                      </span>

                      <div className="check-group">
                        <button
                          className={`check-box ${pax.saida ? 'checked' : ''} ${
                            pax.ida_desativado ? 'disabled' : ''
                          }`}
                          onClick={({ currentTarget }) =>
                            !pax.ida_desativado &&
                            toggleCheck(
                              pax.ID,
                              'saida',
                              !pax.saida,
                              currentTarget,
                            )
                          }
                        >
                          {pax.saida && <Check size={14} strokeWidth={7} />}
                        </button>
                        <button
                          className={`check-box ${pax.volta ? 'checked' : ''} ${
                            pax.volta_desativado ? 'disabled' : ''
                          }`}
                          onClick={({ currentTarget }) =>
                            !pax.volta_desativado &&
                            toggleCheck(
                              pax.ID,
                              'volta',
                              !pax.volta,
                              currentTarget,
                            )
                          }
                        >
                          {pax.volta && <Check size={14} strokeWidth={7} />}
                        </button>
                      </div>
                    </li>
                  );
                })}
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
};

export default AppCheckInModal;

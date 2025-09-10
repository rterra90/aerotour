/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const AvisosModal = ({
  alertType,
  setAvisosModalOpen,
  openDateModal,
  openEmbarqueModal,
}) => {
  const [visible, setVisible] = React.useState(false);

  function closeAvisosModal(_action) {
    setVisible(false);
    setTimeout(() => {
      if (_action === 'goto-datas') {
        openDateModal(true);
      } else if (_action === 'goto-embarques') {
        openEmbarqueModal(true);
      }
      setAvisosModalOpen(false);
    }, 300);
  }

  React.useEffect(() => {
    setVisible(true);
  }, []);

  return (
    <div
      className={`modal-overlay ${visible ? 'show' : ''}`}
      onClick={closeAvisosModal}
    >
      <div
        className={`modal-content ${visible ? 'show' : 'hide'}`}
        onClick={(e) => e.stopPropagation()}
      >
        <h3>Aviso</h3>

        <div
          className="modal-warning"
          role="alertdialog"
          aria-labelledby="modal-warning-title"
          aria-describedby="modal-warning-desc"
        >
          {/* Conteúdo SEM DATA SELECIONADA */}
          {alertType == 'sem-data-selecionada' && (
            <>
              <h2 id="modal-warning-title" className="visually-hidden">
                Aviso de seleção de datas
              </h2>
              <p id="modal-warning-desc" className="warning-message">
                Selecione primeiro a(s) data(s) da excursão.
              </p>
              <div className="warning-actions">
                <button
                  type="button"
                  className="btn-primary"
                  onClick={() => closeAvisosModal('goto-datas')}
                >
                  Ir para seleção de datas
                </button>
                <button
                  type="button"
                  className="btn-secondary"
                  onClick={() => closeAvisosModal('cancel')}
                >
                  Cancelar
                </button>
              </div>
            </>
          )}

          {/* Conteúdo SEM EMBARQUE SELECIONADO */}
          {alertType == 'sem-embarque-selecionado' && (
            <>
              <h2 id="modal-warning-title" className="visually-hidden">
                Aviso de seleção de embarque
              </h2>
              <p
                id="modal-warning-desc"
                className="warning-message"
                onClick={() => closeAvisosModal('goto-embarques')}
              >
                Selecione primeiro o seu ponto de embarque.
              </p>
              <div className="warning-actions">
                <button
                  type="button"
                  className="btn-primary"
                  onClick={() => closeAvisosModal('goto-embarques')}
                >
                  Ir para seleção de embarque
                </button>
                <button
                  type="button"
                  className="btn-secondary"
                  onClick={() => closeAvisosModal('cancel')}
                >
                  Cancelar
                </button>
              </div>
            </>
          )}

          {/* Conteúdo LIMITE DE VAGAS ATINGIDO */}

          {alertType == 'max-vagas-atingido' && (
            <div className="error-container" role="alert" aria-live="assertive">
              <div className="error-icon">⚠️</div>
              <p className="error-message">
                Número máximo de vagas disponíveis atingido...
                {/* {variacoes.length > 1
                  ? 'Número máximo de vagas atingido para a(s) data(s) escolhida(s)...'
                  : 'Número máximo de vagas atingido para essa excursão...'} */}
              </p>
              <button
                className="close-button"
                type="button"
                onClick={() => closeAvisosModal('cancel')}
              >
                Fechar
              </button>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

AvisosModal.propTypes = {
  alertType: PropTypes.string.isRequired,
  setAvisosModalOpen: PropTypes.func.isRequired,
  openEmbarqueModal: PropTypes.func.isRequired,
  openDateModal: PropTypes.func.isRequired,
};

export default AvisosModal;

/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const EmbarquesModal = ({
  setEmbarqueModalOpen,
  toggleEmbarque,
  embarques,
  embarque,
  selectedDates,
  variacoes,
  getVarIdByDate,
  setHorario,
  variacoesSelecionadas,
  setPrecoUnitario,
  setTaxa,
}) => {
  const [visible, setVisible] = React.useState(false);
  const [embarquesNoPeriodo, setEmbarquesNoPeriodo] = React.useState([]);
  const [preEmbarque, setPreEmbarque] = React.useState([]);
  const [horariosDisponiveis, setHorariosDisponiveis] = React.useState([]);
  const [disponibilidadeParcial, setDisponibilidadeParcial] = React.useState(
    [],
  );

  const embarqueForm = React.useRef();
  const priceContainerRef = React.useRef();
  const saveBtnRef = React.useRef();

  function closeEmbarqueModal(_save) {
    if (_save && preEmbarque.length > 0)
      toggleEmbarque(preEmbarque[0].embarqueId);

    setVisible(false);
    setTimeout(() => {
      setEmbarqueModalOpen(false);
    }, 300);
  }

  function arrayToString(lista) {
    if (lista.length === 0) return '';
    if (lista.length === 1) return lista[0];
    if (lista.length === 2) return `${lista[0]} e ${lista[1]}`;

    const todasMenosUltima = lista.slice(0, -1).join(' , ');
    const ultima = lista[lista.length - 1];
    return `${todasMenosUltima} e ${ultima}`;
  }

  React.useEffect(() => {
    setVisible(true);
    /* Verifica e compara a disponibilidade dos embarques nas datas selecionadas */
    const embarquesPeriodo = [];
    embarques.forEach((_embarque) => {
      let _emb_obj = { embID: _embarque.embarqueId, variacoes: [] };
      selectedDates.forEach((_date) => {
        variacoes.forEach((_var) => {
          if (_var.attributes.attribute_dia == _date) {
            _emb_obj.variacoes.push({
              varID: _var.variation_id,
              varData: _date,
              disp: [],
            });
          }
        });
      });

      _embarque.horarios.forEach((_horario) => {
        _horario.disponibilidade.forEach((_disp) => {
          if (selectedDates.includes(_disp.disp_dia)) {
            _emb_obj.variacoes.forEach((_variacao) => {
              if (_variacao.varID == getVarIdByDate(_disp.disp_dia)) {
                _variacao.disp.push({
                  horario: _horario.horario,
                  status: _disp.status,
                });
              }
            });
          }
        });
      });

      embarquesPeriodo.push(_emb_obj);
    });

    //Desabilita a option do DOM se totalmente indisponível
    embarquesPeriodo.forEach((_e) => {
      let _total_horarios = 0;
      let _total_indisp = 0;
      _e.variacoes.forEach((_var) => {
        _var.disp.forEach((_hor) => {
          _total_horarios = _total_horarios + 1;
          if (_hor.status === 'indisponivel') {
            _total_indisp = _total_indisp + 1;
          }
        });
      });

      if (_total_horarios === _total_indisp) {
        let opcoesDom = embarqueForm.current.querySelectorAll('select option');
        opcoesDom.forEach((_op) => {
          if (_op.value == _e.embID) {
            _op.innerText = _op.innerText + ' - (indisponível)';
            _op.setAttribute('disabled', '');
          }
        });
      }
    });

    setEmbarquesNoPeriodo(embarquesPeriodo);

    /* Personaliza inputs se houver valor prévio */
    if (embarque && embarque.length > 0) {
      if (embarqueForm.current) {
        embarqueForm.current.querySelector('select').value =
          embarque[0].embarqueId;
      }
      setPreEmbarque([embarque[0]]);
    } else {
      embarqueForm.current.querySelector('select').value = '';
      setPreEmbarque([]);
    }
  }, []);

  React.useEffect(() => {
    setDisponibilidadeParcial([]);
    setHorariosDisponiveis([]);

    /* Atualiza o estado do embarque selecionado */
    if (preEmbarque.length > 0) {
      let _horariosDisp = [];
      const selectedEmbarque = embarquesNoPeriodo.find(
        (_embarque) => _embarque.embID == preEmbarque[0].embarqueId,
      );

      //Checa a disponibilidade do embarque escolhido na(s) data(s) selecionada(s)
      selectedEmbarque.variacoes.forEach((_variacao) => {
        let _indisponiveis = _variacao.disp.filter((_disp) => {
          if (!_horariosDisp.includes(_disp.horario))
            _horariosDisp.push(_disp.horario);
          return _disp.status === 'indisponivel';
        });
        if (_indisponiveis.length > 0) {
          _indisponiveis = _indisponiveis.map((_ind) => {
            _ind.dia = _variacao.varData;
            _ind.varID = _variacao.varID;
            return _ind;
          });
          setDisponibilidadeParcial((_val) => [..._val, ..._indisponiveis]);
        }
      });

      //Remove duplicatas e define horários existentes para o embarque
      let _array_horarios = Array.from(new Set(_horariosDisp));
      setHorariosDisponiveis(_array_horarios);
      if (_array_horarios.length === 1) setHorario(_array_horarios[0]);

      //Confere a disponibilidade de vagas do embarque na(s) data(s) selecionada(s)

      //Define o preço do embarque
      if (variacoesSelecionadas.length > 0) {
        const _precos = variacoesSelecionadas.map((_varId) => {
          const varObj = variacoes.filter((_v) => _v.variation_id == _varId)[0];
          return varObj.display_regular_price;
        });

        //eliminar valores duplicados de _precos
        const uniquePrecos = Array.from(new Set(_precos));

        //obter a propriedade "taxa" do embarque selecionado
        const taxaEmb =
          embarques.filter(
            (emb) => emb.embarqueId == preEmbarque[0].embarqueId,
          )[0]?.taxa || 0;
        setTaxa(+taxaEmb);
        if (uniquePrecos.length === 1) {
          const modalPriceElement =
            priceContainerRef.current.querySelector('span');
          modalPriceElement.innerText = +uniquePrecos[0] + taxaEmb;
          setPrecoUnitario(+uniquePrecos[0] + taxaEmb);
        } else setPrecoUnitario('varios');
      } else {
        window.alert('Nenhuma data selecionada');
        closeEmbarqueModal(false);
      }

      //Atualiza o estado do botão
      saveBtnRef.current.removeAttribute('disabled');
    } else {
      //Atualiza o estado do botão
      saveBtnRef.current.setAttribute('disabled', '');
    }
  }, [preEmbarque]);

  React.useEffect(() => {
    if (disponibilidadeParcial.length > 0) {
      saveBtnRef.current.setAttribute('disabled', '');
    }
  }, [disponibilidadeParcial]);

  return (
    <div
      className={`modal-overlay ${visible ? 'show' : ''}`}
      onClick={() => closeEmbarqueModal(false)}
    >
      <div
        className={`modal-content ${visible ? 'show' : ''}`}
        data-modal="embarque"
        onClick={(e) => e.stopPropagation()}
      >
        <h3>Selecione seu embarque</h3>
        <form className="embarque-list" ref={embarqueForm}>
          <select
            onChange={(e) =>
              setPreEmbarque(() => {
                return [
                  embarques.find((_emb) => _emb.embarqueId == e.target.value),
                ];
              })
            }
          >
            <option className="select-placeholder" disabled value="">
              Selecione...
            </option>
            {embarques.map(({ embarqueId, nome }) => {
              return (
                <option value={embarqueId} key={embarqueId}>
                  {nome}
                </option>
              );
            })}
          </select>

          <section
            className="embarque-details"
            aria-labelledby="embarque-heading"
          >
            {/* Placeholder */}
            {preEmbarque.length === 0 ? (
              <div className="placeholder-container">
                Selecione um local de embarque para ver os horários disponíveis
                e endereço detalhado.
              </div>
            ) : null}

            {/* Alerta de disponibilidade parcial */}
            {disponibilidadeParcial.length > 0 ? (
              <div className="alerta-reserva disponibilidade-parcial">
                Ops. O embarque selecionado não está disponível em{' '}
                {arrayToString(disponibilidadeParcial.map((_v) => _v.dia))}.
              </div>
            ) : null}

            {/* Informações sobre o embarque */}
            {disponibilidadeParcial.length === 0 && preEmbarque.length > 0 ? (
              <>
                <h2 id="embarque-heading" className="visually-hidden">
                  Detalhes do embarque
                </h2>

                <div className="embarque-details-inner">
                  {/* Horário simples */}
                  <div className="horarios">
                    {horariosDisponiveis.length === 1 && (
                      <>
                        <h3 className="title">Horário de embarque</h3>
                        <span className="horario-single d-block text-center">
                          {horariosDisponiveis[0]}
                        </span>
                      </>
                    )}

                    {/* Horários múltiplos */}
                    {horariosDisponiveis.length > 1 && (
                      <>
                        <p className="title">Selecione o horário</p>
                        <div className="multi-radios">
                          <label className="horario-opcao">
                            <input type="radio" name="horario" value="08:00" />
                            <span>08:00</span>
                          </label>
                          <label className="horario-opcao">
                            <input type="radio" name="horario" value="10:30" />
                            <span>10:30</span>
                          </label>
                        </div>
                      </>
                    )}
                  </div>

                  <div className="localizacao">
                    <h3 className="title my-2 mb-0">Local de embarque</h3>
                    <p className="info">
                      <strong>Endereço:</strong> {preEmbarque[0].endereco}
                    </p>
                    <p className="info">
                      <strong>Referência:</strong> {preEmbarque[0].obs}
                    </p>

                    <a
                      href={preEmbarque[0].link_mapa}
                      target="_blank"
                      rel="noreferrer"
                    >
                      Ver no Google Maps
                    </a>
                  </div>
                  <p className="price" ref={priceContainerRef}>
                    <strong>Valor:</strong> R$ <span>120,00</span>{' '}
                    <i>por passageiro</i>
                  </p>
                </div>
              </>
            ) : null}
          </section>

          <div className="modal-buttons">
            <button
              type="button"
              className="saveBtn"
              ref={saveBtnRef}
              onClick={() => closeEmbarqueModal(true)}
            >
              Salvar
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default EmbarquesModal;
EmbarquesModal.propTypes = {
  setEmbarqueModalOpen: PropTypes.func.isRequired,
  toggleEmbarque: PropTypes.func.isRequired,
  embarques: PropTypes.array.isRequired,
  embarque: PropTypes.array,
  selectedDates: PropTypes.array.isRequired,
  variacoes: PropTypes.array.isRequired,
  variacoesSelecionadas: PropTypes.array.isRequired,
  getVarIdByDate: PropTypes.func.isRequired,
  setHorario: PropTypes.func.isRequired,
  setPrecoUnitario: PropTypes.func.isRequired,
  setTaxa: PropTypes.func.isRequired,
};

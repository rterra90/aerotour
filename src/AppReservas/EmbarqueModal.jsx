/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';

const EmbarquesModal = ({
  setEmbarqueModalOpen,
  toggleEmbarque,
  embarquesDetalhes, // Nova prop: array de detalhes fixos
  embarquesVariacoes, // Nova prop: array de disponibilidade e horários
  embarque,
  variacoes,
  variacoesSelecionadas,
  setPrecoUnitario,
  setTaxa,
  estadoDestino,
  cidadesDiaAnterior,
  horario
}) => {
  const [visible, setVisible] = React.useState(false);
  const [preEmbarque, setPreEmbarque] = React.useState([]);
  const [preHorario, setPreHorario] = React.useState('');
  const [preMultiHorario, setPreMultiHorario] = React.useState([]);
  const [horariosDisponiveis, setHorariosDisponiveis] = React.useState([]);
  const [horariosPorVariacaoSelecionada, setHorariosPorVariacaoSelecionada] = React.useState(null);
  const [disponibilidadeParcial, setDisponibilidadeParcial] = React.useState([]);

  const embarqueForm = React.useRef();
  const priceContainerRef = React.useRef();
  const saveBtnRef = React.useRef();

  function closeEmbarqueModal(_save) {
    if (_save && preEmbarque.length > 0) {
      // O ID agora vem direto do objeto detalhe
      if(preHorario) toggleEmbarque(preEmbarque[0].id, preHorario); 
      else if(preMultiHorario) toggleEmbarque(preEmbarque[0].id, preMultiHorario)
      
    }
    setVisible(false);
    setTimeout(() => {
      setEmbarqueModalOpen(false);
    }, 300);
  }

  function arrayToString(lista) {
    if (lista.length === 0) return '';
    if (lista.length === 1) return lista[0];
    if (lista.length === 2) return `${lista[0]} e ${lista[1]}`;

    const todasMenosUltima = lista.slice(0, -1).join(', ');
    const ultima = lista[lista.length - 1];
    return `${todasMenosUltima} e ${ultima}`;
  }

  // Efeito 1: Inicialização e marcação de opções totalmente indisponíveis no Select
  React.useEffect(() => {
    setVisible(true);

    const opcoesDom = embarqueForm.current.querySelectorAll('select option');

    // Desabilita a option do DOM se totalmente indisponível nas datas selecionadas
    embarquesDetalhes.forEach((detalhe) => {
      let totalHorarios = 0;
      let totalIndisp = 0;

      variacoesSelecionadas.forEach((varId) => {
        const varData = embarquesVariacoes.find(v => v.variation_id == varId);
        if (varData) {
          const embVar = varData.variation_embarques.find(e => e.embarque_id == detalhe.id);
          if (embVar && embVar.horarios) {
            embVar.horarios.forEach(h => {
              totalHorarios++;
              if (h.status === 'indisponivel') totalIndisp++;
            });
          } else {
            // Se o embarque não existe nesta variação, tratamos como indisponível
            totalIndisp++;
            totalHorarios++;
          }
        }
      });

      if (totalHorarios > 0 && totalHorarios === totalIndisp) {
        opcoesDom.forEach((_op) => {
          if (_op.value == detalhe.id) {
            _op.innerText = _op.innerText + ' - (indisponível)';
            _op.setAttribute('disabled', '');
          }
        });
      }
    });

    /* Personaliza inputs se houver valor prévio */
    setPreHorario(horario ? horario : 'sem pre horário')

    if (embarque && embarque.length > 0) {
      if (embarqueForm.current) {
        embarqueForm.current.querySelector('select').value = embarque[0].id || embarque[0].embarqueId;
      }
      setPreEmbarque([embarque[0]]);
    } else {
      embarqueForm.current.querySelector('select').value = '';
      setPreEmbarque([]);
      setPreHorario('');
    }
  }, []);

  // Efeito 2: Monitora a seleção do embarque para buscar horários, taxas e restrições
  React.useEffect(() => {
    setDisponibilidadeParcial([]);
    setHorariosDisponiveis([]);

    // Reseta o preHorario se o embarque selecionado mudou
    if(preEmbarque.length > 0 && embarque.length > 0 && preEmbarque[0].id !== embarque[0].id) {
      setPreHorario('');
    }

    if (preEmbarque.length > 0) {
      let _horariosDisp = [];
      let indisponiveis = [];
      let taxaEmb = 0;
      
      const embId = preEmbarque[0].id;

      // Checa a disponibilidade do embarque escolhido na(s) data(s) selecionada(s)
      variacoesSelecionadas.forEach((varId) => {
        const varData = embarquesVariacoes.find(v => v.variation_id == varId);
        if (!varData) return;

        // console.log(varData);

        const embVar = varData.variation_embarques.find(e => e.embarque_id == embId);
        let hasAvailable = false;

        if (embVar) {
          taxaEmb = embVar.taxa || 0; // Atualiza a taxa com base no objeto de variação
          
          embVar.horarios.forEach(h => {

            //se status == 'disponivel', insere em _horariosDisp, se for 'indisponivel', insere em indisponiveis
            if (h.status === 'disponivel') {
              hasAvailable = true;

              // evita duplicatas de horários ao inserir em _horariosDisp
              if(!_horariosDisp.some(existing => existing.horario === h.horario)) {
                _horariosDisp.push({horario: h.horario, status: h.status, dia: varData.variation_dia, varID: varId});
              }

            } else if (h.status === 'indisponivel') {
              // indisponiveis.push({horario: h.horario, status: 'indisponivel' });
            }
          });
        }

        // Se variacoesSelecionadas.length > 1, verificar se os horários inseridos em _horariosDisp existem em todas as variações.
        // Para isso, vamos distribuir os elementos de _horariosDisp com base no valor de varId e depois filtrar apenas os horários que existem em todas as variações selecionadas.
        if (variacoesSelecionadas.length > 1) {
          const _horariosPorVariacao = {}; 
          variacoesSelecionadas.forEach((varId) => {
            const varData = embarquesVariacoes.find(v => v.variation_id == varId);
            if (!varData) return;

            _horariosPorVariacao[varId] = varData.variation_embarques
              .filter(emb => emb.embarque_id == embId)
              .flatMap(emb => emb.horarios)
              .filter(h => h.status === 'disponivel')
              .map(h => h);
          });

          setHorariosPorVariacaoSelecionada(_horariosPorVariacao);
          console.log('Horários por variação:', _horariosPorVariacao);


          // Filtra apenas os horários que existem em todas as variações selecionadas
          // const horariosComunsEmTodasVariacoes = _horariosDisp.filter(h => 
          //   variacoesSelecionadas.every(varId => 
          //     _horariosPorVariacao[varId] && _horariosPorVariacao[varId].includes(h.horario)
          //   )
          // );

          
          // Horários agregados de todas as variações, para comparações
          const horariosAgregados = [];
          Object.entries(_horariosPorVariacao).forEach(([_vID, _varHorario]) => { 
            _varHorario.forEach(_h => {
              if(!horariosAgregados.includes(_h.horario)) {
                horariosAgregados.push(_h.horario);
              }
            })
            
          });
console.log(horariosAgregados);
          // Verifica se todas as variações possuem horários disponíveis idênticos
          const objValues = Object.values(_horariosPorVariacao);
          const horariosIguaisEmTodasVariacoes = objValues.every(val => JSON.stringify(val) === JSON.stringify(objValues[0]));


          if(horariosAgregados.length === 1){
            setHorariosDisponiveis([{horario: horariosAgregados[0]}])
            setPreHorario(horariosAgregados[0])
          }else{
            setHorariosDisponiveis(_horariosPorVariacao);

            const _preMultiHorario = Object.entries(_horariosPorVariacao).map(([_key, _value]) => {
              if(_value.length > 1){
                return {varID: _key, varHorario: null};

              }else{
                return {varID: _key, varHorario: _value[0].horario};

              }
            })

            console.log(_preMultiHorario);
            setPreMultiHorario(_preMultiHorario);
          }



        }else{
          setHorariosPorVariacaoSelecionada(null);

          // Remove duplicatas e define horários existentes para o embarque
          const arrayHorarios = Array.from(new Set(_horariosDisp));
          setHorariosDisponiveis(arrayHorarios);

          // Regra: Configura o horário automaticamente APENAS se houver apenas 1 opção
          if(arrayHorarios.length === 1){
            setPreHorario(arrayHorarios[0].horario)
          }

        }


        // Se não houver horário disponível nesta data, registra como parcial
        if (!hasAvailable) {
          indisponiveis.push({
            dia: varData.variation_dia,
            varID: varId
          });
        }
      });

      if (indisponiveis.length > 0) {
        setDisponibilidadeParcial(indisponiveis);
      }



      // Define o preço do embarque
      if (variacoesSelecionadas.length > 0) {
        const _precos = variacoesSelecionadas.map((_varId) => {
          const varObj = variacoes.find((_v) => _v.variation_id == _varId);
          return varObj ? varObj.display_regular_price : 0;
        });
        
        const uniquePrecos = Array.from(new Set(_precos));
        setTaxa(+taxaEmb);

        if (uniquePrecos.length === 1) {
          const modalPriceElement = priceContainerRef.current.querySelector('span');
          if (modalPriceElement) {
              modalPriceElement.innerText = +uniquePrecos[0] + taxaEmb;
          }
          setPrecoUnitario(+uniquePrecos[0] + taxaEmb);
        } else {
          setPrecoUnitario('varios');
        }
      } else {
        window.alert('Nenhuma data selecionada');
        closeEmbarqueModal(false);
      }

      // Atualiza o estado do botão
      // saveBtnRef.current.removeAttribute('disabled');
    } else {
      // saveBtnRef.current.setAttribute('disabled', ''); 
    }
  }, [preEmbarque]);

  React.useEffect(() => {
    const temPreHorario = preHorario || preMultiHorario.length > 0;
    if(temPreHorario && preEmbarque.length > 0) {
      saveBtnRef.current.removeAttribute('disabled');
    } else {
      saveBtnRef.current.setAttribute('disabled', ''); 
    }
  }, [preHorario, preMultiHorario, preEmbarque]);

  // Efeito 3: Trava salvamento caso haja indisponibilidade em alguma data selecionada
  React.useEffect(() => {
    if (disponibilidadeParcial.length > 0 || (horariosDisponiveis.length > 1 && !horarioSelecionadoParaBotao())) {
      saveBtnRef.current.setAttribute('disabled', '');
    }
  }, [disponibilidadeParcial, horariosDisponiveis]);

  // Função auxiliar para verificação visual no frontend apenas
  function horarioSelecionadoParaBotao() {
     // A validação estrita do horário costuma ser tratada no formulário de destino.
     // Se for necessário travar o botão 'Salvar' até o horário ser escolhido quando há múltiplos, você pode vincular ao estado global do `horario`
     return true; 
  }

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
                  embarquesDetalhes.find((_emb) => _emb.id == e.target.value),
                ];
              })
            }
          >
            <option className="select-placeholder" disabled value="">
              Selecione...
            </option>
            {embarquesDetalhes.map(({ id, nome }) => {
              return (
                <option value={id} key={id}>
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
                Selecione um local de embarque para ver os horários disponíveis e endereço detalhado.
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
                  <div className="horarios">

                    {/* verifica se horariosDisponiveis é array */}

                    {Array.isArray(horariosDisponiveis) ? <>
                    {/* Horário simples */}
                    {horariosDisponiveis.filter(h => h.status !== 'indisponivel').length === 1 && (
                      <>
                        <h3 className="title">Horário de embarque</h3>
                        <span className="horario-single d-block text-center">
                          {horariosDisponiveis[0].horario}
                        
                        {/* Exibe badge "do dia anterior" */}
                        {estadoDestino === 'rj' && 
                        preEmbarque[0] && 
                        cidadesDiaAnterior.includes(preEmbarque[0].nome.split(' - ')[0]) ? 
                        <span className="aviso-dia-anterior">do dia anterior</span> : null}
                        </span>
                      </>
                    )}

                    {/* Horários múltiplos - Renderização Dinâmica e Escolha do Usuário */}
                    {horariosDisponiveis.filter(h => h.status !== 'indisponivel').length > 1 && (
                      <>
                        <h3 className="title">Selecione o horário</h3>
                            <div className="multi-radios">
                              {horariosDisponiveis.map((h, index) => (
                                <label className={h.status !== 'indisponivel' ? 'horario-opcao' : 'horario-opcao disabled'} key={index}>
                                  <input 
                                    type="radio" 
                                    name="horario" 
                                    value={h.horario} 
                                    onChange={(e) => setPreHorario(e.target.value)} 
                                    disabled={h.status === 'indisponivel'} 
                                    checked={preHorario === h.horario}
                                  />
                                  <span>{h.horario}</span>
                                </label>
                              ))}
                            </div>
                      </>
                    )}
                    </> : (
                      <div className="horarios-multiplas-datas">
                        <h3 className="title">Horários de embarque por data</h3>
                        
                        {Object.entries(horariosDisponiveis).map(([dataKey, horariosDaData]) => {
                          // Verifica se os itens do array são strings ("17:00") ou objetos ({horario: "17:00", status: "disponivel"})
                          const isStringArray = typeof horariosDaData[0] === 'string';
                          
                          // Filtra os horários disponíveis para a data atual do loop
                          const disponiveis = horariosDaData.filter(h => 
                            isStringArray ? true : h.status !== 'indisponivel'
                          );

                          return (
                            <div key={dataKey} className="data-section mb-4">
                              {/* Identificação de qual dia/variação são esses horários */}
                              <h4 className="subtitle mb-2" style={{fontSize: '16px', fontWeight: 'bold'}}>Data/Reserva: {dataKey}</h4>
                              
                              {/* Horário simples para esta data específica */}
                              {disponiveis.length === 1 && (
                                <span className="horario-single d-block text-center mb-3">
                                  {isStringArray ? disponiveis[0] : disponiveis[0].horario}
                                  
                                  {/* Exibe badge "do dia anterior" se a lógica for atendida */}
                                  {estadoDestino === 'rj' && 
                                  preEmbarque[0] && 
                                  cidadesDiaAnterior.includes(preEmbarque[0].nome.split(' - ')[0]) ? 
                                  <span className="aviso-dia-anterior ms-2">do dia anterior</span> : null}
                                </span>
                              )}

                              {/* Horários múltiplos para esta data específica */}
                              {disponiveis.length > 1 && (
                                <div className="multi-radios mb-3">
                                  {horariosDaData.map((h, index) => {
                                    const horarioTexto = isStringArray ? h : h.horario;
                                    const isDisabled = !isStringArray && h.status === 'indisponivel';

                                    return (
                                      <label 
                                        className={!isDisabled ? 'horario-opcao' : 'horario-opcao disabled'} 
                                        key={`${dataKey}-${index}`}
                                      >
                                        <input 
                                          type="radio" 
                                          /* O nome precisa ser único por data para que os radios não interfiram uns nos outros */
                                          name={`horario-${dataKey}`} 
                                          value={horarioTexto} 
                                          disabled={isDisabled} 
                                          
                                          /* ATENÇÃO: Como agora são múltiplas datas, o state preHorario 
                                             idealmente precisa ser um objeto para armazenar a escolha de cada dia */
                                          onChange={(e) => setPreHorario(prev => ({ 
                                            ...prev, 
                                            [dataKey]: e.target.value 
                                          }))} 
                                          
                                          checked={typeof preHorario === 'object' && preHorario[dataKey] === horarioTexto}
                                        />
                                        <span>{horarioTexto}</span>
                                      </label>
                                    );
                                  })}
                                </div>
                              )}
                            </div>
                          );
                        })}
                      </div>
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
  embarquesDetalhes: PropTypes.array.isRequired,
  embarquesVariacoes: PropTypes.array.isRequired,
  embarque: PropTypes.array,
  selectedDates: PropTypes.array.isRequired,
  variacoes: PropTypes.array.isRequired,
  variacoesSelecionadas: PropTypes.array.isRequired,
  getVarIdByDate: PropTypes.func.isRequired,
  setPrecoUnitario: PropTypes.func.isRequired,
  setTaxa: PropTypes.func.isRequired,
  estadoDestino: PropTypes.string.isRequired,
  cidadesDiaAnterior: PropTypes.array.isRequired,
  horario: PropTypes.string.isRequired,

};
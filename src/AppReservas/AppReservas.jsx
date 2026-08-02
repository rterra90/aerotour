/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */

import DatesModal from './DatesModal.jsx';
import EmbarqueModal from './EmbarqueModal.jsx';
import PaxModal from './PaxModal.jsx';
// import PropTypes from 'prop-types';
import PaxCard from './PaxCard.jsx';
import AvisosModal from './AvisosModal.jsx';
import PrecoReservas from './PrecoReservas.jsx';
import {
  convertDate,
  dataTrintaDiasAntes,
  dataTemDescontoHoje,
} from '../Utilities';

function AppReservas() {
  const { variacoes, embarquesDetalhes, embarquesVariacao, productId, estadoDestino } = window.singleProductData;
  const {ajaxUrl, cartUrl} = window.themeLinks;

  const [availableDates, setAvailableDates] = React.useState([]);
  const [selectedDates, setSelectedDates] = React.useState([]);
  const [variacoesSelecionadas, setVariacoesSelecionadas] = React.useState([]);
  const [dateModalOpen, setDateModalOpen] = React.useState(false);
  const [embarqueModalOpen, setEmbarqueModalOpen] = React.useState(false);
  const [paxModalOpen, setPaxModalOpen] = React.useState(false);
  const [avisosModalOpen, setAvisosModalOpen] = React.useState(false);
  const [embarque, setEmbarque] = React.useState([]);
  const [horario, setHorario] = React.useState(null);
  const [maxVagas, setMaxVagas] = React.useState(null);
  const [passageiros, setPassageiros] = React.useState([]);
  const [precoUnitario, setPrecoUnitario] = React.useState(0);
  const [taxa, setTaxa] = React.useState(0);
  const [loading, setLoading] = React.useState(false);
  const [excursaoEncerrada, setExcursaoEncerrada] = React.useState(false);
  const [totalCost, setTotalCost] = React.useState('R$ 0,00');
  const [discountCost, setDiscountCost] = React.useState(false);
  const [dataLimiteDesconto, setDataLimiteDesconto] = React.useState([]);

  const botaoContinuarRef = React.useRef();
  const dataBoxRef = React.useRef();
  const embarqueBoxRef = React.useRef();

  // const totalCost = precoUnitario * passageiros.length * selectedDates.length;

  const cidadesDiaAnterior = ['Campinas', 'Limeira', 'Americana', 'Sumaré', 'Itu', 'Salto', 'Indaiatuba'];

  function calculaValorTotal() {
    const total = precoUnitario * passageiros.length * selectedDates.length;
    // formata o valor como moeda BRL
    const formatar = (valor) =>
      valor.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL',
        minimumFractionDigits: 2,
      });
    setTotalCost(formatar(total));

    if (!total) return setDiscountCost(false);
    // verifica se alguma data tem desconto antecipado
    const temDesconto = selectedDates.some((data) =>
      availableDates.find((d) => d.dia === data && d.desconto_antecipado),
    );
    if (total > 0) {
      setDiscountCost(temDesconto ? formatar(total * 0.95) : false);
    } else {
      setDiscountCost(false);
    }
  }

  React.useEffect(() => {
    const temData = selectedDates.length > 0;
    const temEmbarque = embarque.length > 0;
    const temHorario = horario && horario.length > 0;
    const temPassageiros = passageiros.length > 0;

    if (temData && temEmbarque && temHorario && temPassageiros) {
      botaoContinuarRef.current.removeAttribute('disabled');
    } else {
      botaoContinuarRef.current.setAttribute('disabled', '');
    }

    calculaValorTotal();
  }, [selectedDates, embarque, horario, passageiros]);

  React.useEffect(() => {
    if (loading) {
      botaoContinuarRef.current.setAttribute('disabled', '');
      botaoContinuarRef.current.innerHTML =
        '<span class="loadingElement my-0"></span>';
      return;
    }else{
      botaoContinuarRef.current.innerHTML = 'Continuar';
      botaoContinuarRef.current.removeAttribute('disabled');

    }
  }, [loading]);

  React.useEffect(() => {
    if (variacoes.length == 1) {
      if (variacoes[0].encerrar_vendas) setExcursaoEncerrada(true);
      else {
        const singleVarId = variacoes[0].variation_id;

        const dataPayload = [
          variacoes[0].attributes.attribute_dia,
          singleVarId,
          getAvailabilityById(singleVarId),
        ];

        toggleDate([dataPayload]);
      }
    } else if (variacoes.length > 1) {
      const todasEncerradas = variacoes.every(
        (variacao) => variacao.encerrar_vendas,
      );
      if (todasEncerradas) setExcursaoEncerrada(true);
    }

    //obter as datas do evento
    variacoes.map((variacao) => {
      let _dia = variacao.attributes.attribute_dia;
      let _dia_iso = convertDate(_dia, 'iso');
      let _disponiveis = getAvailabilityById(variacao.variation_id);
      let _i = 0;

      setAvailableDates((_previous) => {
        const dataLimiteDesconto = dataTrintaDiasAntes(_dia_iso);
        const temDescontoAntecipado = dataTemDescontoHoje(_dia_iso);

        // apenas de estiver na primeira iteração e se variacoes.length === 1, seta o estado
        if (variacoes.length === 1 && _i === 0) {
          setDataLimiteDesconto([dataLimiteDesconto]);
        }
        _i++;

        _previous.push({
          dia: _dia,
          disponiveis: _disponiveis,
          encerrado: variacao.encerrar_vendas,
          variacao: variacao.variation_id,
          desconto_antecipado: temDescontoAntecipado,
          desconto_antecipado_val: dataLimiteDesconto,
        });

        return _previous;
      });
    });
  }, []);

  function submitToCart(index = 0) {
    if (!loading) setLoading(true);

    if (index >= selectedDates.length) {
      botaoContinuarRef.current.innerHTML = 'Redirecionando para o carrinho...';
      window.location.href = cartUrl;
      return;
    }

    const submitQty = passageiros.length;
    const submitTaxa = taxa;
    const submitEmbarque = embarque ? embarque[0].id : null;

    const submitHorario = horario;

    const submitPax = passageiros.length > 0 ? JSON.stringify(passageiros) : null;

    const _date = selectedDates[index];
    const submitVarId = getVarIdByDate(_date);

    const lastSelectedDate = selectedDates[selectedDates.length - 1];
    const hasDiscount = discountCost ? convertDate(lastSelectedDate, 'iso') : false;
    const payload = {
        action: 'add_variation_to_cart',
        product_id: productId,
        variation_id: submitVarId,
        quantity: submitQty,
        taxa: submitTaxa,
        embarque: submitEmbarque,
        horario: submitHorario,
        passageiros: submitPax,
        desconto_antecipado: hasDiscount,
      }

    $.ajax({
      type: 'POST',
      url: ajaxUrl,
      dataType: 'json',
      data: payload,
      success: function (response) {
        // WooCommerce retorna { error: true, messages: "..."} quando bloqueia
        if (response.error) {
          setLoading(false);
          setAvisosModalOpen(response.type);

          return; // interrompe fluxo
        }

        // se deu certo, chama próxima
        submitToCart(index + 1);
      },
      error: function (xhr, status, error) {
        console.error('Erro AJAX:', error);
        setLoading(false);
        // não prossegue em caso de erro
      },
    });
  }

  function openDateModal() {
    setDateModalOpen(true);
  }

  function openEmbarqueModal() {
    if (selectedDates.length > 0) setEmbarqueModalOpen(true);
    else setAvisosModalOpen('sem-data-selecionada');
  }

  function openPaxModal(mode = 'add', paxData = null, index = null) {
    //verifica se já existe data e embarque selecionados
    if (selectedDates.length < 1) {
      setAvisosModalOpen('sem-data-selecionada');
      return;
    } else if (embarque.length < 1) {
      setAvisosModalOpen('sem-embarque-selecionado');
      return;
    } else {
      if (maxVagas <= passageiros.length)
        setAvisosModalOpen('max-vagas-atingido');
      else setPaxModalOpen([true, mode, paxData, index]);
    }
  }

  //Função que retorna o ID da variação a partir da data
  const getVarIdByDate = (date_str) => {
    const foundVar = variacoes.find(
      (_var) => _var.attributes.attribute_dia == date_str,
    );
    return foundVar ? foundVar.variation_id : undefined;
  };

  const getAvailabilityById = (_id) => {
    const _var = variacoes.filter((_v) => _v.variation_id == _id)[0];
    const _payload = _var.availability_html;
    const _html = new DOMParser().parseFromString(_payload, 'text/html');
    return _html.querySelector('p')?.textContent || 0;
  };

  const toggleDate = (dataPayload) => {
    setSelectedDates([]);
    setVariacoesSelecionadas([]);
    setEmbarque([]);
    setPrecoUnitario(0);
    if (!dataPayload || dataPayload.length === 0) {
      return;
    } else if (dataPayload.length > 0) {
      const arrayDatas = dataPayload.map((_payload) => _payload[0]);
      const sorted = arrayDatas.sort(
        (a, b) => convertDate(a, 'dateobject') - convertDate(b, 'dateobject'),
      );
      setSelectedDates(sorted);

      const arrayVarIds = dataPayload.map((_payload) => _payload[1]);
      setVariacoesSelecionadas(() => arrayVarIds);

      //verifica disponibilidade de vagas nas datas selecionadas
      const vagasPorDia = dataPayload.map((_payload) => +_payload[2]);
      setMaxVagas(Math.min(...vagasPorDia));
    }
  };

  const toggleEmbarque = (idEmbarqueSelecionado, horarioSelecionado) => {
    
    embarquesDetalhes.forEach(embDet => {
      if(embDet.id === idEmbarqueSelecionado){
        setEmbarque([embDet]);

        setHorario(horarioSelecionado);
        
      }
    })
  };

  // gtag('event', 'botao_reserva_click', {});
  return (
    <>
      <div id="newReservasContainer">
        <p className="main-title">Faça aqui sua reserva</p>

        {!excursaoEncerrada ? (
          <>
            <p className="section-title">Data e local de embarque</p>

            <div className="grid-row">
              {/* datas */}
              <div
                className="grid-item clickable grid-dates"
                data-fill={selectedDates.length < 1 ? 'false' : 'true'}
                onClick={openDateModal}
                ref={dataBoxRef}
              >
                <div className="icon">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    className="bi bi-calendar2-event"
                    viewBox="0 0 16 16"
                  >
                    <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z" />
                    <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z" />
                    <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5z" />
                  </svg>
                </div>
                <div className="text">
                  {selectedDates.length === 0 ? (
                    <span className="empty-text-placeholder">
                      Selecionar
                      <br /> data...
                    </span>
                  ) : (
                    <>
                      <span className="box-title">
                        {selectedDates.length > 1
                          ? 'Datas selecionadas'
                          : 'Data selecionada'}
                        :{' '}
                      </span>
                      <ul className={selectedDates.length > 1 ? 'multi' : ''}>
                        {selectedDates.map((d, i) => (
                          <li key={i}>
                            {d === '31/12/2026' ? 'A definir...' : d}
                          </li>
                        ))}
                      </ul>
                    </>
                  )}
                </div>
                <div className="edit-icon">✏️</div>
              </div>

              {/* embarque */}
              <div
                className="grid-item clickable grid-embarque"
                data-fill={embarque.length < 1 ? 'false' : 'true'}
                onClick={openEmbarqueModal}
                ref={embarqueBoxRef}
              >
                <div className="sub-embarque d-flex">
                  <div className="icon">
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      className="bi bi-geo-alt-fill"
                      viewBox="0 0 16 16"
                    >
                      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                    </svg>
                  </div>
                  <div className="text">
                    {embarque.length === 0 ? (
                      <span className="empty-text-placeholder">
                        Selecionar <br />
                        embarque...
                      </span>
                    ) : (
                      <>
                        <span className="box-title">Embarque</span>
                        <span>{embarque && embarque[0].nome}</span>
                      </>
                    )}
                  </div>
                </div>
                {embarque.length > 0 && (
                  <>
                    <div className="sub-horario d-flex mt-2">
                      <div className="icon">🕙</div>
                      <span>{typeof horario === 'string' ? horario : 'lado'}</span>

                      <div className="text"> </div>
                    </div>
                  </>
                )}

                <div className="edit-icon">✏️</div>
              </div>
            </div>

            <p className="section-title">Passageiros</p>
            <div className="passenger-list">
              {passageiros.length > 0 ? (
                <>
                  {passageiros.map((_pax, index) => {
                    return (
                      <PaxCard
                        pax={_pax}
                        key={_pax.cpf}
                        index={index}
                        setPassageiros={setPassageiros}
                        openPaxModal={openPaxModal}
                      />
                    );
                  })}
                </>
              ) : (
                <>
                  <div className="placeholder-container mt-1">
                    Nenhum passageiro adicionado. Clique em &quot;Adicionar novo
                    passageiro&quot; para começar.
                  </div>
                </>
              )}

              {/* Botao Adicionar passageiro */}
              <div
                className="passenger-card add-passenger"
                onClick={() => openPaxModal('add')}
              >
                <div className="avatar">➕</div>
                <div className="info">
                  <div className="top-row">
                    <div className="name">Adicionar novo passageiro</div>
                  </div>
                </div>
              </div>
            </div>

            <PrecoReservas
              passageiros={passageiros}
              selectedDates={selectedDates}
              precoUnitario={precoUnitario}
              totalCost={totalCost}
              discountCost={discountCost}
              dataLimiteDesconto={dataLimiteDesconto}
            />

            <button
              id="reservasContinuar"
              ref={botaoContinuarRef}
              className="main-btn single_add_to_cart_button"
              // disabled={!(passengers.length > 0 && termsChecked)}
              onClick={() => submitToCart()}
            >
              Continuar
            </button>

            {/* Modal de embarque */}
            {embarqueModalOpen && (
              <EmbarqueModal
                setEmbarqueModalOpen={setEmbarqueModalOpen}
                toggleEmbarque={toggleEmbarque}
                embarquesDetalhes={embarquesDetalhes}
                embarquesVariacoes={embarquesVariacao}
                embarque={embarque}
                selectedDates={selectedDates}
                variacoes={variacoes}
                getVarIdByDate={getVarIdByDate}
                variacoesSelecionadas={variacoesSelecionadas}
                setPrecoUnitario={setPrecoUnitario}
                setTaxa={setTaxa}
                estadoDestino={estadoDestino}
                cidadesDiaAnterior={cidadesDiaAnterior}
                horario={horario}
              />
            )}

            {/* Modal de datas */}
            {dateModalOpen && (
              <DatesModal
                setDateModalOpen={setDateModalOpen}
                availableDates={availableDates}
                selectedDates={selectedDates}
                toggleDate={toggleDate}
                getVarIdByDate={getVarIdByDate}
                getAvailabilityById={getAvailabilityById}
                passageiros={passageiros}
                dataLimiteDesconto={dataLimiteDesconto}
                setDataLimiteDesconto={setDataLimiteDesconto}
              />
            )}

            {/* Modal de passageiro */}
            {paxModalOpen != false && (
              <PaxModal
                setPaxModalOpen={setPaxModalOpen}
                paxModalOpen={paxModalOpen}
                selectedDates={selectedDates}
                passageiros={passageiros}
                setPassageiros={setPassageiros}
                convertDate={convertDate}
                variacoesSelecionadas={variacoesSelecionadas}
                embarqueId={embarque[0].id}
              />
            )}

            {/* Modal de avisos */}
            {avisosModalOpen && (
              <AvisosModal
                alertType={avisosModalOpen}
                setAvisosModalOpen={setAvisosModalOpen}
                openDateModal={openDateModal}
                openEmbarqueModal={openEmbarqueModal}
              />
            )}
          </>
        ) : (
          <>
            <div className="mensagem-encerrada">
              Reservas encerradas para essa excursão.
            </div>
          </>
        )}
      </div>
    </>
  );
}

AppReservas.propTypes = {};

addEventListener('DOMContentLoaded', () => {
const reservas_app_root = document.getElementById('reserva_app');
  if (reservas_app_root) {
    ReactDOM.createRoot(reservas_app_root).render(
      <AppReservas />,
    );
  }
});

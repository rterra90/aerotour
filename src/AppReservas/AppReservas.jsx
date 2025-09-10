/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */

import Passageiros from './Passageiros.jsx';
import DatesModal from './DatesModal.jsx';
import EmbarqueModal from './EmbarqueModal.jsx';
import PaxModal from './PaxModal.jsx';
import PropTypes from 'prop-types';
import PaxCard from './PaxCard.jsx';
import AvisosModal from './AvisosModal.jsx'; // Ensure this path is correct
import PrecoReservas from './PrecoReservas.jsx'; // Ensure this path is correct

function AppReservas({ variacoes, embarques, productId }) {
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
  const botaoContinuarRef = React.useRef();

  const totalCost = precoUnitario * passageiros.length * selectedDates.length;

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
  }, [selectedDates, embarque, horario, passageiros]);

  function submitToCart() {
    console.log('chamou submitToCart');
    const submitQty = passageiros.length;
    const submitTaxa = taxa;
    const submitEmbarque = embarque ? embarque[0].embarqueId : null;
    const submitHorario = horario;
    const submitPax = passageiros.length > 0 ? passageiros : null;
    selectedDates.forEach((_date) => {
      const submitVarId = getVarIdByDate(_date);
      console.log(
        submitQty,
        submitTaxa,
        submitEmbarque,
        submitHorario,
        submitPax,
        submitVarId,
      );
    });
  }

  function openDateModal() {
    setDateModalOpen(true);
    setAvailableDates([]);

    //obter as datas
    variacoes.map((variacao) => {
      let _dia = variacao.attributes.attribute_dia;
      let _disponiveis = getAvailabilityById(variacao.variation_id);

      setAvailableDates((_previous) => {
        _previous.push({
          dia: _dia,
          disponiveis: _disponiveis,
          encerrado: variacao.encerrar_vendas,
          variacao: variacao.variation_id,
        });
        return _previous;
      });
    });
  }

  function openEmbarqueModal() {
    if (selectedDates.length > 0) setEmbarqueModalOpen(true);
    else {
      setAvisosModalOpen('sem-data-selecionada');
    }
  }

  function openPaxModal(mode = 'add', paxData = null, index = null) {
    //verifica se já existe data e embarque selecionados, se não houver exibe um alert
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

  // Função para converter "dd/mm/aaaa" em objeto Date
  function parseDate(str) {
    const [day, month, year] = str.split('/');
    return new Date(`${year}-${month}-${day}`);
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
    if (!dataPayload || dataPayload.length === 0) {
      return;
    } else if (dataPayload.length > 0) {
      const arrayDatas = dataPayload.map((_payload) => _payload[0]);
      const sorted = arrayDatas.sort((a, b) => parseDate(a) - parseDate(b));
      setSelectedDates(sorted);

      const arrayVarIds = dataPayload.map((_payload) => _payload[1]);
      setVariacoesSelecionadas(() => arrayVarIds);

      //verifica disponibilidade de vagas nas datas selecionadas
      const vagasPorDia = dataPayload.map((_payload) => +_payload[2]);
      setMaxVagas(Math.min(...vagasPorDia));
    }
  };

  const toggleEmbarque = (embId) => {
    embarques.forEach((_emb) => {
      if (_emb.embarqueId == embId) {
        setEmbarque([_emb]);
      }
    });
  };

  // gtag('event', 'botao_reserva_click', {});

  // BARREIRA

  const [variacaoAtual, setVariacaoAtual] = React.useState(null);
  // const [embarque, setEmbarque] = React.useState(null);
  const [horariosEmbarque, setHorariosEmbarque] = React.useState(null);
  // const [passageiros, setPassageiros] = React.useState([]);
  const [botaoContinuar, setBotaoContinuar] = React.useState(false);
  const [loading, setLoading] = React.useState(false);
  const [precoPadrao, setPrecoPadrao] = React.useState(false);
  const [vagasVar, setVagasVar] = React.useState(null);

  React.useEffect(() => {
    //Se houver uma única variação, define como variacaoAtual
    if (variacoes.length === 1 && embarques) setVariacaoAtual(variacoes[0]);
  }, []);

  React.useEffect(() => {
    if (variacaoAtual) setPrecoPadrao(+variacaoAtual.display_regular_price);
    // setPreco(false);
    setPassageiros([]);
    setHorariosEmbarque(null);
    const horariosWrapper = document.querySelector(
      '.excursao-details .horarios-wrapper',
    );
    if (horariosWrapper) horariosWrapper.classList.remove('show-alert');
    setBotaoContinuar(false);

    //DISPONIBILIDADE DE VAGAS GERAL
    if (variacaoAtual) {
      const parser = new DOMParser();
      const _html = parser.parseFromString(
        variacaoAtual.availability_html,
        'text/html',
      );
      if (variacaoAtual.availability_html)
        setVagasVar(+_html.querySelector('p').textContent);
      else setVagasVar(0);
    }
  }, [variacaoAtual]);

  React.useEffect(() => {
    verificaBotaoContinuar();
  }, [botaoContinuar]);

  function handleSelectEmbarque({ target }) {
    target.parentElement.nextElementSibling
      .querySelector('.horarios-wrapper')
      .classList.add('show-alert');

    setEmbarque(+target.selectedOptions[0].dataset.id);

    setTaxa(() => {
      const embObj = embarques.filter((_emb) => _emb.nome == target.value)[0];

      if (embObj.taxa == 'unset' || embObj.taxa == '0') return 0;
      else return +embObj.taxa;
    });

    setHorariosEmbarque(() => {
      const selectedOption = Array.prototype.slice
        .call(target.children)
        .filter((opt) => opt.selected)[0];

      let _return = JSON.parse(selectedOption.dataset.horarios);
      return _return;
    });
  }

  function handleClickHorario({ target }) {
    setHorario(target.innerText);
    target.parentElement
      .querySelectorAll('span')
      .forEach((btn) => btn.classList.remove('active'));
    target.classList.add('active');
    target.parentElement.classList.remove('show-alert');
  }

  function handlePassageirosContainer({ target }) {
    const passageirosContainer = document.querySelector('#modulo_passageiros');
    setPassageiros([{ nome_completo: '', doc: '', telefone: '' }]);

    gtag('event', 'botao_reserva_click', {});

    if (passageirosContainer.classList.contains('d-none')) {
      target.setAttribute('disabled', '');
      target.classList.add('d-none');
      passageirosContainer.classList.remove('d-none');
      setTimeout(() => passageirosContainer.classList.add('animate-in'), 120);
    } else {
      target.removeAttribute('disabled');
      passageirosContainer.classList.add('d-none');
      target.classList.remove('d-none');
      passageirosContainer.classList.remove('animate-in');
      setTimeout(() => passageirosContainer.classList.remove('d-none'), 500);
    }
    setBotaoContinuar(!botaoContinuar);
  }

  function verificaBotaoContinuar() {
    if (botaoContinuar) {
      document
        .querySelector('.single_add_to_cart_button')
        .removeAttribute('disabled');
    }
  }

  return (
    <>
      <>
        <div id="newReservasContainer">
          <p className="main-title">Faça aqui sua reserva</p>
          <p className="section-title">Data e local de embarque</p>

          <div className="grid-row">
            {/* datas */}
            <div
              className="grid-item clickable grid-dates"
              data-fill={selectedDates.length < 1 ? 'false' : 'true'}
              onClick={openDateModal}
            >
              <div className="icon">📅</div>
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
                        <li key={i}>{d}</li>
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
            >
              <div className="sub-embarque d-flex">
                <div className="icon">🚏</div>
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
                    <span>{horario ? horario : '--:--'}</span>

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
          />

          <button
            id="reservasContinuar"
            ref={botaoContinuarRef}
            className="single_add_to_cart_button"
            // disabled={!(passengers.length > 0 && termsChecked)}
            onClick={submitToCart}
          >
            Continuar
          </button>

          {/* Modal de embarque */}
          {embarqueModalOpen && (
            <EmbarqueModal
              setEmbarqueModalOpen={setEmbarqueModalOpen}
              toggleEmbarque={toggleEmbarque}
              embarques={embarques}
              embarque={embarque}
              setEmbarque={setEmbarque}
              selectedDates={selectedDates}
              variacoes={variacoes}
              getVarIdByDate={getVarIdByDate}
              setHorario={setHorario}
              variacoesSelecionadas={variacoesSelecionadas}
              setPrecoUnitario={setPrecoUnitario}
              setTaxa={setTaxa}
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
            />
          )}

          {/* Modal de passageiro */}
          {paxModalOpen != false && (
            <PaxModal
              setPaxModalOpen={setPaxModalOpen}
              paxModalOpen={paxModalOpen}
              selectedDates={selectedDates}
              setPassageiros={setPassageiros}
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
        </div>

        {/* BARREIRA */}

        {embarques && variacoes.length > 1 && (
          <>
            <div className="datas mb-2">
              <p className="label mb-0">Datas teste</p>
              <div className="datas-badges-wrapper">
                {variacoes.map((variacao, i) => {
                  let v_dia = variacao.attributes.attribute_dia;
                  let v_disponiveis = variacao.availability_html
                    .slice(29)
                    .replace('</p>', '');
                  let badgeClasses = ' ';
                  if (variacao.encerrar_vendas) {
                    badgeClasses += 'badge-venda-encerrada ';
                  } else {
                    if (v_disponiveis > 0 && v_disponiveis <= 10) {
                      badgeClasses += 'yellow ';
                    } else if (v_disponiveis === '' || v_disponiveis == 0) {
                      badgeClasses += 'red ';
                    }
                  }
                  return (
                    <span
                      key={v_dia}
                      className={'badge-dia disp' + badgeClasses}
                      onClick={({ target }) => {
                        document
                          .querySelectorAll('.badge-dia')
                          .forEach((b) => b.classList.remove('active'));
                        target.classList.add('active');

                        setVariacaoAtual(variacoes[i]);
                      }}
                    >
                      {v_dia.slice(0, -5)}
                    </span>
                  );
                })}
              </div>
            </div>
          </>
        )}

        {embarques && variacaoAtual ? (
          <>
            <div id="info-container" className="pt-1">
              <div
                key={variacaoAtual.variation_id}
                className="variacao-info"
                data-dia={variacaoAtual.attributes.attribute_dia}
                data-variacao-id={variacaoAtual.variation_id}
              >
                {/* Alerta de vagas */}
                {!variacaoAtual.encerrar_vendas &&
                vagasVar != 0 &&
                vagasVar < 10 ? (
                  <p className={'alerta-vagas ultimos mb-2'}>
                    Restam {vagasVar} vagas
                  </p>
                ) : null}
                {!variacaoAtual.encerrar_vendas && !vagasVar ? (
                  <p className={'alerta-vagas esgotado'}>Vagas esgotadas</p>
                ) : null}

                {variacaoAtual.attributes.attribute_dia.startsWith('volta') ? (
                  <>
                    <span className="so-volta-header">
                      Apenas volta para{' '}
                      {variacaoAtual.attributes.attribute_dia.split(' - ')[1]}-
                      desembarque nos mesmos locais de embarque
                    </span>
                  </>
                ) : (
                  <>
                    <small className="dia-selecionado d-block mb-3">
                      <p className="mb-sm-1 mb-0 d-inline">
                        Dia selecionado:&nbsp;
                      </p>
                      <p className="d-inline">
                        {variacaoAtual.attributes.attribute_dia}
                      </p>
                    </small>
                  </>
                )}

                {variacaoAtual.encerrar_vendas ? (
                  <div className="vendas_encerradas_container">
                    <p>Vendas encerradas para essa excursão.</p>
                  </div>
                ) : (
                  <div className="vendas_ativas_container">
                    {variacaoAtual.attributes.attribute_dia.startsWith(
                      'volta',
                    ) ? (
                      <p>Reserva válida apenas para volta do evento!</p>
                    ) : (
                      <>
                        {' '}
                        <div className="modulo_locais_embarque">
                          <p className="label mt-2 mb-0">Locais de embarque</p>
                          {embarques.length > 0 ? (
                            <select
                              defaultValue="none"
                              id={
                                'embarque_' +
                                variacaoAtual.attributes.attribute_dia
                              }
                              className="embarque-select"
                              data-variacao-id={variacaoAtual.variation_id}
                              key={variacaoAtual.variation_id}
                              onChange={handleSelectEmbarque}
                            >
                              <option value="none" disabled>
                                Selecione...
                              </option>
                              {embarques.map((embarque) => {
                                let diaDaVar =
                                  variacaoAtual.attributes.attribute_dia;
                                let disponibilidadesDoEmbarque =
                                  embarque.horarios.map((_horarioObj) => {
                                    let todosHorariosDoEmbarque = [];
                                    _horarioObj.disponibilidade.forEach(
                                      (_dispObj) => {
                                        if (
                                          _dispObj.disp_dia ==
                                          variacaoAtual.attributes.attribute_dia
                                        )
                                          todosHorariosDoEmbarque.push({
                                            disp_dia: diaDaVar,
                                            status: _dispObj.status,
                                            horario: _horarioObj.horario,
                                          });
                                      },
                                    );
                                    return todosHorariosDoEmbarque;
                                  });
                                // console.log(disponibilidadesDoEmbarque);
                                let todosIndisponiveis;
                                if (disponibilidadesDoEmbarque.length > 1) {
                                  todosIndisponiveis =
                                    disponibilidadesDoEmbarque.every(
                                      (_horario) =>
                                        _horario[0] &&
                                        _horario[0].status === 'indisponivel',
                                    );
                                } else {
                                  todosIndisponiveis =
                                    disponibilidadesDoEmbarque.every(
                                      (_horario, _i) =>
                                        _horario[_i] &&
                                        _horario[_i].status === 'indisponivel',
                                    );
                                }

                                return todosIndisponiveis === false ? (
                                  <>
                                    (
                                    <option
                                      value={embarque.nome}
                                      data-id={embarque.embarqueId}
                                      key={embarque.embarqueId}
                                      data-horarios={JSON.stringify(
                                        disponibilidadesDoEmbarque,
                                      )}
                                    >
                                      {embarque.nome}
                                    </option>
                                    )
                                  </>
                                ) : (
                                  <>
                                    (
                                    <option
                                      disabled
                                      value=""
                                      key={embarque.embarqueId}
                                      data-horarios={[]}
                                    >
                                      {embarque.nome} (indisponivel)
                                    </option>
                                    )
                                  </>
                                );
                              })}
                            </select>
                          ) : (
                            <i>Locais de embarque não definidos</i>
                          )}
                        </div>
                        <div className="module_horarios_embarque">
                          <p className="label mt-3 my-1">Horários</p>
                          <div
                            className={
                              embarque
                                ? 'horarios-wrapper show-alert'
                                : 'horarios-wrapper'
                            }
                          >
                            {horariosEmbarque ? (
                              horariosEmbarque.map((horario) => {
                                return horario[0].status !== 'indisponivel' ? (
                                  <>
                                    <span
                                      key={horario[0].horario}
                                      className="emb_horario"
                                      data-variacao-id={
                                        variacaoAtual.variation_id
                                      }
                                      onClick={handleClickHorario}
                                    >
                                      {horario[0].horario}
                                    </span>
                                  </>
                                ) : null;
                              })
                            ) : (
                              <i>Selecione o local de embarque primeiro</i>
                            )}
                          </div>
                        </div>
                      </>
                    )}

                    {/* PREÇO DA RESERVA */}
                    <div className="modulo_preco mb-3">
                      <p className="label mt-sm-4 mt-3 mb-0">Valor</p>
                      {preco ? (
                        <>
                          <p className="info">R$ {preco},00</p>
                          <span>por passageiro</span>
                        </>
                      ) : (
                        <i>Selecione o local de embarque primeiro</i>
                      )}
                    </div>

                    <Passageiros
                      passageiros={passageiros}
                      setPassageiros={setPassageiros}
                      botaoContinuar={botaoContinuar}
                      embarque={embarque}
                      horario={horario}
                      variacao={variacaoAtual}
                      pID={productId}
                      setLoading={setLoading}
                      loading={loading}
                      taxa={taxa}
                    />

                    {variacaoAtual.max_qty !== '' &&
                    variacaoAtual.max_qty >= 1 ? (
                      <button
                        className="btn btn-dark mt-sm-4 mt-2 btn-lg btn-reservar"
                        onClick={handlePassageirosContainer}
                      >
                        Reservar lugar
                      </button>
                    ) : null}
                  </div>
                )}
              </div>
            </div>
          </>
        ) : null}

        {embarques && variacoes.length > 1 && !variacaoAtual ? (
          <div id="info-placeholder" className="my-5">
            <p>
              {variacoes.length > 1
                ? 'Selecione uma das opções acima para ver mais detalhes'
                : 'Aguarde...'}
            </p>
          </div>
        ) : null}

        {!embarques && !variacaoAtual ? (
          <p className="mt-5">Mais informações sobre essa excursão em breve!</p>
        ) : null}
      </>
    </>
  );
}

AppReservas.propTypes = {
  variacoes: PropTypes.array.isRequired,
  embarques: PropTypes.array.isRequired,
  nome: PropTypes.string,
  productId: PropTypes.number.isRequired,
};

const reservas_app_root = document.getElementById('reserva_app');
addEventListener('DOMContentLoaded', () => {
  if (reservas_app_root) {
    ReactDOM.createRoot(reservas_app_root).render(
      <AppReservas
        variacoes={JSON.parse(reservas_app_root.dataset.variacoes)}
        embarques={JSON.parse(reservas_app_root.dataset.embarques)}
        productId={JSON.parse(reservas_app_root.dataset.productId)}
      />,
    );
  }
});

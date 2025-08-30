/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */

import Passageiros from './Passageiros.jsx';
import PropTypes from 'prop-types';

function AppReservas({ variacoes, embarques, productId }) {
  const [variacaoAtual, setVariacaoAtual] = React.useState(null);
  const [embarque, setEmbarque] = React.useState(null);
  const [taxa, setTaxa] = React.useState(0);
  const [horariosEmbarque, setHorariosEmbarque] = React.useState(null);
  const [horario, setHorario] = React.useState(null);
  const [passageiros, setPassageiros] = React.useState([]);
  const [botaoContinuar, setBotaoContinuar] = React.useState(false);
  const [loading, setLoading] = React.useState(false);
  const [preco, setPreco] = React.useState(false);
  const [precoPadrao, setPrecoPadrao] = React.useState(false);
  const [vagasVar, setVagasVar] = React.useState(null);
  const [passoReserva, setPassoReserva] = React.useState(0);

  React.useEffect(() => {
    //Se houver uma única variação, define como variacaoAtual
    if (variacoes.length === 1 && embarques) setVariacaoAtual(variacoes[0]);
  }, []);

  React.useEffect(() => {
    setHorario(null);
    if (!embarque) setPreco(false);
    else setPreco(precoPadrao + taxa);
  }, [embarque, variacaoAtual]);

  React.useEffect(() => {
    if (variacaoAtual) setPrecoPadrao(+variacaoAtual.display_regular_price);
    setPreco(false);
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

  React.useEffect(() => {
    console.log('Passo da reserva:', passoReserva);

    if (passoReserva === 1) {
      const iniciarReservaBtn = document.querySelector('#iniciarReservaBtn');
      iniciarReservaBtn.classList.add('step-title');
      setTimeout(() => {
        iniciarReservaBtn.textContent = 'Passo 1: Selecione a data';
      }, 200);
    }
  }, [passoReserva]);

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
          <span id="iniciarReservaBtn" onClick={() => setPassoReserva(1)}>
            Clique para iniciar sua reserva
          </span>
          <div className="newDatasLista">
            <p>Selecione a data</p>
          </div>
        </div>

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

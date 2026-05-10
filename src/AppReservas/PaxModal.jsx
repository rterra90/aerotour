/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */
import PropTypes from 'prop-types';
import CustomSelectPaxModal from './CustomSelectPaxModal.jsx';
import useValidations from '../Hooks/useValidations';
import { cpfMask, celularMask, formatarDataISO, isDataISO, nomeValido, dataMask } from '../AppReservas/InputMasks';

const PaxModal = ({
  setPaxModalOpen,
  paxModalOpen,
  selectedDates,
  convertDate,
  setPassageiros,
  passageiros,
  variacoesSelecionadas,
  embarqueId
}) => {
  const [formMode, setFormMode] = React.useState('');
  const [formData, setFormData] = React.useState({
    nome_completo: '',
    role: '',
    cpf: '',
    celular: '',
    data_nascimento: '',
    tripType: 'ida-e-volta',
  });
  const [paxMenor, setPaxMenor] = React.useState(false);
  const [formErrors, setFormErrors] = React.useState([]);
  const { validarCPF, validarMaioridade } = useValidations();
  const [visible, setVisible] = React.useState(false);
  const [useAccountData, setUseAccountData] = React.useState(false);

  // Dados do usuário logado
  const { userData } = window.singleProductData;

  // ID de sessão para referenciar leads
  const currentSessionId = window.singleProductData?.session_id || 'anon_lead';


  // Lógica para verificar se o checkbox deve aparecer
  // 1. Usuário precisa estar logado (userData existe)
  // 2. O CPF do usuário logado não pode estar na lista de passageiros já adicionados
  const canShowAutofill = React.useMemo(() => {
    if (!userData || !userData.cpf) return false;
    return !passageiros.some(pax => pax.cpf === cpfMask(userData.cpf));
    // return true;

  }, [userData, passageiros]);

// Função para preencher os dados quando o checkbox é marcado
  function handleAutofillChange(e) {
    const checked = e.target.checked;
    setUseAccountData(checked);

    if (checked && userData) {
      setFormData(prev => ({
        ...prev,
        nome_completo: userData.nome_completo || '',
        cpf: cpfMask(userData.cpf) || '',
        celular: celularMask(userData.celular) || '',
        data_nascimento: userData.data_nascimento || '',
      }));

      setFormErrors(() => {
        const errors = [];
        if(!userData.nome_completo || !nomeValido(userData.nome_completo)) errors.push('nome_completo');
        if(!userData.cpf || !validarCPF(cpfMask(userData.cpf))) errors.push('cpf');
        if(!userData.celular || celularMask(userData.celular).length < 14) errors.push('celular')
        if(!userData.data_nascimento || !isDataISO(formatarDataISO(userData.data_nascimento))) errors.push('data_nascimento')

          return errors;
      })

    } else {
      // Opcional: Limpar se desmarcar (ou manter o que foi preenchido)
      setFormData(prev => ({
        ...prev,
        nome_completo: '',
        cpf: '',
        celular: '',
        data_nascimento: '',
      }));
        setFormErrors(['nome_completo', 'cpf', 'celular', 'data_nascimento']);

    }
  }


  

  function closePaxModal() {
    setVisible(false);
    setTimeout(() => {
      setPaxModalOpen(false);
    }, 300);
  }

  function inputChange({ target }) {
    const valueLength = target.value.length;
    switch (target.name) {
      case 'cpf': {
        if (cpfMask(target.value).length == 14) {
          const cpfValido = validarCPF(cpfMask(target.value));
          target.classList.remove('input-attention');
          if (cpfValido) target.classList.remove('input-error');
          else target.classList.add('input-error');
          atualizarErros(target.name, !cpfValido);
        } else if (valueLength < 14) {
          target.classList.remove('input-error');
          atualizarErros(target.name, true);
        }
        setFormData({ ...formData, cpf: cpfMask(target.value) });
        break;
      }
      case 'celular': {
        const celValido =
          celularMask(target.value).length == 14 ||
          celularMask(target.value).length == 15;
        target.classList.remove('input-error');
        if (celValido) target.classList.remove('input-attention');
        else if (valueLength < 14) target.classList.remove('input-error');
        atualizarErros(target.name, !celValido);
        setFormData({ ...formData, celular: celularMask(target.value) });
        break;
      }
      case 'data_nascimento': {
        const dataFormatadaDMY = applyMask(target.value, 'data');
        atualizarErros(target.name, dataFormatadaDMY.length !== 10);
        setFormData({ ...formData, data_nascimento: dataFormatadaDMY });
        break;
      }

      default:
        break;
    }
  }

  function inputBlur({ target }) {
    let valueLength = target.value.length;
    switch (target.name) {
      case 'cpf': {
        const cpfIncompleto = valueLength < 14 && valueLength > 0;
        const cpfEmpty = valueLength == 0;
        if (cpfIncompleto) target.classList.add('input-attention');
        else if (valueLength == 14 || cpfEmpty)
          if (target.classList.contains('input-attention')) {
            target.classList.remove('input-attention');
          }

        break;
      }
      case 'nome_completo': {
        const valor = target.value.trim();
        const palavras = valor.split(/\s+/);
        const isEmpty = valor.length === 0;
        const isInvalido = !isEmpty && palavras.length < 2;
        target.classList.toggle('input-error', isInvalido);
        atualizarErros(target.name, isEmpty || isInvalido);
        break;
      }
      case 'celular': {
        if (valueLength < 14 && valueLength > 0) {
          target.classList.add('input-attention');
        } else {
          target.classList.remove('input-attention');
        }
        break;
      }
      case 'data_nascimento': {
        if (target.value !== '') {
          if (
            selectedDates.some(
              (_eventDate) =>
                validarMaioridade(
                  target.value,
                  convertDate(_eventDate, 'ISO'),
                ) == false,
            )
          ) {
            setPaxMenor(true);
          } else setPaxMenor(false);
        }

        break;
      }
      default:
        break;
    }
  }

  function atualizarErros(campo, key) {
    //key: true insere o erro; false remove o erro
    setFormErrors((errosAtuais) => {
      if (key) {
        return errosAtuais.includes(campo)
          ? errosAtuais
          : [...errosAtuais, campo];
      } else {
        return errosAtuais.filter((erro) => erro !== campo);
      }
    });
  }

  // Função auxiliar para enviar os dados do pax para leads_reservas
  const syncLeadWithServer = async (paxData) => {
    try {
      const rootUrl = window.themeLinks.siteUrl;
      const response = await fetch(`${rootUrl}/wp-json/aerotour/v1/save-lead`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          ...paxData,
          variation_id: variacoesSelecionadas, // ID da excursão atual
          embarque: embarqueId, // Ponto de embarque selecionado
          session_id: currentSessionId, // Um ID único para esta navegação
        }),
      });

      const data = await response.json();
      console.log(data)

    } catch (error) {
      console.error('Erro ao salvar lead:', error);
    }
  };

  function savePax(_mode) {
    if (formErrors.length === 0) {
      if (_mode == 'add') {
        setPassageiros((_current) => {
          //verifica se já existe um passageiro com o mesmo CPF
          const paxJaExiste = _current.some(
            (_pax) => _pax.cpf === formData.cpf && formData.cpf !== '',
          );
          if (paxJaExiste) {
            alert('Já existe um passageiro com este CPF.');
            return _current;
          }  

          // CHAMADA ASSÍNCRONA PARA O LEAD
          syncLeadWithServer(formData);

          setPaxModalOpen(false);
          return [..._current, { ...formData, data_nascimento: formatarDataISO(formData.data_nascimento) }];

        });
      } else if (_mode == 'edit') {
        const _index = paxModalOpen[3];
        //atualiza o passageiro que tem o mesmo index
        setPassageiros((_current) => {
          //verifica se já existe um passageiro com o mesmo CPF, excluindo ele mesmo
          const cpfJaExiste = _current.some(
            (_pax, _i) =>
              _pax.cpf === formData.cpf && formData.cpf !== '' && _i != _index,
          );
          if (cpfJaExiste) {
            alert('Já existe um passageiro com este CPF.');
            return _current;
          } else {
            setPaxModalOpen(false);
            return _current.map((_pax, _i) => {
              const _dn = isDataISO(formData.data_nascimento) ? formData.data_nascimento : formatarDataISO(formData.data_nascimento)
              if (_i === _index) return {...formData, data_nascimento: _dn};
              else return _pax;
            });
          }
        });
      }
    }
  }

  //Define o tipo de formulário ('add' ou 'edit')
  React.useEffect(() => {
    if (paxModalOpen[0] == true) {
      setVisible(true);
      let _mode = paxModalOpen[1];
      setFormMode(_mode);

      if (_mode === 'add') {
        setFormErrors(['nome_completo', 'cpf', 'celular', 'data_nascimento']);
      } else if (_mode === 'edit') {
        const currentPaxData = paxModalOpen[2];
        setFormData(currentPaxData);
      }
    }
  }, [paxModalOpen]);

  return (
    <div
      className={`modal-overlay ${visible ? 'show' : ''}`}
      onClick={closePaxModal}
    >
      <div
        className={`modal-content ${visible ? 'show' : 'hide'}`}
        onClick={(e) => e.stopPropagation()}
      >
        <button className="modal-close" onClick={closePaxModal}>
          ✖
        </button>

        <h3>{formMode === 'edit' ? 'Editar ' : 'Adicionar '} passageiro</h3>

        <form
          id="paxForm"
          onSubmit={(e) => {
            e.preventDefault();
            savePax(formMode);
          }}
        >


{/* CHECKBOX MODERNO DE AUTO-PREENCHIMENTO */}
          {canShowAutofill && (
            <div className="autofill-container mt-2">
              <label className="modern-checkbox-label">
                <input 
                  type="checkbox" 
                  checked={useAccountData} 
                  onChange={handleAutofillChange} 
                />
                <span className="checkbox-custom"></span>
                <span className="label-text">Usar meus dados de cadastro</span>
              </label>
            </div>
          )}


          <label>
            Nome:
            <input
              type="text"
              name="nome_completo"
              value={formData.nome_completo}
              onChange={(e) =>
                setFormData({ ...formData, nome_completo: e.target.value })
              }
              onBlur={inputBlur}
            />
          </label>
          <label>
            CPF:
            <input
              type="text"
              name="cpf"
              maxLength="14"
              value={formData.cpf}
              onBlur={inputBlur}
              onChange={inputChange}
            />
          </label>
          <label>
            Celular (WhatsApp):
            <input
              maxLength="15"
              type="text"
              name="celular"
              value={formData.celular}
              onBlur={inputBlur}
              onChange={inputChange}
            />
          </label>
          <label>
            Data de nascimento:
            <input
              type="text"
              name="data_nascimento"
              maxLength="10"
              value={isDataISO(formData.data_nascimento) ? dataMask(formData.data_nascimento) : formData.data_nascimento}
              onChange={inputChange}
              onBlur={inputBlur}
            />
          </label>

          {/* {paxMenor && (
            <div className="aviso-menor" id="aviso-menor">
              <a
                href="modelo-autorizacao.pdf"
                download
                className="icone-download"
                aria-label="Baixar modelo de autorização"
              >
                📄
              </a>
              <span className="texto-aviso">
                Passageiro menor de idade. Clique para baixar o modelo de
                autorização.
              </span>
            </div>
          )} */}

          <div className="modal-buttons">
            <CustomSelectPaxModal
              setFormData={setFormData}
              tripType={formData.tripType}
            />
            {formErrors.length > 0 ? (
              <button type="submit" className="saveBtn" disabled>
                Salvar
              </button>
            ) : (
              <button type="submit" className="saveBtn">
                Salvar
              </button>
            )}
          </div>
        </form>
      </div>
    </div>
  );
};

PaxModal.propTypes = {
  setPaxModalOpen: PropTypes.func.isRequired,
  setPassageiros: PropTypes.func.isRequired,
  paxModalOpen: PropTypes.array.isRequired,
  selectedDates: PropTypes.array.isRequired,
  passageiros: PropTypes.array.isRequired,
  convertDate: PropTypes.func.isRequired,
  variacoesSelecionadas: PropTypes.array.isRequired,
  embarqueId: PropTypes.number,
};

export default PaxModal;

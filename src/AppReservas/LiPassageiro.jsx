/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */

import { cpfMask, celularRaw, celularMask } from './InputMasks';
import useInput from '../Hooks/useInput';
import useValidations from '../Hooks/useValidations';
import PropTypes from 'prop-types';

const LiPassageiro = ({
  passageiro,
  index,
  removePassageiro,
  setPassageiros,
  passageiros,
}) => {
  const [done, setDone] = React.useState(false);
  const nomeInput = useInput(setPassageiros, index, setDone, done);
  const telInput = useInput(setPassageiros, index, setDone, done);
  const docInput = useInput(setPassageiros, index, setDone, done);
  const { validarCPF } = useValidations();

  const inputsContainer = React.useRef();

  React.useEffect(() => {
    setTimeout(() => {
      inputsContainer.current &&
        inputsContainer.current.parentElement.classList.add('animate-in');
    }, 100);
  }, []);

  React.useEffect(() => {
    [nomeInput, telInput, docInput].forEach((inp) => {});
  }, [passageiros]);

  //Preenche os dados do usuário no primeiro passageiro se o estiver logado
  React.useEffect(() => {
    if (index === 0) {
      const currentUser = JSON.parse(window.sessionStorage.getItem('aer_user'));
      if (currentUser) {
        nomeInput.setValue(currentUser.nome_completo);
        docInput.setValue(cpfMask(currentUser.doc));
        telInput.setValue(celularMask(celularRaw(currentUser.telefone)));

        setPassageiros((_passageiros) => {
          let passageiros_a = _passageiros;
          passageiros_a[0].nome_completo = currentUser.nome_completo;
          passageiros_a[0].doc = currentUser.doc;
          passageiros_a[0].telefone = celularMask(currentUser.telefone);

          // Valida os campos do passageiro para ativar setDone
          const pAtual = passageiros_a[0];
          const validacaoPassageiro = Object.keys(pAtual).every((key) => {
            if (key === 'doc') return validarCPF(cpfMask(pAtual[key]));
            else if (key === 'telefone') return pAtual[key].length >= 14;
            else return pAtual[key].length > 2;
          });
          if (validacaoPassageiro) setDone(true);
          console.log(passageiros_a);
          return passageiros_a;
        });

        inputsContainer.current.querySelectorAll('input').forEach((input) => {
          if (
            input.dataset.campo === 'nome_completo' ||
            input.dataset.campo === 'doc'
          ) {
            // input.setAttribute('disabled', '');
            input.classList.add('border-fill');
          }
        });
      }
    }
  }, []);

  return (
    <li className="passageiro-li" data-index={index}>
      <div className="user-icon">
        <i>
          <svg
            xmlns="http://www.w3.org/2000/svg"
            width="40"
            height="40"
            fill="currentColor"
            className="bi bi-person"
            viewBox="0 0 16 16"
          >
            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
          </svg>
        </i>
      </div>
      <div
        className="dados-passageiro"
        ref={inputsContainer}
        data-index={'Dados do(a) passageiro(a)'}
      >
        <input
          className="nome_completo"
          type="text"
          data-campo="nome_completo"
          data-index={index}
          value={nomeInput.value}
          placeholder="Nome completo"
          onChange={(e) => nomeInput.onChange(e)}
          onBlur={({ target }) => nomeInput.validate('nome_completo', target)}
        />
        <div className="d-flex gap-2">
          <label>
            <i>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="14"
                fill="currentColor"
                className="bi bi-person-badge"
                viewBox="0 0 16 16"
              >
                <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" />
              </svg>
            </i>
            <input
              className="doc"
              type="text"
              value={docInput.value}
              placeholder="CPF"
              data-campo="doc"
              maxLength="14"
              data-index={index}
              onChange={(e) => docInput.onChange(e)}
              onBlur={({ target }) => docInput.validate('doc', target)}
            />
          </label>
          <label>
            <i>
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="15"
                height="14"
                fill="currentColor"
                className="bi bi-phone-fill"
                viewBox="0 0 16 16"
              >
                <path d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0" />
              </svg>
            </i>
            <input
              className={
                index === 0 &&
                telInput.value.length > 0 &&
                telInput.value.length < 14
                  ? 'telefone error'
                  : telInput.value.length === 0
                  ? 'telefone'
                  : 'telefone border-fill'
              }
              type="text"
              value={telInput.value}
              placeholder="Celular"
              maxLength="15"
              data-campo="telefone"
              data-index={index}
              onChange={(e) => telInput.onChange(e)}
              onBlur={({ target }) => telInput.validate('telefone', target)}
            />
          </label>
        </div>
      </div>
      <div className="icones-passageiro">
        {index !== 0 && (
          <i data-index={index} onClick={removePassageiro}>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="16"
              height="16"
              fill="currentColor"
              className="bi bi-trash"
              viewBox="0 0 16 16"
            >
              <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
              <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
            </svg>
          </i>
        )}
      </div>
    </li>
  );
};

LiPassageiro.propTypes = {
  passageiro: PropTypes.object.isRequired,
  index: PropTypes.number.isRequired,
  removePassageiro: PropTypes.func,
  setPassageiros: PropTypes.func,
  passageiros: PropTypes.array.isRequired,
};

export default LiPassageiro;

/* eslint-disable no-unexpected-multiline */
/* eslint-disable react/react-in-jsx-scope */
/* eslint-disable no-undef */

import LiPassageiro from './LiPassageiro.jsx';
import useValidations from '../Hooks/useValidations';
import { cpfMask } from './InputMasks';
import PropTypes from 'prop-types';

const Passageiros = ({
  passageiros,
  setPassageiros,
  botaoContinuar,
  embarque,
  horario,
  variacao,
  pID,
  setLoading,
  loading,
  taxa,
}) => {
  const moduloPassageiros = React.useRef();
  const addToCartForm = React.useRef();
  const passageirosHidden = React.useRef();
  const { validarCPF } = useValidations();
  const [submitError, setSubmitError] = React.useState(false);

  function handleSubmit(event) {
    event.preventDefault();
    if (!loading) {
      setLoading(true);

      passageirosHidden.current.setAttribute(
        'value',
        JSON.stringify(passageiros),
      );

      //FAZER VERIFICAÇÕES ANTES DE SUBMETER
      setSubmitError(false);
      const validacoes = [];

      passageiros.forEach((pAtual) => {
        if (pAtual) {
          const validacaoPassageiro = Object.keys(pAtual).every((key) => {
            if (key === 'doc') return validarCPF(cpfMask(pAtual[key]));
            else if (key === 'telefone') return pAtual[key].length >= 14;
            else return pAtual[key].length > 2;
          });
          validacoes.push(validacaoPassageiro);
        }
      });

      const todosDocs = [];
      let docRepetido = false;
      passageiros.forEach((pAtual) => {
        if (pAtual) {
          if (!todosDocs.includes(pAtual.doc)) todosDocs.push(pAtual.doc);
          else docRepetido = true;
        }
      });

      if (validacoes.some((val) => val === false)) {
        validacoes.forEach((val, i) => {
          if (!val) {
            moduloPassageiros.current
              .querySelectorAll('ul li.passageiro-li')
              [i].classList.add('error-animate');
          }
          setTimeout(() => {
            moduloPassageiros.current
              .querySelectorAll('ul li.passageiro-li')
              [i].classList.remove('error-animate');
          }, 3200);
        });
        setSubmitError('Por favor, verifique os dados informados');
        setLoading(false);
      } else if (docRepetido) {
        setSubmitError('Informe o CPF corretamente para cada passageiro');
        setLoading(false);
      } else if (embarque === null) {
        setSubmitError('Selecione o local de embarque');
        setLoading(false);
      } else if (horario === null) {
        setSubmitError('Selecione um horário');
        setLoading(false);
      } else {
        setPassageiros([...passageiros]);
        //SUBMETE APÓS VERIFICAÇÕES
        event.target.setAttribute('method', 'post');
        event.target.setAttribute('action', '');
        event.target.submit();
      }
    }
  }

  function addPassageiro() {
    if (passageiros.filter((p) => p || false).length < variacao.max_qty) {
      setPassageiros([
        ...passageiros,
        { nome_completo: '', doc: '', telefone: '' },
      ]);
    }
  }

  function removePassageiro({ currentTarget }) {
    const passageiros_a = passageiros.map((p, i) => {
      return i !== +currentTarget.dataset.index ? p : false;
    });
    const targetLi = currentTarget.parentElement.parentElement;
    targetLi.classList.remove('animate-in');
    setTimeout(() => {
      setPassageiros(passageiros_a);
    }, 500);
  }

  return (
    <div id="modulo_passageiros" className="d-none" ref={moduloPassageiros}>
      <p>Passageiros</p>
      <ul>
        {passageiros.map((passageiro, i) => {
          if (passageiro) {
            return (
              <LiPassageiro
                passageiro={passageiro}
                index={i}
                key={i}
                removePassageiro={removePassageiro}
                setPassageiros={setPassageiros}
                passageiros={passageiros}
              />
            );
          }
        })}
        {passageiros.filter((p) => p || false).length < variacao.max_qty ? (
          <li className="add_passageiro_btn" onClick={addPassageiro}>
            Adicionar passageiro
          </li>
        ) : null}
      </ul>
      <form
        className="variations_form cart"
        onSubmit={handleSubmit}
        encType="multipart/form-data"
        data-product-id={pID}
        ref={addToCartForm}
      >
        <input type="hidden" name="add-to-cart" value={pID} />
        <input
          id="reservaQty"
          type="number"
          className="input-text qty text d-none"
          name="quantity"
          value={passageiros.filter((p) => p || false).length}
          min="1"
          inputMode="numeric"
          readOnly
        />

        <input type="hidden" name="taxa" value={taxa || ''} />
        <input type="hidden" name="embarque" value={embarque || ''} />
        <input type="hidden" name="horario" value={horario || ''} />
        <input type="hidden" name="passageiros" ref={passageirosHidden} />
        <input
          type="hidden"
          name="variation_id"
          value={variacao.variation_id || ''}
        />
        {botaoContinuar && (
          <input
            type="submit"
            value={loading ? 'Aguarde...' : 'Continuar'}
            className="single_add_to_cart_button button alt"
            disabled
            // onClick={handleSubmit}
          />
        )}
        {submitError ? (
          <p className="passageiros-error-alert">{submitError}</p>
        ) : null}
      </form>
    </div>
  );
};

Passageiros.propTypes = {
  passageiros: PropTypes.array.isRequired,
  setPassageiros: PropTypes.func.isRequired,
  botaoContinuar: PropTypes.bool,
  embarque: PropTypes.string,
  horario: PropTypes.string,
  variacao: PropTypes.object.isRequired,
  pID: PropTypes.number.isRequired,
  setLoading: PropTypes.func,
  loading: PropTypes.bool,
  taxa: PropTypes.number,
};

export default Passageiros;

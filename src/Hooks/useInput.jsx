import {
  cpfMask,
  cpfRaw,
  celularMask,
  celularRaw,
} from '../AppReservas/InputMasks';

const useInput = (setPassageiros, index, setDone, done) => {
  const [error, setError] = React.useState(false);
  const [value, setValue] = React.useState('');
  const [jaErrou, setJaErrou] = React.useState(false);

  function validaPassageiro(pAtual) {
    const validacaoPassageiro = Object.keys(pAtual).every((key) => {
      if (key === 'doc') return validarCPF(cpfMask(pAtual[key]));
      else if (key === 'telefone') return pAtual[key].length >= 14;
      else return pAtual[key].length > 2;
    });
    if (validacaoPassageiro) setDone(true);
    else setDone(false);
  }

  function validate(value, campo, element) {
    if (campo === 'doc') {
      if (validarCPF(value)) {
        element.classList.add('border-fill');
        element.classList.remove('error');
        setError(false);
      } else {
        element.classList.remove('border-fill');
        element.classList.add('error');
        setError(true);
      }
    } else if (campo === 'telefone') {
      if (value.length >= 14) {
        element.classList.add('border-fill');
        element.classList.remove('error');
        setError(false);
      } else {
        element.classList.remove('border-fill');
        element.classList.add('error');
        setError(true);
      }
    } else if (campo === 'nome_completo') {
      if (value.length >= 3) {
        element.classList.add('border-fill');
        element.classList.remove('error');

        // setPassageiros((_current) => {
        //   _current[index]['nome_completo'] = value;
        //   return _current;
        // });
        setError(false);
      } else {
        element.classList.remove('border-fill');
        element.classList.add('error');
        setError(true);
      }
    }

    //Atualiza o obj reativo 'passageiros'
    setPassageiros((_passageiros) => {
      let passageiros_a = _passageiros;
      passageiros_a[index][campo] = campo === 'doc' ? cpfRaw(value) : value;
      validaPassageiro(passageiros_a[index]);
      return passageiros_a;
    });
  }

  function onChange({ target }) {
    if (target.dataset.campo === 'doc') setValue(cpfMask(target.value));
    else if (target.dataset.campo === 'telefone')
      setValue(celularMask(target.value));
    else setValue(target.value);
  }

  function onBlur({ target }) {
    console.log(target);
  }

  function validarCPF(cpf) {
    var cpfRegex = /^(?:(\d{3}).(\d{3}).(\d{3})-(\d{2}))$/;
    if (!cpfRegex.test(cpf)) {
      return false;
    }

    var numeros = cpf.match(/\d/g).map(Number);
    var soma = numeros.reduce((acc, cur, idx) => {
      if (idx < 9) {
        return acc + cur * (10 - idx);
      }
      return acc;
    }, 0);

    var resto = (soma * 10) % 11;

    if (resto === 10 || resto === 11) {
      resto = 0;
    }

    if (resto !== numeros[9]) {
      return false;
    }

    soma = numeros.reduce((acc, cur, idx) => {
      if (idx < 10) {
        return acc + cur * (11 - idx);
      }
      return acc;
    }, 0);

    resto = (soma * 10) % 11;

    if (resto === 10 || resto === 11) {
      resto = 0;
    }

    if (resto !== numeros[10]) {
      return false;
    }

    return true;
  }

  React.useEffect(() => {
    if (index === 0) setDone(true);
  }, []);

  // React.useEffect(() => {
  //   const _dataset = document.querySelector('#modulo_passageiros ul').children[
  //     index
  //   ].dataset;
  //   if (done) _dataset.validate = 'true';
  //   else _dataset.validate = 'false';
  // }, [done]);

  return {
    value,
    setValue,
    onChange,
    error,
    onBlur,
    validate: (type, element) => validate(value, type, element),
  };
};

export default useInput;

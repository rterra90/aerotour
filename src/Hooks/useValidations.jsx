const useValidations = () => {
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

  function validarMaioridade(dataNascimento, dataEvento) {
    const [ano1, mes1, dia1] = dataNascimento.split('-').map(Number);
    const [ano2, mes2, dia2] = dataEvento.split('-').map(Number);

    const data1 = new Date(ano1, mes1 - 1, dia1);
    const data2 = new Date(ano2, mes2 - 1, dia2);

    // Calcula a data limite: data1 + 18 anos
    const dataLimite = new Date(data1);
    dataLimite.setFullYear(dataLimite.getFullYear() + 18);

    // Compara se data2 é igual ou posterior à dataLimite
    return data2 >= dataLimite;
  }

  return {
    validarCPF,
    validarMaioridade,
  };
};

export default useValidations;

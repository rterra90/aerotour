//Adiciona o método 'slugify' para strings
String.prototype.slugify = function (separator = '-') {
  return this.toString()
    .normalize('NFD') // split an accented letter in the base letter and the acent
    .replace(/[\u0300-\u036f]/g, '') // remove all previously split accents
    .toLowerCase()
    .trim()
    .replace(/[^a-z0-9 ]/g, '') // remove all chars not letters, numbers and spaces (to be replaced)
    .replace(/\s+/g, separator);
};

function celularMask(value) {
  if (!value) {
    return '';
  }
  value = value.replace(/\D/g, ''); // Remove tudo que não for número
  value = value.slice(0, 11); // Limita a 11 dígitos (celular BR)
  value = value.replace(/^(\d{2})(\d)/, '($1) $2'); // Aplica máscara progressiva
  value = value.replace(/(\d{5})(\d{1,4})$/, '$1-$2'); // Aplica hífen apenas quando fizer sentido

  return value;
}
function CPFMask(value) {
  value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
  // CPF
  return value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
}
function d_CPFMask(value) {
  value = value.replace(/\D/g, '').slice(0, 11);
  value = value.replace(/(\d{3})(\d)/, '$1.$2');
  value = value.replace(/(\d{3})(\d)/, '$1.$2');
  value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
  return value;
}
function CNPJMask(value) {
  value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
  // CNPJ
  return value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
}
function RNEMask(value){
  // Normaliza
  value = value.toUpperCase().replace(/[^A-Z0-9]/g, '');

  // Limite máximo seguro (2 letras + até 7 números)
  value = value.slice(0, 9);

  // 1) CRNM (2 letras)
  if (/^[A-Z]{2}/.test(value)) {
    value = value.slice(0, 9); // AB + 7 dígitos
    return value
      .replace(/^([A-Z]{2})(\d)/, '$1 $2')
      .replace(/^([A-Z]{2} \d{3})(\d)/, '$1.$2')
      .replace(/^([A-Z]{2} \d{3}\.\d{3})(\d)/, '$1-$2');
  }

  // 2) RNE (1 letra) → V1234567-8
  if (/^[A-Z]/.test(value)) {
    value = value.slice(0, 9); // 1 letra + 8 dígitos

    return value
      .replace(/^([A-Z])(\d{7})(\d)/, '$1$2-$3'); // formato final
  }

  // 3) RNE numérico
  value = value.slice(0, 9);
  return value
    .replace(/^(\d{2})(\d)/, '$1.$2')
    .replace(/^(\d{2}\.\d{3})(\d)/, '$1.$2')
    .replace(/^(\d{2}\.\d{3}\.\d{3})(\d)/, '$1-$2');
}
function dataMask(value) {
  // Normaliza
  value = value.replace(/\D/g, '').slice(0, 8);

  // DIA (01–31)
  if (value.length >= 2) {
    let dia = parseInt(value.slice(0, 2), 10);
    if (!isNaN(dia)) {
      dia = Math.min(dia, 31);
      value = dia.toString().padStart(2, '0') + value.slice(2);
    }
  }

  // MÊS (01–12)
  if (value.length >= 4) {
    let mes = parseInt(value.slice(2, 4), 10);
    if (!isNaN(mes)) {
      mes = Math.min(mes, 12);
      value =
        value.slice(0, 2) +
        mes.toString().padStart(2, '0') +
        value.slice(4);
    }
  }

  // Máscara
  value = value
    .replace(/^(\d{2})(\d)/, '$1/$2')
    .replace(/^(\d{2}\/\d{2})(\d)/, '$1/$2');

  return value.slice(0, 10);
}

function cleanMask(value) {
  return value ? value.replace(/\D/g, '') : '';
}

function applyMask(value, type) {
  switch (type) {
    case 'cpf':
      return d_CPFMask(value);
      break;

    case 'rne':
      return RNEMask(value);
      break;

    case 'phone':
      return celularMask(value)
      break;

     case 'data':
      return dataMask(value)
      break;
  }
}
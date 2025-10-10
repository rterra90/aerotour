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

function celularMask({ target }) {
  let masked = target.value;
  if (!masked) return '';
  masked = masked.replace(/\D/g, '');
  masked = masked.replace(/(\d{2})(\d)/, '($1) $2');
  masked = masked.replace(/(\d)(\d{4})$/, '$1-$2');
  target.value = masked;
}
function CPFMask(value) {
  value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
  // CPF
  return value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
}
function CNPJMask(value) {
  value = value.replace(/\D/g, ''); // Remove tudo que não for dígito
  // CNPJ
  return value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
}
function cleanMask(value) {
  return value ? value.replace(/\D/g, '') : '';
}

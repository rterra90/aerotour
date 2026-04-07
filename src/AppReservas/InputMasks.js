export const cpfMask = (value) => {
  return value
    .replace(/\D/g, '') // substitui qualquer caracter que nao seja numero por nada
    .replace(/(\d{3})(\d)/, '$1.$2') // captura 2 grupos de numero o primeiro de 3 e o segundo de 1, apos capturar o primeiro grupo ele adiciona um ponto antes do segundo grupo de numero
    .replace(/(\d{3})(\d)/, '$1.$2')
    .replace(/(\d{3})(\d{1,2})/, '$1-$2')
    .replace(/(-\d{2})\d+?$/, '$1'); // captura 2 numeros seguidos de um traço e não deixa ser digitado mais nada
};
export const cpfRaw = (value) => {
  return value.replace('-', '').replaceAll('.', '');
};
export const celularMask = (value) => {
  if (!value) return '';
  value = value.replace(/\D/g, '');
  value = value.replace(/(\d{2})(\d)/, '($1) $2');
  value = value.replace(/(\d)(\d{4})$/, '$1-$2');
  return value;
};
export const celularRaw = (value) => {
  return value
    .replace('(', '')
    .replace(')', '')
    .replace('-', '')
    .replaceAll(' ', '');
};
export const dataMask = (data) => {
  if (!data) return '';

  const [ano, mes, dia] = data.split('-');

  return `${dia}/${mes}/${ano}`;
};

export const formatarDataISO = (data) => {
  if (!data) return '';

  const [dia, mes, ano] = data.split('/');

  return `${ano}-${mes}-${dia}`;
};

export const isDataISO = (str) => /^\d{4}-\d{2}-\d{2}$/.test(str);

export const nomeValido = (str) => {
  if (!str || typeof str !== 'string') return false;

  const palavras = str
    .trim()
    .split(/\s+/)
    .filter(p => p.length > 1 || p.toLowerCase() === 'e');

  return palavras.length >= 2;
};
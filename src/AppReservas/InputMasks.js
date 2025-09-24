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
export const dataMask = (value) => {
  // Remove tudo que não seja número ou "/"
  let valor = value.replace(/[^\d\/]/g, '');

  // Remove barras extras
  valor = valor.replace(/\/+/g, '/');

  // Remove barras em posições erradas
  valor = valor.replace(/^\/|\/{2,}/g, '');

  // Remove qualquer caractere após 10 dígitos
  valor = valor.replace(/(\d{2})(\/?)(\d{2})(\/?)(\d{4}).*/, '$1/$3/$5');

  // Adiciona barras automaticamente
  if (valor.length >= 2 && valor[2] !== '/') {
    valor = valor.slice(0, 2) + '/' + valor.slice(2);
  }
  if (valor.length >= 5 && valor[5] !== '/') {
    valor = valor.slice(0, 5) + '/' + valor.slice(5);
  }

  return valor;
};

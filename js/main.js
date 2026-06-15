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

// // //
// MÁSCARAS DE INPUT
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

// Função para limpar a máscara e obter apenas os dígitos
function cleanMask(value) {
  return value ? value.replace(/\D/g, '') : '';
}
// Função para aplicar a máscara correta com base no tipo
function applyMask(value, type) {
  switch (type) {
    case 'cpf':
      return d_CPFMask(value);

    case 'rne':
      return RNEMask(value);

    case 'phone':
      return celularMask(value)

     case 'data':
      return dataMask(value)
  }
}


// // //
// VALIDAÇÕES DE INPUTS
function validarCPF(cpf) {
  cpf = cpf.replace(/\D/g, '');

  if (cpf.length !== 11) return false;

  // Bloqueia CPFs repetidos
  if (/^(\d)\1{10}$/.test(cpf)) return false;

  const numeros = cpf.split('').map(Number);

  // Primeiro dígito
  let soma = 0;
  for (let i = 0; i < 9; i++) {
    soma += numeros[i] * (10 - i);
  }

  let resto = (soma * 10) % 11;
  if (resto === 10) resto = 0;

  if (resto !== numeros[9]) return false;

  // Segundo dígito
  soma = 0;
  for (let i = 0; i < 10; i++) {
    soma += numeros[i] * (11 - i);
  }

  resto = (soma * 10) % 11;
  if (resto === 10) resto = 0;

  if (resto !== numeros[10]) return false;

  return true;
}

// Timer de pedido pendente
jQuery(document).ready(function($) {
    function startOrderCountdown() {
        var $timerContainer = $('#order-countdown-timer');
        var $clockDigits = $('#countdown-clock-digits');
        
        if (!$timerContainer.length || !$clockDigits.length) {
            return; // Se o elemento não estiver na página atual, encerra a função
        }

        // Obtém os segundos restantes passados dinamicamente pelo PHP
        var secondsLeft = parseInt($timerContainer.data('seconds-left'), 10);

        if (isNaN(secondsLeft) || secondsLeft <= 0) {
            return;
        }

        var countdownInterval = setInterval(function() {
            secondsLeft--;

            if (secondsLeft <= 0) {
                clearInterval(countdownInterval);
                $clockDigits.text("00:00");
                
                // Força o reload da página para o WooCommerce mostrar o status atualizado do pedido
                window.location.reload();
                return;
            }

            // Transforma os segundos restantes em formato amigável de MM:SS
            var minutes = Math.floor(secondsLeft / 60);
            var seconds = secondsLeft % 60;

            // Formatação com zero à esquerda (padStart alternativo para compatibilidade)
            var displayMinutes = minutes < 10 ? '0' + minutes : minutes;
            var displaySeconds = seconds < 10 ? '0' + seconds : seconds;

            $clockDigits.text(displayMinutes + ':' + displaySeconds);
            
            // Atualiza o data-attribute para manter o DOM atualizado caso necessário
            $timerContainer.data('seconds-left', secondsLeft);

            // Melhoria visual de urgência: Piscar em vermelho nos últimos 3 minutos
            if (secondsLeft <= 180) {
                $timerContainer.removeClass('alert-warning border-warning').addClass('alert-danger border-danger animate-pulse-urgency');
                $clockDigits.addClass('text-danger');
            }

        }, 1000);
    }

    // Inicializa o cronômetro
    startOrderCountdown();
});
let hide_placeholder = false;
// let dados_reserva = false;

function handle_selecao_variante_excursao(event) {
  const dia = event.currentTarget.innerText;
  const all_badges = document.querySelectorAll('.badge-dia');
  const cards_variacao = document.querySelectorAll('.variacao-info');

  if (event.currentTarget.classList.contains('badge-dia')) {
    if (!hide_placeholder) {
      hide_placeholder = true;
      document.querySelector('#info-placeholder').classList.add('d-none');
      document.querySelector('#info-container').classList.remove('d-none');
      document.querySelector('#info-container');
    }
    all_badges.forEach((b) => b.classList.remove('active'));
    event.currentTarget.classList.add('active');

    /* Alterna container de info */
    cards_variacao.forEach((card) => {
      if (card.dataset.dia.substring(0, 5) === dia) {
        card.classList.remove('d-none');
        const embarqueHidden = card.querySelector('input.embarque-hidden');
        embarqueHidden && embarqueHidden.setAttribute('name', 'embarque');
      } else {
        card.classList.add('d-none');
        const embarqueHidden = card.querySelector('input.embarque-hidden');
        embarqueHidden && embarqueHidden.setAttribute('name', '');
      }
    });
  }
}

function handle_ativacao_botao_pagamento(variant_id) {
  const reserva_inputs = document.querySelectorAll(
    `[data-variacao-id="${variant_id}"] .reserva-input`,
  );
  const reserva_inputs_array = Array.prototype.slice.call(reserva_inputs);
  const pagamento_btn = document.querySelector(
    `[data-variacao-id="${variant_id}"] .single_add_to_cart_button`,
  );
  const embarqueSelect = document.querySelector(
    `select[data-variacao-id="${variant_id}"]`,
  );

  if (
    reserva_inputs_array.every((input) => input.value !== '') &&
    embarqueSelect.value !== ''
  ) {
    pagamento_btn.hasAttribute('disabled') &&
      pagamento_btn.removeAttribute('disabled');
  } else pagamento_btn.setAttribute('disabled', '');
}

function handle_reservar_excursao(event) {
  const variant_id = event.target.dataset.variacaoId;
  const reservar_btn = event.currentTarget;
  const box_dados = document.querySelector(
    `[data-variacao-id="${variant_id}"]#reserva-dados-passageiro`,
  );
  box_dados.classList.toggle('d-none');
  event.currentTarget.classList.toggle('active');

  const reserva_inputs = document.querySelectorAll(
    `[data-variacao-id="${variant_id}"] .reserva-input`,
  );
  if (reservar_btn.classList.contains('active')) {
    reserva_inputs.forEach((input) =>
      input.addEventListener('keyup', () =>
        handle_ativacao_botao_pagamento(variant_id),
      ),
    );
    reservar_btn.innerText = 'Cancelar';
  } else {
    reserva_inputs.forEach((input) =>
      input.removeEventListener('keyup', () =>
        handle_ativacao_botao_pagamento(variant_id),
      ),
    );
    reservar_btn.innerText = 'Reservar lugar';
  }

  handle_ativacao_botao_pagamento(variant_id);
}

document
  .querySelectorAll('.datas .badge-dia')
  .forEach((bdg) =>
    bdg.addEventListener('click', handle_selecao_variante_excursao),
  );

document
  .querySelectorAll('.btn-reservar')
  .forEach((btn) => btn.addEventListener('click', handle_reservar_excursao));

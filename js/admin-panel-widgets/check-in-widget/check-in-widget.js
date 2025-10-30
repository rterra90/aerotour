/* eslint-disable no-undef */

//SERÁ SUBSTITUIDO POR REACT

import { mountCheckInModal } from '@/AppCheckInModal/rootAppCheckInModal';

class CheckInModal {
  constructor(varId) {
    this.variation_id = varId;
    this.passageiros = null;
  }

  #getPassageiros(_varId) {
    console.log('chamou #getPassageiros para: ' + _varId);

    adminApiFetch(
      'get_reservas',
      { variation_id: _varId },
      (_success, _data) => {
        console.log(_success);
        console.log(_data);
      },
      'GET',
    );
  }

  #renderElement() {
    const parent = document.querySelector('#wpwrap');
    if (!parent) return;

    // evita duplicar o modal se ele já existir
    if (document.getElementById('check-in-modal')) return;

    const modalElement = document.createElement('div');
    modalElement.id = 'check-in-modal';
    modalElement.innerHTML = `<div id="checkInModalApp"></div>`;
    parent.insertBefore(modalElement, document.querySelector('#adminmenumain'));

    mountCheckInModal();
    // const checkinmodal_app_root = document.getElementById('checkInModalApp');
    // if (checkinmodal_app_root) {
    //   ReactDOM.createRoot(checkinmodal_app_root).render(<AppCheckInModal />);
    // }
  }

  open() {
    this.#renderElement();
    this.#getPassageiros(this.variation_id);
  }
}

window.CheckInModal = CheckInModal;

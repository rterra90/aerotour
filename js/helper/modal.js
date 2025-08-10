function openModalBox(modalID) {
  const modalElement = document.querySelector(`#${modalID}`);

  modalElement.parentElement.classList.add('active');

  function detectAwayClick(event) {
    let _parent = event.target.offsetParent;
    while (_parent && _parent.id !== modalID) _parent = _parent.offsetParent;
    if (_parent === null) {
      document.removeEventListener('click', detectAwayClick);
      modalElement.parentElement.classList.remove('active');
      // modalElement.classList.remove('faded-element-in');
      setTimeout(() => {
        modalElement.classList.add('d-none');
      }, 50);
    }
  }

  if (modalElement.classList.contains('d-none')) {
    setTimeout(() => {
      // modalElement.classList.add('faded-element-in');
      document.addEventListener('click', detectAwayClick);
    }, 20);
  }
  modalElement.classList.remove('d-none');
}

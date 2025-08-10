document.querySelectorAll('[data-btn-reactive]').forEach((btn) => {
  if (btn.dataset.btnReactive === 'input')
    btn.addEventListener('click', (e) => {
      e.target.value = 'Aguarde...';
      btn.classList.add('loading');
    });
  else
    btn.addEventListener('click', (e) => {
      e.target.innerText = 'Aguarde...';
      btn.classList.add('loading');
    });
});

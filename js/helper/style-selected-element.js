function changeStyle(selector) {
  const targets = document.querySelectorAll(selector);
  function handleClass(event) {
    console.log('clicou');
    targets.forEach((t) => t.classList.remove('active'));
    event.currentTarget.classList.add('active');
  }

  targets.forEach((target) => {
    target.addEventListener('click', handleClass);
  });
}

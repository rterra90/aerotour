const toast = document.querySelector('.aer-toast');

if (toast) {
  setTimeout(() => toast.classList.add('active'), 500);
  setTimeout(() => toast.classList.remove('active'), 8500);
  setTimeout(() => toast.remove(), 10000);
}

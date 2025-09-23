// Tab Navigation
const buttons = document.querySelectorAll('.tab-btn');
const contents = document.querySelectorAll('.tab-content');

buttons.forEach((btn) => {
  btn.addEventListener('click', () => {
    // Remove active de todos os botões e conteúdos
    buttons.forEach((b) => b.classList.remove('active'));
    contents.forEach((c) => c.classList.remove('active'));

    // Ativa o botão e conteúdo correspondente
    btn.classList.add('active');
    document.getElementById(btn.dataset.tab).classList.add('active');
  });
});

// Seção Embarques
const botoesFiltro = document.querySelectorAll(
  '.filtro-btn, .mostrar-tudo-btn',
);
const itens = document.querySelectorAll('.item-embarque');
const filtroCidades = document.getElementById('filtroCidades');
const mostrarTudoBtn = document.querySelector('.mostrar-tudo-btn');

botoesFiltro.forEach((btn) => {
  btn.addEventListener('click', () => {
    // Exibe/oculta botão "mostrar tudo"
    if (btn.dataset.cidade == 'todas') mostrarTudoBtn.classList.add('d-none');
    else mostrarTudoBtn.classList.remove('d-none');

    //Estiliza botão ativo
    document.querySelector('.filtro-btn.active').classList.remove('active');
    if (btn.tagName == 'BUTTON') btn.classList.add('active');
    else {
      document.querySelector('.filtro-btn:first-child').classList.add('active');
    }
    //Alterna o conteúdo visível
    const cidade = btn.dataset.cidade;
    itens.forEach((item) => {
      if (cidade === 'todas' || item.dataset.cidade === cidade) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });
});

// Scroll com setas
const scrollLeftBtn = document.getElementById('scrollLeft');
const scrollRightBtn = document.getElementById('scrollRight');

scrollLeftBtn.addEventListener('click', () => {
  filtroCidades.scrollBy({ left: -150, behavior: 'smooth' });
});

scrollRightBtn.addEventListener('click', () => {
  filtroCidades.scrollBy({ left: 150, behavior: 'smooth' });
});

//Botão CTA Reserve Agora
document.querySelector('.cta-button').addEventListener('click', function (e) {
  e.preventDefault();
  const target = document.querySelector(this.getAttribute('href'));
  if (target) {
    target.scrollIntoView({ behavior: 'smooth' });
  }
});

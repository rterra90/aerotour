// Função para lidar com o scroll do slider
function handleSlider(sliderRef, action) {
    const frame = document.querySelector(`.slider-frame[data-slider-ref="${sliderRef}"]`);
    if (!frame) return;

    const slider = frame.querySelector('.slider-wrapper');
    const controls = frame.querySelectorAll('.controls-wrapper span');
    const firstCard = slider.querySelector('.excursion-card');
    
    if (!firstCard) return;

    // Calcula a largura total de um item (card + margens/gap)
    const cardWidth = firstCard.parentElement.offsetWidth; // Pega a largura do col-lg-3
    
    // Define quantos cards pular. No desktop (largura > 992px) pulamos 4, no resto pulamos 1 ou 2.
    const cardsToScroll = window.innerWidth > 992 ? 4 : 1;
    const scrollAmount = cardWidth * cardsToScroll;
    
    const direction = action === 'next' ? 1 : -1;

    slider.scrollBy({
        left: scrollAmount * direction,
        behavior: 'smooth'
    });

    setTimeout(() => {
        const isAtStart = slider.scrollLeft <= 10;
        const isAtEnd = slider.scrollLeft + slider.offsetWidth >= slider.scrollWidth - 10;

        controls[0].classList.toggle('disabled', isAtStart);
        controls[1].classList.toggle('disabled', isAtEnd);
    }, 500);
}


// Animação de revelação dos cards ao entrar na viewport
document.addEventListener('DOMContentLoaded', function() {
    const cardOptions = {
        threshold: 0.15, // Dispara quando 15% do card estiver visível
        rootMargin: "0px 0px -50px 0px" // Margem para iniciar a animação um pouco antes
    };

    const cardObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Adiciona a classe que dispara a transição CSS
                entry.target.classList.add('is-visible');
                // Para de observar o card após a animação para economizar recursos
                observer.unobserve(entry.target);
            }
        });
    }, cardOptions);

    // Seleciona todos os cards para observação
    const cards = document.querySelectorAll('.reveal-card');
    cards.forEach(card => cardObserver.observe(card));
});
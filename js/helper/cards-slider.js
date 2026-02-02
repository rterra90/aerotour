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
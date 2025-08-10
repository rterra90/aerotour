function handleSlider(sliderRef, action, qtyPage) {
  const sliderRefComponent = document.querySelector(
    `.slider-frame[data-slider-ref="${sliderRef}"]`,
  );
  const sliderWrapper = sliderRefComponent.querySelector(`.slider-wrapper`);
  const slider = sliderRefComponent.querySelector('.slider');
  const totalCards = slider.querySelectorAll('.display-card').length;
  const controls = sliderRefComponent.querySelectorAll(
    `.controls-wrapper span`,
  );
  const currentPage = +slider.dataset.page;
  const currentScroll = +slider.dataset.scroll;

  if (action === 'next' && !controls[1].classList.contains('disabled')) {
    const carsdToNext = totalCards - qtyPage * currentPage;
    const slideDistance = carsdToNext * (100 / qtyPage);
    slider.style.transform = `translateX(-${currentScroll + slideDistance}%)`;
    slider.dataset.scroll = +currentScroll + slideDistance;
    slider.dataset.page = currentPage + 1;
    if (carsdToNext <= qtyPage) controls[1].classList.add('disabled');
    controls[0].classList.remove('disabled');
  } else if (
    action === 'previous' &&
    !controls[0].classList.contains('disabled')
  ) {
    slider.dataset.page = currentPage - 1;
    slider.dataset.scroll = currentScroll <= 100 ? 0 : currentScroll - 100;
    slider.style.transform = `translateX(${slider.dataset.scroll}%)`;
    if (currentScroll <= 100) controls[0].classList.add('disabled');
    controls[1].classList.remove('disabled');
  }
}

function cardAlertsSlider(sliderRef, cardRef) {
  const cardAlertsWrapper = document.querySelector(
    `section#${sliderRef} .aer-card[data-id="${cardRef}"] .card-alerts-wrapper`,
  );
  if (cardAlertsWrapper.children.length > 1) {
    const areaUtil =
      document.querySelector(`section#${sliderRef} .aer-card`).offsetWidth - 10;
    if (cardAlertsWrapper.scrollWidth > areaUtil) {
      const slideLength = cardAlertsWrapper.scrollWidth - areaUtil;
      cardAlertsWrapper.style.setProperty(
        '--slideEnd',
        '-' + (slideLength + 10) + 'px',
      );
      cardAlertsWrapper.style.setProperty(
        '--slideDuration',
        cardAlertsWrapper.children.length * 4 + 's',
      );
      cardAlertsWrapper.classList.add('animate');
    }
  }
}

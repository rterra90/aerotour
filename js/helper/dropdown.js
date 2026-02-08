/**
 * Alterna a visibilidade de menus flutuantes (dropdowns)
 * @param {string} elementID - ID do elemento a ser exibido
 */
function toggleDropdown(elementID) {
    const menu = document.querySelector(`#${elementID}`);
    if (!menu) return;

    const parent = menu.parentElement;

    // Função para fechar o menu
    const closeMenu = () => {
        parent.classList.remove('active');
        // Pequeno delay para permitir animações de saída se necessário
        setTimeout(() => menu.classList.add('d-none'), 50);
        document.removeEventListener('click', handleOutsideClick);
    };

    // Função que detecta clique fora
    function handleOutsideClick(event) {
        // Se o clique NÃO foi no menu e NÃO foi no botão que abre o menu
        if (!menu.contains(event.target) && !parent.contains(event.target)) {
            closeMenu();
        }
    }

    // Lógica de abertura/fechamento
    if (menu.classList.contains('d-none')) {
        menu.classList.remove('d-none');
        parent.classList.add('active');
        
        // Timeout de 1ms evita que o próprio clique de abertura feche o menu instantaneamente
        setTimeout(() => {
            document.addEventListener('click', handleOutsideClick);
        }, 1);
    } else {
        closeMenu();
    }
}
document.addEventListener('click', (e) => {
    const targetID = e.target.getAttribute('data-dropdown-target');
    if (targetID) {
        toggleDropdown(targetID);
    }
});
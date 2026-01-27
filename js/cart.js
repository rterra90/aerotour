document.addEventListener("DOMContentLoaded", () => {
    // Toggle passageiros
    document.querySelectorAll(".toggle-passengers").forEach(btn => {
        btn.addEventListener("click", () => {
            const list = btn.nextElementSibling;
            const paxQty = btn.dataset.qty;
            list.classList.toggle("open");
            btn.classList.toggle("active");
            btn.textContent = list.classList.contains("open") 
                ? "Ocultar passageiros ("+paxQty+")"
                : "Ver passageiros ("+paxQty+")";
        });
    });

    // Remover item com confirmação
    document.querySelectorAll(".remove-item").forEach(btn => {
        btn.addEventListener("click", (e) => {
            if (!confirm("Tem certeza que deseja remover esta excursão do carrinho?")) {
                e.preventDefault();
            }
        });
    });

    // Ajustes visuais
    const totalTitle = document.querySelector('.cart_totals h2');
    if(totalTitle) totalTitle.classList.add('bg-title');
    const finalizarBtn = document.querySelector('.checkout-button');
    if(finalizarBtn) finalizarBtn.innerText = "Continuar para pagamento";
});

function toggleCupomInputs(element_id){
    document.querySelector('#' + element_id).classList.toggle('active');
}
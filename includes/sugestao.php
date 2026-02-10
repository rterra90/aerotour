<script>
  const excursoesDisponiveis = <?php echo json_encode($dados_js); ?>;
</script>
<section class="sugestao-cta py-4 container-md">
  <div class="sugestao-cta-wrapper card-moderno">
    <div class="text-area">
      <strong>Não encontrou sua excursão?</strong>
      <span>Envie-nos sua sugestão de show ou evento!</span>
    </div>

    <div class="input-container">
      <input type="text" id="input-sugestao" placeholder="Ex: Show do Coldplay em SP" autocomplete="off">
      <button id="btn-sugerir" disabled>Sugerir</button>
    </div>
  </div>
</section>
<script>
  const limparString = (str) => {
    return str
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "") // Remove acentos
      .replace(/[^a-z0-9]/g, ""); // Remove espaços e caracteres especiais
  };
  document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('input-sugestao');
    const btnSugerir = document.getElementById('btn-sugerir');

    // 1. Habilitar botão apenas se houver texto
    input.addEventListener('input', () => {
      btnSugerir.disabled = input.value.trim().length < 3;
    });

    btnSugerir.addEventListener('click', async (e) => {
      const termoOriginal = input.value.trim();
      const termoLimpo = limparString(termoOriginal);
      const modal = new Modal();
      // Comparação forte: verifica se o termo limpo está contido no nome limpo do produto
      const sugestaoEncontrada = excursoesDisponiveis.find(ex =>
        ex.nome_limpo.includes(termoLimpo) || termoLimpo.includes(ex.nome_limpo)
      );

      if (sugestaoEncontrada) {
        // Abrir modal com detalhes da excursão encontrada (#1 template, #2 dados)
        await modal.open('sugestao-match', {
          nome: sugestaoEncontrada.nome,
          url: sugestaoEncontrada.url
        });
        // Adiciona lógica ao link interno do modal após carregar
        document.getElementById('continuar-sugestao').onclick = async () => {
          await modal.open('sugestao-form', {
            termo: termoOriginal
          });
        };
      } else {
        // Abrir modal de sugestão sem correspondência
        await modal.open('sugestao-form', {
          termo: termoOriginal
        });
      }

      console.log('Termo limpo:', termoLimpo);
      console.log(sugestaoEncontrada ? 'Encontrada excursão similar:' : 'Nenhuma excursão encontrada', sugestaoEncontrada);

    });
  });



  // if (window.location.hash.startsWith('#wpcf7')) {
  //   document.querySelector('.sugestao-cta .input-area').remove()
  // }
  // document.querySelector('.sugestao-cta input.wpcf7-submit').setAttribute('data-btn-reactive', 'input')
</script>
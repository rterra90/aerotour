<script>
  // Variável global com os dados das excursões para uso no modal de sugestão
  const excursoesDisponiveis = <?php echo json_encode($dados_js); ?>;
</script>
<section class="sugestao-cta py-4 container-md">
  <div class="sugestao-cta-wrapper card-moderno">
    <div class="text-area">
      <strong>Não encontrou sua excursão?</strong>
      <span>Envie sua sugestão de show ou evento!</span>
    </div>

    <div class="input-container">
      <input type="text" id="input-sugestao" placeholder="Qual excursão você gostaria?" autocomplete="off">
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
      const sugestaoModal = new Modal();

      // 2. Verificar se o termo corresponde a alguma excursão disponível (suporta multiplos resultados)
      const matches = excursoesDisponiveis.filter(ex => ex.nome_limpo.includes(termoLimpo));

      //
      if (matches.length === 1) {
        // Apenas um resultado: usamos o match individual
        await sugestaoModal.open('sugestao-match', {
          termo: termoOriginal,
          nome: matches[0].nome,
          url: matches[0].url
        });
      } else if (matches.length > 1) {
        // Múltiplos resultados: geramos a lista
        await sugestaoModal.open('sugestao-lista', {
          termo: termoOriginal,
          lista_html: gerarHtmlLista(matches)
        });
      } else {
        // Nenhum resultado: formulário de sugestão
        await sugestaoModal.open('sugestao-form', {
          termo: termoOriginal
        });
      }

      // Adiciona lógica ao link interno do modal após carregar
      const continueLink = document.getElementById('continuar-sugestao');
      if (continueLink) {
        continueLink.onclick = async () => {
          await sugestaoModal.open('sugestao-form', {
            termo: termoOriginal
          });
        };
      }

    });
  });


  // Função auxiliar para criar a lista de links
  function gerarHtmlLista(items) {
    return items.map(item => `
        <div class="match-item">
            <span>${item.nome}</span>
            <a href="${item.url}" class="btn-ir">Ver Excursão</a>
        </div>
    `).join('');
  }
</script>
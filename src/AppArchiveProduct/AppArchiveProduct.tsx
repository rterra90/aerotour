import React, { useState, useMemo } from 'react';
import { createRoot } from 'react-dom/client';

type TabState = 'vigentes' | 'passadas';

const AppArchiveProduct: React.FC = () => {
  const [activeTab, setActiveTab] = useState<TabState>('vigentes');
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedGenre, setSelectedGenre] = useState('');

  // Fallback de segurança caso as variáveis globais ainda não estejam prontas
  const { generos = [], excursoesVigentes = [] } = window.ArchiveProductData || {};
console.log('Excursoes Vigentes:', excursoesVigentes);


  // ordernar as excursões vigentes por data_limite (mais próximas primeiro)
  const sortedExcursoesVigentes = useMemo(() => {
    return [...excursoesVigentes].sort((a, b) => {
      return +a.data_limite - +b.data_limite;

    });
  }, [excursoesVigentes]);
  console.log('Sorted Vigentes:', sortedExcursoesVigentes);

  
  const filteredVigentes = useMemo(() => {
    return sortedExcursoesVigentes.filter((exc: { id: number; html: string; genres: string[]; data_limite: string }) => {
      const matchesSearch = exc.html.toLowerCase().includes(searchTerm.toLowerCase());
      const matchesGenre = selectedGenre ? exc.genres.includes(selectedGenre) : true;
      
      return matchesSearch && matchesGenre;
    });

  }, [searchTerm, selectedGenre, excursoesVigentes]);


React.useEffect(() => {
   // 1. Só inicializa o observer se houver cards renderizados na tela
   if (filteredVigentes.length === 0 || activeTab !== 'vigentes') return;
    console.log('Filtered Vigentes:', filteredVigentes);

   const cardOptions = {
      threshold: 0.15,
      rootMargin: "0px 0px -50px 0px"
   };

   const cardObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
      if (entry.isIntersecting) {
         entry.target.classList.add('is-visible');
         // Para de observar após revelar
         observer.unobserve(entry.target);
      }
      });
   }, cardOptions);

   // 2. Seleciona os cards atualmente no DOM
   const cards = document.querySelectorAll('.reveal-card');
   cards.forEach(card => cardObserver.observe(card));

   // 3. Cleanup: Função de limpeza que o React executa antes de rodar 
   // o useEffect novamente (por exemplo, quando o usuário digita no filtro)
   return () => {
      cardObserver.disconnect();
   };
}, [filteredVigentes, activeTab]);

  return (
    <div className="aerotour-archive-app">
      <header className="archive-header-filters d-flex flex-column flex-md-row justify-content-between align-items-center mb-5 gap-3">
        <div className="btn-group" role="group" aria-label="Navegação de excursões">
          <button 
            className={`btn ${activeTab === 'vigentes' ? 'btn-danger' : 'btn-dark'}`}
            onClick={() => setActiveTab('vigentes')}
          >
            Próximas Viagens
          </button>
          <button 
            className={`btn ${activeTab === 'passadas' ? 'btn-danger' : 'btn-dark'}`}
            onClick={() => setActiveTab('passadas')}
          >
            Viagens Realizadas
          </button>
        </div>
        
        <div className="filters d-flex gap-2 w-100" style={{ maxWidth: '500px' }}>
          <input 
            type="text" 
            className="form-control bg-dark text-light border-secondary" 
            placeholder="Digite para buscar..." 
            value={searchTerm}
            onChange={(e) => setSearchTerm(e.target.value)}
          />
          <select 
            className="form-select bg-dark text-light border-secondary w-auto" 
            value={selectedGenre} 
            onChange={(e) => setSelectedGenre(e.target.value)} 
          >
            <option value="">Todos os Gêneros</option>
            {generos.map((g) => (
              <option key={g.term_id} value={g.slug}>{g.name}</option>
            ))}
          </select>
        </div>
      </header>

      <div className="archive-grid row">
        {activeTab === 'vigentes' ? (
          filteredVigentes.length > 0 ? (
            filteredVigentes.map((exc) => (
               <div 
                  key={exc.id} 
                  className="col-12 col-md-6 col-lg-3 mb-4" 
                  dangerouslySetInnerHTML={{ __html: exc.html }} 
               />
            ))
          ) : (
            <div className="col-12 text-center py-5 text-light">
              <p>Nenhuma excursão encontrada com estes filtros.</p>
            </div>
          )
        ) : (
          <div className="col-12 text-center py-5 text-light">
            <p>Carregando histórico de excursões...</p>
          </div>
        )}
      </div>
    </div>
  );
};

// Lógica de Montagem do React
// após carregar o DOM, garantindo que o elemento de montagem exista
window.addEventListener('DOMContentLoaded', () => {
const rootElement = document.getElementById('app-archive-product-root');

if (rootElement) {
  const root = createRoot(rootElement);
  root.render(<AppArchiveProduct />);
} else {
   console.log(document.querySelector('body'));
  console.error('Elemento #app-archive-product-root não encontrado na página.');
}
});   
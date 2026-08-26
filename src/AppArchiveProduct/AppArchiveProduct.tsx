import React, { useState, useMemo, useEffect, useCallback } from 'react';
import { createRoot } from 'react-dom/client';

type TabState = 'vigentes' | 'passadas';

interface Termo {
  term_id: number;
  name: string;
  slug: string;
}

interface ExcursaoVigente {
  id: number;
  html: string;
  data_limite: number | string;
  categorias?: string[];
  genres?: string[];
  venues?: string[];
}

declare global {
  interface Window {
    ArchiveProductData: {
      apiUrl: string;
      categorias: Termo[];
      generos: Termo[];
      locais: Termo[];
      excursoesVigentes: ExcursaoVigente[];
    };
  }
}

const AppArchiveProduct: React.FC = () => {
  const [activeTab, setActiveTab] = useState<TabState>('vigentes');
  const [searchTerm, setSearchTerm] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('');
  
  // Estados para seleção múltipla (Tag Cloud)
  const [selectedGenres, setSelectedGenres] = useState<string[]>([]);
  const [selectedVenues, setSelectedVenues] = useState<string[]>([]);
  
  // Estado para exibir/ocultar os filtros avançados
  const [showAdvancedFilters, setShowAdvancedFilters] = useState(false);

  const [pastExcursions, setPastExcursions] = useState<ExcursaoVigente[]>([]);
  const [isLoadingPast, setIsLoadingPast] = useState(false);
  const [pastPage, setPastPage] = useState(1);
  const [hasMorePast, setHasMorePast] = useState(false);

  const { categorias = [], generos = [], locais = [], excursoesVigentes = [] } = window.ArchiveProductData || {};

  const sortedExcursoesVigentes = useMemo(() => {
    return [...excursoesVigentes].sort((a, b) => +a.data_limite - +b.data_limite);
  }, [excursoesVigentes]);

  const filteredVigentes = useMemo(() => {
    return sortedExcursoesVigentes.filter((exc) => {
      const matchesSearch = exc.html.toLowerCase().includes(searchTerm.toLowerCase());
      const matchesCategory = selectedCategory ? exc.categorias?.includes(selectedCategory) : true;
      
      // Se há gêneros selecionados, a excursão deve ter pelo menos um deles (Lógica OR)
      const matchesGenre = selectedGenres.length > 0 
        ? exc.genres?.some(g => selectedGenres.includes(g)) 
        : true;
        
      // Mesma lógica para locais
      const matchesVenue = selectedVenues.length > 0  
        ? exc.venues?.some(v => selectedVenues.includes(v)) 
        : true;
      
      return matchesSearch && matchesCategory && matchesGenre && matchesVenue;
    });
  }, [searchTerm, selectedCategory, selectedGenres, selectedVenues, sortedExcursoesVigentes]);

  // Observer de Intersecção
  useEffect(() => {
    const listToObserve = activeTab === 'vigentes' ? filteredVigentes : pastExcursions;
    if (listToObserve.length === 0) return;

    const cardObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.15, rootMargin: "0px 0px -50px 0px" });

    const cards = document.querySelectorAll('.reveal-card:not(.is-visible)');
    cards.forEach(card => cardObserver.observe(card));

    return () => cardObserver.disconnect();
  }, [filteredVigentes, pastExcursions, activeTab]);

  // Função para capitalizar a primeira letra de cada palavra
   function capitalizeWords(sentence: string): string {
   return sentence
      .split(" ")
      .map(word => word.charAt(0).toUpperCase() + word.slice(1))
      .join(" ");
   }

  const fetchPastExcursions = useCallback(async (page: number, resetList: boolean = false) => {
    setIsLoadingPast(true);
    const { apiUrl } = window.ArchiveProductData || {};
    try {
      const url = new URL(apiUrl);
      url.searchParams.append('page', page.toString());
      if (searchTerm) url.searchParams.append('search', searchTerm);
      if (selectedCategory) url.searchParams.append('category', selectedCategory);
      
      // Envia os arrays como strings separadas por vírgula para a API do WP
      if (selectedGenres.length > 0) url.searchParams.append('genres', selectedGenres.join(','));
      if (selectedVenues.length > 0) url.searchParams.append('venues', selectedVenues.join(','));

      const response = await fetch(url.toString());
      const data = await response.json();

      setPastExcursions(prev => resetList ? data.items : [...prev, ...data.items]);
      setHasMorePast(page < data.max_pages);
    } catch (error) {
      console.error("Erro ao buscar histórico:", error);
    } finally {
      setIsLoadingPast(false);
    }
  }, [searchTerm, selectedCategory, selectedGenres, selectedVenues]);

  // Reseta e busca ao alterar filtros da aba "passadas"
  useEffect(() => {
    if (activeTab === 'passadas') {
      setPastPage(1);
      fetchPastExcursions(1, true);
    }
  }, [activeTab, searchTerm, selectedCategory, selectedGenres, selectedVenues, fetchPastExcursions]);

  const loadMorePast = () => {
    const nextPage = pastPage + 1;
    setPastPage(nextPage);
    fetchPastExcursions(nextPage, false);
  };

  // Helpers para adicionar/remover tags das seleções
  const toggleSelection = (slug: string, currentSelection: string[], setSelection: React.Dispatch<React.SetStateAction<string[]>>) => {
    if (currentSelection.includes(slug)) {
      setSelection(currentSelection.filter(item => item !== slug));
    } else {
      setSelection([...currentSelection, slug]);
    }
  };

  const renderSkeletons = (count: number) => {
    return Array.from({ length: count }).map((_, i) => (
      <div key={`skeleton-${i}`} className="col-12 col-md-6 col-lg-4 mb-4">
        <div className="card-skeleton" style={{ height: '350px', backgroundColor: '#222', borderRadius: '12px', animation: 'pulse 1.5s infinite ease-in-out' }}></div>
      </div>
    ));
  };

  return (
    <div className="aerotour-archive-app">
      <header className="archive-header-filters mb-5">
        
        {/* Barra Principal de Filtros */}
        <div className="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
            <div id="archive-type-btn-group" className="btn-group" role="group" aria-label="Navegação de excursões">
               <button className={`btn proximas-btn ${activeTab === 'vigentes' ? 'active' : ''}`} onClick={() => setActiveTab('vigentes')}>Próximas</button>
               <button className={`btn realizadas-btn ${activeTab === 'passadas' ? 'active' : ''}`} onClick={() => setActiveTab('passadas')}>Passadas</button>
            </div>
            
            <div className="filters d-flex gap-2 w-100 justify-content-md-end" style={{ maxWidth: '720px' }}>
               <div className="search-input-wrapper">
                  <input 
                  type="text" 
                  className="form-control bg-dark text-light border-secondary flex-grow-1 px-3 py-2" 
                  // style={{ minWidth: '200px' }}
                  placeholder="Digite para buscar..." 
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  /> 
                  {searchTerm && (
                  <span className="clear-btn" onClick={() => setSearchTerm('')}>x</span>
                  )}
               </div>
            
            
               <select 
               className="form-select bg-dark text-light border-secondary w-auto" 
               value={selectedCategory} 
               style={{ minWidth: '160px' }}
               onChange={(e) => setSelectedCategory(e.target.value)} 
               >
               <option value="">Todas...</option>
               {Object.values(categorias)
                 .filter((c) => ['shows', 'eventos', 'festivais'].includes(c.slug))
                 .map((c) => (
                   <option key={c.term_id} value={c.slug}>{c.name}</option>
               ))}
               </select>

               <button 
               id="archive-filters-toggle-btn"
               className={`btn ${showAdvancedFilters ? 'btn-light' : 'btn-outline-light'}`}
               onClick={() => setShowAdvancedFilters(!showAdvancedFilters)}
               >
                  <i className="bi bi-sliders"></i> <span>Filtros</span>
               </button>
            </div>
        </div>

        {/* Seção Retrátil de Filtros Avançados (Tag Cloud) */}
        {showAdvancedFilters && (
          <div className="advanced-filters-panel bg-dark border border-secondary rounded p-4 mt-3 shadow-sm" style={{ animation: 'fadeIn 0.3s' }}>
            <div className="row">
              {/* Nuvem de Gêneros Musicais */}
              <div className="col-12 col-md-6 mb-3 mb-md-0">
                <h6 className="text-uppercase text-secondary mb-2 small fw-bold">Gênero Musical</h6>
                <div className="d-flex flex-wrap gap-2">
                  {generos.map((g) => {
                    const isActive = selectedGenres.includes(g.slug);
                    return (
                      <button 
                        key={g.term_id}
                        onClick={() => toggleSelection(g.slug, selectedGenres, setSelectedGenres)}
                        className={`btn btn-sm rounded-pill transition-all ${isActive ? 'btn-danger' : 'btn-outline-secondary text-light'}`}
                      >
                        {g.name} {isActive && <span className="ms-1">&times;</span>}
                      </button>
                    );
                  })}
                </div>
              </div>

              {/* Nuvem de Locais */}
              <div className="col-12 col-md-6">
                <h6 className="text-uppercase text-secondary mb-2 small fw-bold">Local do Evento</h6>
                <div className="d-flex flex-wrap gap-2">
                  {locais.map((l) => {
                    const isActive = selectedVenues.includes(l.slug);
                    return (
                      <button 
                        key={l.term_id}
                        onClick={() => toggleSelection(l.slug, selectedVenues, setSelectedVenues)}
                        className={`btn btn-sm rounded-pill transition-all ${isActive ? 'btn-danger' : 'btn-outline-secondary text-light'}`}
                      >
                        {l.name} {isActive && <span className="ms-1">&times;</span>}
                      </button>
                    );
                  })}
                </div>
              </div>
            </div>
            
            {/* Botão de Limpar Filtros */}
            {(selectedGenres.length > 0 || selectedVenues.length > 0) && (

                <button 
                  className="filtros-limpar-btn"
                  onClick={() => { setSelectedGenres([]); setSelectedVenues([]); }}
                >
                  Limpar Seleção
                </button>

            )}
          </div>
        )}

         {/* Resumo dos Filtros Ativos */}
        {(searchTerm || selectedCategory || selectedGenres.length > 0 || selectedVenues.length > 0) && (
          <div className="active-filters-summary mt-3 text-light">
            <strong>Filtrando por:</strong>
            {selectedCategory && <span className="ms-2">Categoria: {capitalizeWords(selectedCategory)}</span>}
            {selectedGenres.length > 0 && <span className="ms-2">Gêneros: {selectedGenres.map(g => g !== 'k-pop' ? g.replace(/-/g, ' ') : 'k-pop').join(', ')}</span>}
            {selectedVenues.length > 0 && <span className="ms-2">Locais: {selectedVenues.map(g => capitalizeWords(g.replace(/-/g, ' '))).join(', ')}</span>}
          </div>
        )}
      </header>

      <div className="archive-grid row">
        {activeTab === 'vigentes' ? (
          filteredVigentes.length > 0 ? (
            filteredVigentes.map((exc) => (
               <div key={exc.id} className="col-12 col-sm-6 col-md-4 col-xl-3 mb-4 px-5 px-sm-3" dangerouslySetInnerHTML={{ __html: exc.html }} />
            ))
          ) : (
            <div className="col-12 text-center py-5 text-light">
              <p>Nenhuma excursão encontrada com estes filtros.</p>
            </div>
          )
        ) : (
          <>
            {pastExcursions.map((exc) => (
              <div key={exc.id} className="col-12 col-sm-6 col-md-4 col-xl-3 mb-4 px-5 px-sm-2" dangerouslySetInnerHTML={{ __html: exc.html }} />
            ))}
            
            {isLoadingPast && renderSkeletons(pastExcursions.length === 0 ? 8 : 4)}
            
            {!isLoadingPast && pastExcursions.length === 0 && (
              <div className="col-12 text-center py-5 text-light"><p>Nenhum histórico encontrado com estes filtros.</p></div>
            )}

            {!isLoadingPast && hasMorePast && (
              <div className="col-12 text-center mt-4">
                <button onClick={loadMorePast} className="btn btn-outline-light">Carregar mais viagens</button>
              </div>
            )}
          </>
        )}
      </div>
    </div>
  );
};

window.addEventListener('DOMContentLoaded', () => {
  const rootElement = document.getElementById('app-archive-product-root');
  if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<AppArchiveProduct />);
  } else {
    console.error('Elemento #app-archive-product-root não encontrado na página.');
  }
});
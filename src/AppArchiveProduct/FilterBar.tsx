// src/components/FilterBar.tsx
import React from 'react';
import { TabState, Genero } from '../types/excursoes';

interface FilterBarProps {
  activeTab: TabState;
  onTabChange: (tab: TabState) => void;
  onSearch: (query: string) => void;
  generos: Genero[];
}

const FilterBar: React.FC<FilterBarProps> = ({ activeTab, onTabChange, onSearch, generos }) => {
  return (
    <div className="aer-filter-bar">
      {/* Elementos de busca e botões de abas */}
    </div>
  );
};

export default FilterBar;
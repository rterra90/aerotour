// src/types/archiveProduct.ts
export type TabState = 'vigentes' | 'passadas';

export interface Genero {
  term_id: number;
  name: string;
  slug: string;
}

export interface FiltrosAtivos {
  searchQuery: string;
  selectedGenre: string;
}
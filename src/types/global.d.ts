// src/types/global.d.ts
export {}; // Garante que o arquivo seja tratado como um módulo pelo TS

declare global {
  interface Window {
    ArchiveProductData: {
      apiUrl: string;
      nonce: string;
      generos: Array<{
        term_id: number;
        name: string;
        slug: string;
      }>;
      excursoesVigentes: Array<{
        id: number;
        html: string;
        genres: string[];
        data_limite: string;
      }>;
    };
  }
}
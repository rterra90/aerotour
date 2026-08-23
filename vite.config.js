import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    // Direciona os arquivos gerados para a mesma pasta que o esbuild usava
    outDir: 'js/react_apps',
    emptyOutDir: false, // Evita apagar outros arquivos da pasta
    rollupOptions: {
      input: {
        // Suas aplicações atuais mapeadas
        app_reservas_usuario: path.resolve(__dirname, 'src/AppReservas/AppReservas.jsx'),
        app_reservas_admin: path.resolve(__dirname, 'src/AppReservasAdmin/AppReservasAdmin.jsx'),
        app_checkin: path.resolve(__dirname, 'src/AppCheckIn/AppCheckIn.jsx'),
        third_party_login: path.resolve(__dirname, 'src/AppThirdPartyLogin/AppThirdPartyLogin.jsx'),
        // A NOVA aplicação de arquivo
        app_archive_excursoes: path.resolve(__dirname, 'src/AppArchive/main.tsx'),
      },
      output: {
        // Garante que o arquivo final tenha o mesmo nome da chave definida acima (ex: app_checkin.js)
        entryFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
  },
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'src'),
    },
  },
});

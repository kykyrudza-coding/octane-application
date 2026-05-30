const { defineConfig } = require('vite');

module.exports = defineConfig({
  publicDir: false,
  server: {
    host: '127.0.0.1',
    port: 5173,
    strictPort: true,
  },
  build: {
    manifest: true,
    outDir: 'public/assets',
    emptyOutDir: true,
    rollupOptions: {
      input: 'resources/js/app.js',
    },
  },
});

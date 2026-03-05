import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  plugins: [
    tailwindcss(),
    vue()
  ],
  server: {
    proxy: {
      '/api': {
        target: process.env.BACKEND_HOST || 'http://localhost:8000',
        changeOrigin: true
      }
    }
  }
})
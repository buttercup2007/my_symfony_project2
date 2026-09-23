import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue()
    ],

    server: {
        port: 5173,
        strictPort: true,

        watch: {
            usePolling: true,
            interval: 100
        }
    },

    build: {
        outDir: 'public/build',
        emptyOutDir: true,
        rollupOptions: {
            input: 'assets/app.js'
        }
    }
})
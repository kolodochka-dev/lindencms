import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
            ],
            publicDirectory: 'public',
            buildDirectory: 'vendor/lindencms/cms',
        }),
        tailwindcss(),
    ],
    // Добавьте эту секцию
    server: {
        host: 'lindenrebuild-test.test', // Ваш домен Laragon
        port: 5174, // Порт, который вы используете
        hmr: {
            host: 'lindenrebuild-test.test', // Домен для WebSocket
        },
    },
    build: {
        rollupOptions: {
            output: {
                entryFileNames: `assets/[name].js`,
                chunkFileNames: `assets/[name].js`,
                assetFileNames: `assets/[name].[ext]`,
            },
        },
    }
});
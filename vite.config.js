import viteCompression from 'vite-plugin-compression';
import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        viteCompression(),

        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),


    ],
    resolve: {
        alias: {
            '$': 'jQuery',
        },

    },
    build: {
        minify: 'terser', // atau 'esbuild' tergantung pada kebutuhan Anda
        sourcemap: true,

    }
});

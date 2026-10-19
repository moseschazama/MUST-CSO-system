import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            fonts: [
                bunny('Cormorant Garamond', {
                    alias: 'cormorant',
                    weights: [500, 600, 700],
                    subsets: ['latin'],
                    optimizedFallbacks: false,
                }),
                bunny('Source Sans 3', {
                    alias: 'source-sans',
                    weights: [400, 500, 600],
                    subsets: ['latin'],
                    optimizedFallbacks: false,
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {host: true},
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/scan.js',
                'resources/js/qrscanorder.js'
            ],
            refresh: true,
        }),
    ],
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],

    base: (process.env.APP_URL ? process.env.APP_URL + '/build/' : '/'), // Asegura que las URLs usen HTTPS en producción
    //https://url-base/build/assets/...
});

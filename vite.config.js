import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue"

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            vue:"vue/dist/vue.esm-bundler.js",
            '@routes': "/resources/js/routes",
            '@pages':"resources/js/components/pages",
            '@utils':"/resources/js/utils",
            '@layouts':"resources/js/components/pages/layouts"
        },
    },
    server: {
        https: false,
        host: true,
        port: 3000,
        hmr: { host: 'localhost', protocol: 'ws' },
    },
});

import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/landing.css',
                'resources/js/landing.js',
                'resources/css/auth.css',
                'resources/js/auth.js',
                'resources/css/dashboard.css',
                'resources/js/dashboard.js',
            ],
            refresh: true,
        }),
    ], build: {
        rollupOptions: {
            output: {
                manualChunks: {
                    vendor: ['jquery', 'select2', 'bootstrap', 'datatables.net-bs5', 'sweetalert2'],
                    pdf: ['jspdf', 'jszip', 'pdfmake', 'xlsx'],
                    fancybox: ['@fancyapps/ui'],
                    // moment: ['moment', 'moment-timezone'],
                    // alpine: ['alpinejs'],
                },
            },
        },
    }, resolve: {
        alias: {
            '$': 'jQuery',
        }
    },
});

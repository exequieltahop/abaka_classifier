import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { VitePWA } from 'vite-plugin-pwa';


export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/pwa-install.js'],
            refresh: true,
        }),
        tailwindcss(),
        VitePWA({
            registerType: 'autoUpdate',
            manifest: {
                name: 'Abaca Image Classification System',
                short_name: 'AICS',
                description: '',
                theme_color: '#4D179A',
                background_color: '#4D179A',
                display: 'standalone',
                scope: '/',
                start_url: '/',
                icons: [
                    { src: '/icons/abaca.png', sizes: '192x192', type: 'image/png' },
                    { src: '/icons/abaca.png', sizes: '512x512', type: 'image/png' }
                ]
            },
            workbox: {
                runtimeCaching: [
                    {
                        urlPattern: /^\/.*/, // cache SPA routes
                        handler: 'NetworkFirst',
                        options: {
                            cacheName: 'html-cache',
                            expiration: { maxEntries: 50, maxAgeSeconds: 24 * 60 * 60 }
                        }
                    },
                    {
                        urlPattern: /\.(?:js|css|png|jpg|jpeg|svg|woff2?)$/,
                        handler: 'CacheFirst',
                        options: {
                            cacheName: 'asset-cache',
                            expiration: { maxEntries: 100, maxAgeSeconds: 7 * 24 * 60 * 60 }
                        }
                    }
                ]
            }
        })
    ],
});

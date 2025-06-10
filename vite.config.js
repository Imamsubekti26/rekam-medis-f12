import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

const exterdalDepencency = [
    '@fullcalendar/core',
    '@fullcalendar/daygrid',
    '@fullcalendar/interaction',
    'laravel-echo',
    'pusher-js'
];

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
    ],
    optimizeDeps: {
        include: exterdalDepencency,
    },
    server: {
        cors: true,
    },
});
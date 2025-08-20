import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import * as glob from 'glob';
import path from 'path';

// Get all the JavaScript files in the resources/admin/js/pages/* directory
const adminPages = glob.sync(path.resolve(__dirname, 'resources/admin/js/pages/**/*.js')).map(file => path.relative(__dirname, file));
const dayjsLocales = glob.sync(path.resolve(__dirname, 'node_modules/dayjs/locale/*.js')).map(file => path.relative(__dirname, file));

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // User CSS
                'resources/web/css/app.css',

                // Admin CSS
                'resources/admin/css/app.css',

                // Chat CSS
                'resources/components/chat/css/app.css',

                // User JS
                'resources/web/js/index.js',

                // Admin JS
                'resources/admin/js/index.js',

                // Admin Pages JS
                ...adminPages,

                // dayjs locales
                ...dayjsLocales,
            ],
            refresh: true,
        }),
    ],
});

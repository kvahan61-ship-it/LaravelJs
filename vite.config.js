import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/auth/Login.css',
                'resources/css/auth/Reg.css',
                'resources/css/Post/create.css',
                'resources/css/Post/Post.css',
                'resources/css/Home.css',
                'resources/js/app.js',
                'resources/js/auth/Login.js',
                'resources/js/auth/Reg.js',
                'resources/js/auth.js',
                'resources/js/post/post-create.js',
                'resources/js/post-edit.js',
                'resources/js/post-actions.js',
                'resources/js/post/post-delete.js',
                'resources/js/post/carusel.js',
                'resources/js/Cart/cart-create.js',
                'resources/js/Cart/cart.js'

            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});

/*
 |--------------------------------------------------------------------------
 | Admin Asset Mixing
 |--------------------------------------------------------------------------
 |
 */
const mix = require('laravel-mix');
require('mix-tailwindcss');

mix.js('resources/assets/admin/js/admin.js', 'public/assets/admin/js')
    .js('resources/assets/admin/js/preline.js', 'public/assets/admin/js')
    .vue({
        options: {
            compilerOptions: {
                isCustomElement: tag => ['md-linedivider'].includes(tag),
            }
        }
    })
    .postCss('resources/assets/admin/css/admin.css', 'public/assets/admin/css', [
        require('tailwindcss'),
    ])
    .postCss('resources/assets/admin/css/quill.bubble.css', 'public/assets/admin/css', [
        require('tailwindcss'),
    ])
    // Chain postCss calls to merge both files into one
    .combine([
        'public/assets/admin/css/admin.css',
        'public/assets/admin/css/quill.bubble.css',
    ], 'public/assets/admin/css/admin.css')
    .tailwind();
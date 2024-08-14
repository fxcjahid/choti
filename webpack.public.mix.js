/*
 |--------------------------------------------------------------------------
 | Public Asset Mixing
 |--------------------------------------------------------------------------
 |
 */

const mix = require('laravel-mix');
require('mix-tailwindcss');

mix.js('resources/assets/public/js/app.js', 'public/assets/public/js')
    .vue()
    .postCss('resources/assets/public/css/app.css', 'public/assets/public/css', [
        require('tailwindcss')
    ])
    .tailwind()
    .sass('resources/assets/public/css/sass/app.scss', 'public/assets/public/css');



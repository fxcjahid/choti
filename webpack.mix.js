const mix = require('laravel-mix');
require('mix-tailwindcss');

/*
 |--------------------------------------------------------------------------
 | Admin Asset Mixing
 |--------------------------------------------------------------------------
 |
 */

mix.js('resources/assets/admin/js/admin.js', 'public/assets/admin/js')
    .js('resources/assets/admin/js/preline.js', 'public/assets/admin/js')
    .vue({
        options: {
            compilerOptions: {
                isCustomElement: (tag) => ['md-linedivider'].includes(tag),
            },
        },
    })
    .postCss('resources/assets/admin/css/admin.css', 'public/assets/admin/css', [
        require('tailwindcss')
    ])
    .tailwind();


/*
 |--------------------------------------------------------------------------
 | Public Asset Mixing
 |--------------------------------------------------------------------------
 |
 */

mix.js('resources/assets/public/js/app.js', 'public/assets/public/js')
    .vue()
    .postCss('resources/assets/public/css/app.css', 'public/assets/public/css', [
        require('tailwindcss')
    ])
    .tailwind()
    .sass('resources/assets/public/css/sass/app.scss', 'public/assets/public/css');




if (!mix.inProduction()) {
    // Browsersync Automatically Reloading
    //mix.browserSync('http://127.0.0.1:8000/');
}



if (mix.inProduction()) {
    mix.version();
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true, // Remove console item
                }
            }
        }
    });
}

mix.options({
    terser: {
        extractComments: false, // Stop Genarate LICENSE File
    }
});

/**
 * Generate source maps
 * for developer version
 */
mix.sourceMaps(false, 'source-map');

/**
 * Disable notifications send
 */
mix.disableNotifications();

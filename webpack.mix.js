const mix = require('laravel-mix');
require('mix-tailwindcss');

require('./webpack.admin.mix.js');
require('./webpack.public.mix.js');


/**
 * if project is not production mode
 */
if (!mix.inProduction()) {
    // Browsersync Automatically Reloading
    // mix.browserSync('http://127.0.0.1:8000/');
}


/**
 * if project is on production mode
 */
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
    mix.sourceMaps(false, 'source-map'); // Generate source maps
}

mix.options({
    terser: {
        extractComments: false, // Stop Genarate LICENSE File
    }
});


/**
 * Disable notifications send
 */
// mix.disableNotifications();

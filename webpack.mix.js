const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.css('resources/css/admin.css', 'public/css')
   .css('resources/css/customer.css', 'public/css');

// Add versioning for cache busting in production
if (mix.inProduction()) {
    mix.version();
}

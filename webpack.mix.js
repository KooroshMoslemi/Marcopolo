const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'resources/css/libs/bootstrap.css',
        'resources/css/libs/owl.carousel.min.css',
        'resources/css/libs/owl.theme.default.css',
        'resources/css/libs/ui.css',
        'resources/css/libs/responsive.css',
        'resources/css/libs/nouislider.css',
        'resources/css/libs/ion.rangeSlider.css',
        'resources/css/libs/fancybox.min.css'
    ], 'public/css/libs.css').scripts([
    'resources/js/libs/jquery-2.0.0.min.js',
    'resources/js/libs/bootstrap.bundle.min.js',
    'resources/js/libs/owl.carousel.min.js',
    'resources/js/libs/script.js',
    'resources/js/libs/nouislider.js',
    'resources/js/libs/ion.rangeSlider.js',
    'resources/js/libs/fancybox.min.js'
], 'public/js/libs.js');


mix.copy('node_modules/tinymce/skins', 'public/js/skins');

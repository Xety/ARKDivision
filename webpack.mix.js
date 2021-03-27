const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | WebPack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    node: {
        console: true
    }
});

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
require('./webpack.sass.mix.js');
require('./webpack.js.mix.js');

mix.scripts([
        'resources/assets/js/libs/jquery.min.js',
        'resources/assets/js/libs/jquery.easing.min.js',
        'resources/assets/js/libs/tether.min.js',
        'resources/assets/js/libs/bootstrap.min.js',
        'resources/assets/js/libs/jasny-bootstrap.min.js',
        'resources/assets/js/libs/prism.min.js',
        'resources/assets/js/libs/scrollup.min.js',
        'resources/assets/js/libs/raphael.min.js',
        'resources/assets/js/libs/morris.min.js',
        'resources/assets/js/libs/jquery-jvectormap.min.js',
        'resources/assets/js/libs/jquery-jvectormap-world-merc-en.min.js',
    ], 'public/js/lib.min.js')
    .scripts([
        'resources/assets/js/highlight/highlight.js',
    ], 'public/js/highlight.min.js')
    .scripts([
        //'resources/assets/js/donation/jquery-3.4.1.slim.min.js',
        //'resources/assets/js/donation/popper.min.js',
        //'resources/assets/js/donation/bootstrap.min.js',
        'resources/assets/js/donation/bootstrap-select.min.js',
        'resources/assets/js/donation/bootstrap-slider.min.js',
    ], 'public/js/donation/donation.min.js')
    .styles([
        //'resources/assets/css/donation/bootstrap.min.css',
        'resources/assets/css/donation/bootstrap-select.min.css',
        'resources/assets/css/donation/bootstrap-slider.min.css'
    ], 'public/css/donation/donation.lib.min.css')
    .copyDirectory('resources/assets/music', 'public/music')
    .copyDirectory('resources/assets/images', 'public/images')
    .copyDirectory('resources/assets/fonts', 'public/fonts')
    .copyDirectory('resources/assets/editor-md', 'public/editor-md')
    .version();

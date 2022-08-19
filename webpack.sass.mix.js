const mix = require('laravel-mix');

mix.sass('resources/assets/sass/division.scss', 'public/css/division.min.css')
    .sass('resources/assets/sass/admin/division.admin.scss', 'public/css/division.admin.min.css')
    .version();

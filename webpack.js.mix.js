const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | WebPack Configuration
 |--------------------------------------------------------------------------
 */
mix.webpackConfig({
    resolve: {
        extensions: ['.ts']
    },
    module: {
        rules: [
            {
                test: /\.ts$/,
                loader: 'ts-loader'
            }
        ]
    }
});

mix.js([
        'resources/assets/js/division.admin.js',
        'resources/assets/ts/Division.admin.ts'
    ], 'public/js/division.admin.min.js').vue()
    .js([
        'resources/assets/js/division.js',
        'resources/assets/ts/Division.ts'
    ], 'public/js/division.min.js').vue()
    .version();

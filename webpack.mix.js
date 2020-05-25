const mix = require('laravel-mix')
const path = require('path')

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

mix.js('resources/js/admin/app.js', 'public/js/admin')
mix.less('resources/js/admin/less/app.less', 'public/css/admin')
mix.css('resources/js/common/less/bootstrap-utility.css', 'public/css')

mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js')
        }
    },
    output: {
        chunkFilename: 'js/admin/chunk/[id].[contenthash].js'
    }
});

if (mix.inProduction()) {
    mix.version();
}

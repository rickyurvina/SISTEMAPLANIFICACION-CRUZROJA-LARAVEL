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

mix
    // .copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce')

    // vendors
    .copy('node_modules/quill/dist', 'public/vendor/quill', false)
    .copy('node_modules/echarts/dist', 'public/vendor/echarts', false)

    // Template assets
    .copy('resources/assets/vendor', 'public/vendor')
    .copy('resources/assets/img', 'public/img')

    // Web assets
    .copy('resources/assets/css/app.css', 'public/css')
    .js('resources/assets/js/app.js', 'public/js');
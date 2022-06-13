const { js } = require('laravel-mix');
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

mix.js('resources/js/app.js', 'public/js')
    .js([
        'resources/js/Get_allRow.js',
        'resources/js/Send_Row.js',
        'resources/js/Create_thread',
        'resources/js/Delete_thread',
        'resources/js/Edit_thread',
        'resources/js/Delete_message',
        'resources/js/Restore_message'
    ], 'public/js/app_jquery.js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ])
    .postCss('resources/css/welcome.css', 'public/css/design.css')
    .postCss('resources/css/normalize.css', 'public/css/design.css');

if (mix.inProduction()) {
    mix.version();
}

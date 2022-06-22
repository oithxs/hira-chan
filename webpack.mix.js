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
        'resources/js/hub/Create_thread.js',
        'resources/js/hub/Delete_thread.js',
        'resources/js/hub/Edit_thread.js',
        'resources/js/keiziban/Delete_message.js',
        'resources/js/keiziban/Get_allRow.js',
        'resources/js/keiziban/Restore_message.js',
        'resources/js/keiziban/Send_Row.js',
        'resources/js/mypage/SelectPageThema.js',
        'resources/js/dashboard/Create_thread.js'
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

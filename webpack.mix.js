const { js, babelConfig } = require('laravel-mix');
const mix = require('laravel-mix');
const glob = require('glob');

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
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

glob.sync('resources/js/*/*.js').map(function (file) {
    mix.js(file, 'public/js/app_jquery.js')
});

glob.sync('resources/css/default/*/*.css').map(function (file) {
    mix.postCss(file, 'public/css/design.css')
});

glob.sync('resources/css/dark/*/*.css').map(function (file) {
    mix.postCss(file, 'public/css/design-dark.css')
});

glob.sync('resources/css/errors/*.css').map(function (file) {
    mix.postCss(file, 'public/css/design-error.css')
});

if (mix.inProduction()) {
    mix.version();
}

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

if (mix.inProduction()) {
    mix.options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: true
                }
            }
        }
    });
    mix.js('resources/js/app.js', 'public/js')
        .js('resources/js/pdd.js', 'public/js')
        .vue()
        .postCss("resources/css/app.css", "public/css", [
            require("tailwindcss"),
            require('autoprefixer'),
        ]);

} else {

    mix.js('resources/js/app.js', 'public/js')
        .copy("resources/js/pdd.js", "public/js")
        .vue()
        .postCss("resources/css/app.css", "public/css", [
            require("tailwindcss"),
            require('autoprefixer'),
        ]);
}

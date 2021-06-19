const mix = require('laravel-mix');
mix.disableNotifications();

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
    .js('resources/js/dashboard.js', 'public/js')
    .js('resources/js/project/index.js', 'public/js/project')
    .js('resources/js/project/create.js', 'public/js/project')
    .js('resources/js/project/show.js', 'public/js/project')
    .js('resources/js/project/show_tasks.js', 'public/js/project')
    .js('resources/js/project/show_files.js', 'public/js/project')
    .js('resources/js/project/show_file_view.js', 'public/js/project')
    .js('resources/js/project/show_message.js', 'public/js/project')
    .sass('resources/scss/app.scss', 'public/css');

var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.styles([
        '/public/semantic/container.css',
        '/public/semantic/transition.css',
        '/public/semantic/icon.css',
        '/public/semantic/popup.css',
        '/public/semantic/dropdown.css',
        '/public/semantic/divider.css',
        '/public/booking/css/style.css',
        '/public/booking/css/css3nav/styles.css'
    ],'./public/booking/css/styles.min.css','.');



    mix.scripts(
        (['/public/semantic/transition.min.js',
          '/public/js/parallax/parallax.min.js',
        ]),'./public/booking/js/all.min.js','.');

});


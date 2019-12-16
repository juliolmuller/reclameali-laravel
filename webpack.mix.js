const mix = require('laravel-mix')

mix
  .js('resources/scripts/main.js', 'public/js/app.js')
  .sass('resources/styles/main.scss', 'public/css/app.css')

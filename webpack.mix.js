const mix = require('laravel-mix')

mix
  .sass('resources/styles/main.scss', 'public/css/app.css')
  .js('resources/scripts/main.js', 'public/js/app.js')
  .extract([
    'jquery',
    'popper.js',
    'bootstrap',
    'jquery-mask-plugin',
    '@chenfengyuan/datepicker',
    'toastr',
    'vue'
  ])


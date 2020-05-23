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

mix.scripts([
	'resources/js/jquery-3.2.1.min.js',
	'resources/js/popper.min.js',
	'resources/js/bootstrap.bundle.js',
	'resources/js/sweetalert.min.js',
	'resources/js/select2.full.js',
	'resources/js/summernote-bs4.js',
	'resources/js/jquery.form.js',
	'resources/js/bootstrap-datepicker.js',
	'resources/js/typeahead.bundle.js',
	'resources/js/app.js'
	], 'public/js/app.js')
   .sass('resources/scss/app.scss', 'public/css/app.css')
   .sass('resources/scss/admin.scss', 'public/css/admin.css')
   .scripts([
	'resources/js/jquery-3.2.1.min.js',
	'resources/js/popper.min.js',
	'resources/js/bootstrap.bundle.js',
	'resources/js/sweetalert.min.js',
	'resources/js/summernote-bs4.js',
	'resources/js/bootstrap-datepicker.js',
	'resources/js/chart.js',
	'resources/js/admin.js'
	], 'public/js/admin.js')
   .version();

mix.copy('resources/scss/flag-icon-css/flags/4x3/*', 'public/images/');

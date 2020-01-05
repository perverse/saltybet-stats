const mix = require('laravel-mix');
const webpack = require('./webpack.config');

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
/*
Mix.listen('configReady', webpackConfig => {
   // Exclude vuetify folder from default sass/scss rules
   const sassConfig = webpackConfig.module.rules.find(
     rule =>
       String(rule.test) ===
       String(/\.sass$/)
   );
 
   const scssConfig = webpackConfig.module.rules.find(
     rule =>
       String(rule.test) ===
       String(/\.scss$/)
   );
 
   sassConfig.exclude.push(path.resolve(__dirname, 'node_modules/vuetify'))
   scssConfig.exclude.push(path.resolve(__dirname, 'node_modules/vuetify'))
 });
*/
mix.js('resources/js/app.js', 'public/js')
   .webpackConfig(Object.assign(webpack))
   .sourceMaps();

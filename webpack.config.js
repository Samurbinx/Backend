const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .addEntry('editpiece', './assets/js/editpiece.js')
    .addEntry('newpiece', './assets/js/newpiece.js')
    .addStyleEntry('styles', './assets/css/general/styles.css')
    .addStyleEntry('buttons', './assets/css/general/buttons.css')
    .addStyleEntry('forms', './assets/css/general/forms.css')
    .addStyleEntry('tables', './assets/css/general/tables.css')
    .addStyleEntry('page', './assets/css/components/page.css')
    .addStyleEntry('artwork', './assets/css/components/artwork.css')
    .addStyleEntry('piece', './assets/css/components/piece.css')
    .addStyleEntry('work', './assets/css/components/work.css')
    .addStyleEntry('material', './assets/css/components/material.css')
    .addStyleEntry('user', './assets/css/components/user.css')
    .addStyleEntry('order', './assets/css/components/order.css')
    .addStyleEntry('login', './assets/css/components/login.css')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader();

module.exports = Encore.getWebpackConfig();

// webpack.config.js
const Encore = require('@symfony/webpack-encore');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    .addEntry('js/custom', './build/js/custom.js')

    .addStyleEntry('css/custom', ['./build/css/custom.css'])

    // uncomment this if you want use jQuery in the following example
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

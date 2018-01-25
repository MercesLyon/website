var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .addEntry('scripts', './assets/js/script.js')
    .addStyleEntry('styles', './assets/scss/style.scss')
    .createSharedEntry('vendor', [
        'bootstrap'
    ])
    .enableSassLoader()
    .autoProvidejQuery()
    .autoProvideVariables({'Popper': ['popper.js', 'default']})
    .enableSourceMaps(!Encore.isProduction())
    .configureBabel(function (babelConfig) {
        babelConfig.presets.push('es2015')
    })
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();

var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
     .addEntry('js/jquery', './assets/js/jquery.js/jquery.min.js')
     .addEntry('js/boot', './assets/js/bootstrap.bundle.js/bootstrap.bundle.min.js')
     .addStyleEntry('css/app', './assets/css/style.css')
     .addStyleEntry('css/article', './assets/css/article.css')
     .addStyleEntry('css/boot', './assets/css/bootstrap.css/bootstrap.min.css')

    // uncomment if you use Sass/SCSS files
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

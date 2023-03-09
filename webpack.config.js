const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/app.js')
    .addEntry('admin-app', './assets/admin-app.js')

    .splitEntryChunks()

    .enableSingleRuntimeChunk()

    .cleanupOutputBeforeBuild()

    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    .enableStimulusBridge('./assets/controllers.json')
    .enablePostCssLoader()
    .enableSassLoader()
    .autoProvidejQuery()

    .copyFiles({
        from: './assets/app',
        to: 'app/[path][name].[ext]',

        // if versioning is enabled, add the file hash too
        //to: 'images/[path][name].[hash:8].[ext]',

        // only copy files matching this pattern
        //pattern: /\.(png|jpg|jpeg)$/
    })
;

module.exports = Encore.getWebpackConfig();
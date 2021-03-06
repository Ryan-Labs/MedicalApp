var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')

    .addEntry('writeAd', './assets/js/writeAd.js')
    .addEntry('images', './assets/js/images.js')
    .addEntry('addressProvider', './assets/js/addressProvider.js')
    .addEntry('createResponse', './assets/js/createResponse.js')
    .addEntry('profileJS', './assets/js/profile.js')
    .addEntry('searchAdIndex', './assets/js/searchAdIndex.js')

    .addStyleEntry('writeAdStyle', './assets/css/writeAd.css')
    .addStyleEntry('registerStyle', './assets/css/register.scss')
    .addStyleEntry('updatePasswordStyle', './assets/css/updatePassword.scss')
    .addStyleEntry('updateMailStyle', './assets/css/updateMail.scss')
    .addStyleEntry('loginStyle', './assets/css/login.scss')
    .addStyleEntry('profileStyle', './assets/css/profile.scss')
    .addStyleEntry('resetPasswordStyle', './assets/css/resetPassword.scss')
    .addStyleEntry('resetPasswordWithTokenStyle', './assets/css/resetPasswordWithToken.scss')
    .addStyleEntry('adIndexStyle', './assets/css/adIndex.scss')
    .addStyleEntry('adShowStyle', './assets/css/adShow.scss')
    .addStyleEntry('homePageStyle', './assets/css/homePage.scss')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/admin.js')
;

module.exports = Encore.getWebpackConfig();

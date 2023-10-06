const Encore = require('@symfony/webpack-encore');

// webpack.config.js
const webpack = require('webpack');

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
    // only needed for CDN's or subdirectory deploy
    //.setManifestKeyPrefix('build/')

    .copyFiles({
        from: './assets/images',

        to: 'images/[path][name].[ext]',
    })

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/hosting', './assets/js/hosting.js')
    .addEntry('js/components/navbar', './assets/js/components/navbar.js')
    .addEntry('js/components/date_range_picker', './assets/js/components/date_range_picker.js')
    .addEntry('js/account/edit', './assets/js/account/edit.js')
    .addEntry('js/account/new_hosting', './assets/js/account/new_hosting.js')
    .addEntry('js/rentals', './assets/js/rentals.js')
    .addEntry('js/rentals_info', './assets/js/rentals_info.js')

    .addStyleEntry('css/errors/error.css', './assets/styles/css/errors/error.css')
    .addStyleEntry('css/home', './assets/styles/css/home.css')
    .addStyleEntry('css/hosting', './assets/styles/css/hosting.css')
    .addStyleEntry('css/about_us', './assets/styles/css/about_us.css')
    .addStyleEntry('css/global', './assets/styles/css/global.css')
    .addStyleEntry('css/login', './assets/styles/css/login.css')
    .addStyleEntry('css/register', './assets/styles/css/register.css')
    .addStyleEntry('css/rentals', './assets/styles/css/rentals.css')
    .addStyleEntry('css/rentals_info', './assets/styles/css/rentals_info.css')
    .addStyleEntry('css/checkout', './assets/styles/css/checkout.css')
    .addStyleEntry('css/account/home', './assets/styles/css/account/home.css')
    .addStyleEntry('css/account/edit', './assets/styles/css/account/edit.css')
    .addStyleEntry('css/account/done', './assets/styles/css/account/done.css')
    .addStyleEntry('css/account/new_hosting', './assets/styles/css/account/new_hosting.css')
    .addStyleEntry('css/account/my_hostings', './assets/styles/css/account/my_hostings.css')
    .addStyleEntry('css/components/navbar', './assets/styles/css/components/navbar.css')
    .addStyleEntry('css/components/footer', './assets/styles/css/components/footer.css')
    .addStyleEntry('css/components/loader', './assets/styles/css/components/loader.css')
    .addStyleEntry('css/components/back', './assets/styles/css/components/back.css')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    .enableReactPreset()

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

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

    // configure Babel
    // .configureBabel((config) => {
    //     config.plugins.push('@babel/a-babel-plugin');
    // })

    // enables and configure @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.23';
    })

    // enables Sass/SCSS support
    //.enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    // .enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
    .addPlugin(new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery',
        'window.jQuery': 'jquery',
    }))
    ;

module.exports = Encore.getWebpackConfig();

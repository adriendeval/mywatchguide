const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')

    /*
     * ENTRY CONFIG
     */
    .addEntry('app', './assets/app.js')

    // Optimization
    .splitEntryChunks()
    .enableSingleRuntimeChunk()

    // Clean output before build
    .cleanupOutputBeforeBuild()

    // Source maps and versioning
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    // Babel config
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = '3.38';
    })

    // PostCSS loader for Tailwind
    .enablePostCssLoader()

    // Optional: enable if you use Sass
    // .enableSassLoader()

    // Optional: enable if you use TypeScript
    // .enableTypeScriptLoader()

    // Optional: enable if you use React
    // .enableReactPreset()

    // Optional: integrity hashes for CSP
    // .enableIntegrityHashes(Encore.isProduction())

    // Optional: jQuery auto-provide
    // .autoProvidejQuery()
    ;

module.exports = Encore.getWebpackConfig();

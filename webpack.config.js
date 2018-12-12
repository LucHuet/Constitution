var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    .createSharedEntry('layout', './assets/js/layout.js')
    .addEntry('partie_react', './assets/js/partie_react.js')
    .addEntry('liste_partie_react', './assets/js/liste_partie_react.js')


    .enableBuildNotifications()
    // fixes modules that expect jQuery to be global
    .autoProvidejQuery()

    .addPlugin(new CopyWebpackPlugin([
        // copies to {output}/static
        { from: './assets/static', to: 'static' }
    ]))

    .enableSassLoader()
    .enableSourceMaps(!Encore.isProduction())
    .cleanupOutputBeforeBuild()
    .enableVersioning(Encore.isProduction())
    .enableReactPreset()
    .configureBabel((babelConfig) => {
      if (Encore.isProduction()) {
          babelConfig.plugins.push(
              'transform-react-remove-prop-types'
          );
      }
      babelConfig.plugins.push('transform-object-rest-spread');
    })
;

// export the final configuration
module.exports = Encore.getWebpackConfig();

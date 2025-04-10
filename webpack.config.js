const Encore = require('@symfony/webpack-encore');

Encore
.setOutputPath('public/build/')
.setPublicPath('/build')
.addEntry('app', './assets/app.js')
.enableStimulusBridge('./assets/controllers.json')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .enablePostCssLoader()
    .enableTypeScriptLoader()
    .autoProvidejQuery()
    .configureBabel(null) // Désactive la configuration Babel par défaut d'Encore
;


module.exports = {
    entry: './src/index.js',  // Chemin vers le fichier que tu viens de créer
    output: {
      filename: 'main.js',  // Nom du fichier de sortie compilé
      path: __dirname + '/dist',  // Dossier de destination
    },
    mode: 'development',  // Utilise 'development' ou 'production'
  };
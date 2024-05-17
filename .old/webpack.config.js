const Encore = require('@symfony/webpack-encore');

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
  // .setManifestKeyPrefix('build/')

  /*
   * ENTRY CONFIG
   *
   * Each entry will result in one JavaScript file (e.g. app.js)
   * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
   */
  .addEntry('app', './assets/app.js')
  // home page
  .addEntry('home_page', './assets/pages/home_page/index.js')
  // global
  .addEntry('login', './assets/pages/login/index.js')
  // patient
  .addEntry('patient_register', './assets/pages/patient/register/index.js')
  .addEntry('patient_dashboard', './assets/pages/patient/dashboard/index.js')
  .addEntry('patient_appointment', './assets/pages/patient/appointment/index.js')
  .addEntry('patient_settings', './assets/pages/patient/settings/index.js')
  .addEntry('patient_chat', './assets/pages/patient/chat/index.js')
  .addEntry('patient_particular_chat', './assets/pages/patient/particular_chat/index.js')
  .addEntry('patient_documents', './assets/pages/patient/documents/index.js')
  // doctor
  .addEntry('doctor_dashboard', './assets/pages/doctor/dashboard/index.js')
  .addEntry('doctor_documents', './assets/pages/doctor/documents/index.js')
  .addEntry('doctor_chats', './assets/pages/doctor/chats/index.js')
  .addEntry('doctor_appointments', './assets/pages/doctor/appointments/index.js')
  .addEntry('doctor_settings', './assets/pages/doctor/settings/index.js')
  .addEntry('doctor_register', './assets/pages/doctor/register/index.js')
  .addEntry('doctor_particular_chat', './assets/pages/doctor/particular_chat/index.js')
  // receptionist
  .addEntry('receptionist_dashboard', './assets/pages/receptionist/dashboard/index.js')
  .addEntry('receptionist_register_management', './assets/pages/receptionist/register_management/index.js')
  .addEntry('receptionist_appointment_management', './assets/pages/receptionist/appointment_management/index.js')
  .addEntry('receptionist_settings', './assets/pages/receptionist/settings/index.js')
  // management
  .addEntry('management_dashboard', './assets/pages/management/dashboard/index.js')
  .addEntry('management_statistics', './assets/pages/management/statistics/index.js')
  .addEntry('management_settings', './assets/pages/management/settings/index.js')

  // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
  .splitEntryChunks()

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

  .configureBabel((config) => {
    config.plugins.push('@babel/plugin-proposal-class-properties');
  })

  // enables @babel/preset-env polyfills
  .configureBabelPresetEnv((config) => {
    config.useBuiltIns = 'usage';
    config.corejs = 3;
  })

  // enables Sass/SCSS support
  .enableSassLoader()

  // uncomment if you use TypeScript
  .enableTypeScriptLoader()

  // uncomment if you use React
  // .enableReactPreset()
  .enableVueLoader(() => {
  }, {
    runtimeCompilerBuild: false,
  })

// uncomment to get integrity="..." attributes on your script & link tags
// requires WebpackEncoreBundle 1.4 or higher
// .enableIntegrityHashes(Encore.isProduction())

// uncomment if you're having problems with a jQuery plugin
// .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();

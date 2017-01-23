// This is a karma config file. For more details see
//   http://karma-runner.github.io/0.13/config/configuration-file.html
// we are also using it with karma-webpack
//   https://github.com/webpack/karma-webpack
require('es6-promise/auto')
const webpack = require('./webpack.config')

webpack.resolve.alias = {
  'vue$': 'vue/dist/vue.common.js'
}

module.exports = function karmaConfig (config) {
  config.set({
    // to run in additional browsers:
    // 1. install corresponding karma launcher
    //    http://karma-runner.github.io/0.13/config/browsers.html
    // 2. add it to the `browsers` array below.
    browsers: ['PhantomJS'],
    frameworks: ['mocha', 'chai-dom', 'sinon-chai'],
    reporters: ['spec', 'coverage'],
    files: ['./index.js'],
    preprocessors: {
      './index.js': ['webpack', 'sourcemap']
    },
    webpack: webpack,
    webpackMiddleware: {
      noInfo: true
    },
    client: {
      chai: {
        includeStack: true
      }
    },
    coverageReporter: {
      dir: '../reports/unit/karma',
      reporters: [
        { type: 'lcov', subdir: '.' },
        { type: 'text-summary' }
      ]
    }
  })
}

// -------------------

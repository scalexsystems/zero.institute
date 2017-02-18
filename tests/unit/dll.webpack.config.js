const path = require('path')
const webpack = require('webpack')

const root = path.resolve(__dirname)
const build = path.resolve(root, 'dist')

exports.entry = {
  zero: [
    'mocha/mocha.js',
    'vue/dist/vue.common.js',
    'chai',
    'core-js/library',
    'url',
    'sockjs-client',
    'vue-style-loader/addStyles.js',
    'style-loader/addStyles.js',
    'css-loader!mocha-css'
  ]
}

exports.devtool = '#source-map'

exports.output = {
  path: build,
  filename: 'zero.dll.js',
  library: 'zero'
}

exports.plugins = [
  new webpack.DllPlugin({
    name: 'zero',
    path: path.join(build, 'zero.json')
  })
]

exports.performance = { hints: false }

const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const config = require('../../webpack.config')

const projectRoot = path.resolve(__dirname, '../../resources/assets/app/')

const resolve = config.resolve


module.exports = merge(
  {
    module: {
      rules: config.module.rules
    }
  },
  {
    module: {
      rules: [
        {
          test: /\.js$/,
          loader: 'isparta-loader',
          include: [projectRoot],
          enforce: 'pre'
        }
      ]
    },

    resolve: {
      extensions: ['.js', '.vue', '*'],
      alias: {
        'app': projectRoot,
        'vue$': 'vue/dist/vue.common.js',
        'util$': path.join(__dirname, 'util.js')
      }
    },

    devtool: '#inline-source-map',

    plugins: [
      new webpack.DefinePlugin({
        'process.env': '"testing"'
      })
    ]
  }
)

delete module.exports.entry

module.exports.module.rules.some(function (rule, i) {
  if (rule.loader === 'vue-loader') {
    rule.options.loaders.js = 'isparta-loader!' + rule.options.loaders.js
  }
})

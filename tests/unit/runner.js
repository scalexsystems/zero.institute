const path = require('path')
const fs = require('fs')
const webpack = require('webpack')
const plugins = {
  html: require('html-webpack-plugin'),
  dashboard: require('webpack-dashboard/plugin'),
  asset: require('add-asset-html-webpack-plugin')
}

const dir = {
  tests: path.resolve(__dirname),
  build: path.resolve(__dirname, 'dist'),
  root: path.resolve(__dirname, '../..'),
  app: path.resolve(__dirname, '../../resources/assets/app/')
}

if (!fs.existsSync(path.join(dir.build, 'zero.dll.js'))) {
  console.log('The DLL manifest is missing. Please run `yarn build:dll`.')
  process.exit(0)
}

exports.entry = {
  tests: [path.resolve(dir.tests, 'visual.js')]
}

exports.output = {
  path: dir.build,
  filename: '[name].js',
  chunkFilename: '[id].js'
}

exports.resolve = {
  extensions: ['.js', '.vue', 'css'],
  alias: {
    'vue$': 'vue/dist/vue.common.js',
    app: dir.app,
    'util$': path.join(dir.tests, 'util.js')
  }
}

exports.module = {}

exports.module.rules = [
  {
    test: /.vue$/,
    loader: 'vue-loader',
    options: {
      loaders: {
        js: 'babel-loader',
        scss: 'vue-style-loader!css-loader!sass-loader',
      },

      cssModules: {
        localIdentName: '[name]_[local]',
        camelCase: true,
      },

      postcss: [require('postcss-cssnext')()]
    }
  },
  {
    test: /.js$/,
    loader: 'babel-loader',
    exclude: /node_modules/
  },
  {
    test (filename) {
      if (/fontawesome-webfont/.test(filename)) return false

      return /\.(png|jpg|gif|svg)$/.test(filename)
    },
    loader: 'file-loader',
    options: {
      name: 'img/[path][name].[ext]?[hash]',
      publicPath: '/'
    }
  }
]

exports.plugins = [
  new webpack.DllReferencePlugin({
    context: dir.root,
    manifest: require(path.join(dir.build, 'zero.json'))
  }),

  new plugins.html({ chunkSortMode: 'dependency' }),

  new plugins.asset({
    filepath: require.resolve(path.join(dir.build, 'zero.dll.js'))
  }),

  new webpack.optimize.CommonsChunkPlugin({
    name: 'vendor',
    minChunks (module, count) {
      return (
        module.resource && /\.js$/.test(module.resource) &&
        module.resource.indexOf(path.join(dir.root, 'node_modules'))
      )
    }
  }),

  new webpack.optimize.CommonsChunkPlugin({
    name: 'manifest',
    chunks: ['vendor']
  })
]

exports.devServer = {
  inline: true,
  stats: {
    colors: true,
    chunks: false,
    cached: false
  },
  contentBase: dir.build
}

exports.devtool = '#eval-source-map'

exports.performance = { hints: false }

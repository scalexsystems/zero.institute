var path = require('path')
var webpack = require('webpack')
var Mix = require('laravel-mix').config
var plugins = require('laravel-mix').plugins

/*
 |--------------------------------------------------------------------------
 | Mix Initialization
 |--------------------------------------------------------------------------
 |
 | As our first step, we'll require the project's Laravel Mix file
 | and record the user's requested compilation and build steps.
 | Once those steps have been recorded, we may get to work.
 |
 */

Mix.initialize()

/*
 |--------------------------------------------------------------------------
 | Webpack Context
 |--------------------------------------------------------------------------
 |
 | This prop will determine the appropriate context, when running Webpack.
 | Since you have the option of publishing this webpack.config.js file
 | to your project root, we will dynamically set the path for you.
 |
 */

module.exports.context = Mix.Paths.root()

/*
 |--------------------------------------------------------------------------
 | Webpack Entry
 |--------------------------------------------------------------------------
 |
 | We'll first specify the entry point for Webpack. By default, we'll
 | assume a single bundled file, but you may call Mix.extract()
 | to make a separate bundle specifically for vendor libraries.
 |
 */

module.exports.entry = Mix.entry()

if (Mix.js.vendor) {
  module.exports.entry.vendor = Mix.js.vendor
}

/*
 |--------------------------------------------------------------------------
 | Webpack Output
 |--------------------------------------------------------------------------
 |
 | Webpack naturally requires us to specify our desired output path and
 | file name. We'll simply echo what you passed to with Mix.js().
 | Note that, for Mix.version(), we'll properly hash the file.
 |
 */

module.exports.output = {
  path: Mix.hmr ? '/' : Mix.publicPath,
  filename: Mix.inProduction ? '[name].[hash].js' : '[name].js',
  publicPath: Mix.hmr ? 'http://localhost:8080/' : './'
}

/*
 |--------------------------------------------------------------------------
 | Rules
 |--------------------------------------------------------------------------
 |
 | Webpack rules allow us to register any number of loaders and options.
 | Out of the box, we'll provide a handful to get you up and running
 | as quickly as possible, though feel free to add to this list.
 |
 */

const extractAppCss = new plugins.ExtractTextPlugin(Mix.inProduction ? '/css/app.[contenthash].css' : '/css/app.css')

module.exports.module = {
  rules: [
    {
      test: /\.vue$/,
      loader: 'vue-loader',
      options: {
        loaders: {
          js: 'babel-loader' + Mix.babelConfig(),
          scss: Mix.vueExtract ? 'vue-style-loader!css-loader!sass-loader' : extractAppCss.extract({
            loader: 'css-loader!sass-loader',
            fallbackLoader: 'vue-style-loader'
          })
        },

        cssModules: {
          localIdentName: '[path][name]---[local]---[hash:base64:5]',
          camelCase: true
        },

        postcss: [
          require('autoprefixer')
        ],
        sourceMaps: true
      }
    },

    {
      test: /\.js$/,
      exclude: /(node_modules|bower_components)/,
      loader: 'babel-loader' + Mix.babelConfig()
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
    },

    {
      test: /(fontawesome-webfont\.svg$)|\.(woff2?|ttf|eot|otf)$/,
      loader: 'file-loader',
      options: {
        name: '/fonts/[name].[ext]?[hash]',
        publicPath: '../'
      }
    }
  ]
}

if (Mix.preprocessors) {
  Mix.preprocessors.forEach(toCompile => {
    const extractPlugin = new plugins.ExtractTextPlugin(
            Mix.cssOutput(toCompile)
        )

    module.exports.module.rules.push({
      test: new RegExp(toCompile.src.file),
      loader: extractPlugin.extract({
        fallbackLoader: 'style-loader',
        use: [
          'css-loader',
          'postcss-loader',
          'resolve-url-loader',
          (Mix.cssPreprocessor === 'sass') ? 'sass-loader?sourceMap' : 'less-loader'
        ]
      })
    })

    module.exports.plugins = (module.exports.plugins || []).concat(extractPlugin)
  })
}

/*
 |--------------------------------------------------------------------------
 | Resolve
 |--------------------------------------------------------------------------
 |
 | Here, we may set any options/aliases that affect Webpack's resolving
 | of modules. To begin, we will provide the necessary Vue alias to
 | load the Vue common library. You may delete this, if needed.
 |
 */

module.exports.resolve = {
  extensions: ['*', '.js', '.vue'],
  modules: [path.resolve('node_modules')]
}

/*
 |--------------------------------------------------------------------------
 | Stats
 |--------------------------------------------------------------------------
 |
 | By default, Webpack spits a lot of information out to the terminal,
 | each you time you compile. Let's keep things a bit more minimal
 | and hide a few of those bits and pieces. Adjust as you wish.
 |
 */

module.exports.stats = {
  hash: true,
  version: true,
  timings: true,
  children: true,
  errors: true
}

module.exports.performance = {
  hints: false
}

/*
 |--------------------------------------------------------------------------
 | Webpack Dev Server Configuration
 |--------------------------------------------------------------------------
 |
 | If you want to use that flashy hot module replacement feature, then
 | we've got you covered. Here, we'll set some basic initial config
 | for the Node server. You very likely won't want to edit this.
 |
 */
module.exports.devServer = {
  historyApiFallback: true,
  contentBase: path.resolve(__dirname, 'public'),
  // compress: true,
  publicPath: 'http://localhost:8080/',
  quiet: false
}

if (Mix.hmr) {
  exports.output.hotUpdateChunkFilename = '/hot/[id].[hash].hot-update.js'
  exports.output.hotUpdateMainFilename = '/hot/[hash].hot-update.json'
}

/*
 |--------------------------------------------------------------------------
 | Plugins
 |--------------------------------------------------------------------------
 |
 | Lastly, we'll register a number of plugins to extend and configure
 | Webpack. To get you started, we've included a handful of useful
 | extensions, for versioning, OS notifications, and much more.
 |
 */

module.exports.plugins = (module.exports.plugins || []).concat([
  new webpack.ProvidePlugin({
    jQuery: 'jquery',
    $: 'jquery',
    jquery: 'jquery'
  }),

  new plugins.FriendlyErrorsWebpackPlugin(),

  new plugins.StatsWriterPlugin({
    filename: 'mix-manifest.json',
    transform (stats) {
      const flattenedPaths = [].concat.apply([], Object.values(stats.assetsByChunkName));

      const manifest = flattenedPaths.reduce((manifest, path) => {
          let original = path.replace(/\.([^\.]+)(\..+)/, '$2');

          manifest[original] = path;

          return manifest;
      }, {});

      return JSON.stringify(manifest, null, 2);
    }
  }),

  extractAppCss,

  new plugins.WebpackMd5HashPlugin(),

  new webpack.LoaderOptionsPlugin({
    minimize: Mix.inProduction,
    debug: false,
    options: {
      postcss: [
        require('autoprefixer')
      ],
      context: __dirname,
      output: { path: './' }
    }
  })
])

if (Mix.notifications) {
  module.exports.plugins.push(
        new plugins.WebpackNotifierPlugin({
          title: 'Laravel Mix',
          alwaysNotify: true,
          contentImage: 'node_modules/laravel-mix/icons/laravel.png'
        })
    )
}

if (Mix.combine || Mix.minify) {
  module.exports.plugins.push(
        new plugins.WebpackOnBuildPlugin(() => {
          Mix.concatenateAll().minifyAll()
        })
    )
}

if (Mix.copy) {
  Mix.copy.forEach(copy => {
    module.exports.plugins.push(
            new plugins.CopyWebpackPlugin([copy])
        )
  })
}

if (Mix.js.vendor) {
  module.exports.plugins.push(
        new webpack.optimize.CommonsChunkPlugin({
          names: ['vendor', 'manifest']
        })
    )
}

if (Mix.inProduction) {
  module.exports.plugins = module.exports.plugins.concat([
    new webpack.DefinePlugin({
      'process.env': {
        NODE_ENV: '"production"'
      }
    }),

    new webpack.optimize.UglifyJsPlugin({
      debug: false,
      beautify: false,
      mangle: {
          screw_ie8: true
      },
      compress: {
          screw_ie8: true,
          warnings: false
      },
      output: {
        comments: false
      },
      sourceMap: true
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor',
      minChunks: function (module, count) {
        // any required modules inside node_modules are extracted to vendor
        return (
              module.resource &&
              /\.js$/.test(module.resource) &&
              module.resource.indexOf(
                path.join(__dirname, 'node_modules')
              ) === 0
        )
      }
    }),

        // extract webpack runtime and module manifest to its own file in order to
        // prevent vendor hash from being updated whenever app bundle is updated
    new webpack.optimize.CommonsChunkPlugin({
      name: 'manifest',
      chunks: ['vendor']
    })
  ])
}

/*
 |--------------------------------------------------------------------------
 | Mix Finalizing
 |--------------------------------------------------------------------------
 |
 | Now that we've declared the entirety of our Webpack configuration, the
 | final step is to scan for any custom configuration in the Mix file.
 | If mix.webpackConfig() is called, we'll merge it in, and build!
 |
 */
Mix.finalize(module.exports)


/*
 |--------------------------------------------------------------------------
 | Devtool
 |--------------------------------------------------------------------------
 |
 | Sourcemaps allow us to access our original source code within the
 | browser, even if we're serving a bundled script or stylesheet.
 | You may activate sourcemaps, by adding Mix.sourceMaps().
 |
 */

module.exports.devtool = Mix.inProduction ? '#source-map' : '#inline-source-map'
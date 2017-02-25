let path = require('path');
let webpack = require('webpack');
let Mix = require('laravel-mix').config;
let plugins = require('laravel-mix').plugins;
plugins.BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

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

Mix.initialize();

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

module.exports.context = Mix.Paths.root();

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

module.exports.entry = Mix.entry();

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

module.exports.output = Mix.output();
module.exports.output.publicPath = Mix.isHmr ? 'http://localhost:8080/' : '/app/'
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

let vueExtractTextPlugin = false;

if (Mix.options.extractVueStyles) {
  vueExtractTextPlugin = Mix.vueExtractTextPlugin();

  module.exports.plugins = (module.exports.plugins || []).concat(vueExtractTextPlugin);
}

module.exports.module = {
  rules: [
    {
      test: /\.vue$/,
      loader: 'vue-loader',
      options: {
        loaders: Mix.options.extractVueStyles ? {
              js: ['babel-loader' + Mix.babelConfig(), 'strip-loader?strip[]=this.$debug'],
              scss: vueExtractTextPlugin.extract({
                use: 'css-loader!sass-loader',
                fallback: 'vue-style-loader'
              }),
            } : {
              js: 'babel-loader' + Mix.babelConfig(),
              scss: 'vue-style-loader!css-loader!sass-loader'
            },

        cssModules: {
          localIdentName: '[name]---[local]---[hash:base64:5]',
          camelCase: true
        },

        postcss: Mix.options.postCss,

        sourceMaps: true
      }
    },

    {
      test: /\.jsx?$/,
      exclude: /(node_modules|bower_components)/,
      use: 'babel-loader'
    },

    {
      test (filename) {
        if (/node_modules/.test(filename)) return false

        return /\.(png|jpg|gif|svg)$/.test(filename)
      },
      loader: 'file-loader',
      options: {
        name: 'images/[path][name].[ext]?[hash]',
        publicPath: Mix.resourceRoot
      }
    },

    {
      test (filename) {
        if (/node_modules/.test(filename) && /\.svg$/.test(filename)) return true

        return /\.(woff2?|ttf|eot|otf)$/.test(filename)
      },
      loader: 'file-loader',
      options: {
        name: 'fonts/[name].[ext]?[hash]',
        publicPath: Mix.resourceRoot
      }
    }
  ]
};

if (Mix.preprocessors) {
  Mix.preprocessors.forEach(preprocessor => {
    module.exports.module.rules.push(preprocessor.rules());

    module.exports.plugins = (module.exports.plugins || []).concat(preprocessor.extractPlugin);
  });
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
  extensions: ['*', '.js', '.jsx', '.vue']
};

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
  hash: false,
  version: false,
  timings: false,
  children: false,
  errors: false
};

process.noDeprecation = true;

module.exports.performance = { hints: false };

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

module.exports.devtool = (Mix.inProduction ? '#source-map' : '#inline-source-map');

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
  noInfo: true,
  compress: true,
  quiet: true
};

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
    jquery: 'jquery',
    Tether: 'tether',
    io: 'socket.io-client'
  }),

  new plugins.FriendlyErrorsWebpackPlugin(),

  new plugins.StatsWriterPlugin({
    filename: '../mix-manifest.json',
    transform (paths, options) {
      const result = JSON.parse(Mix.manifest.transform.call(Mix.manifest, paths, options))

      Object.keys(result).forEach(key => {
        result[key] = '/app' + result[key]
      })

      return JSON.stringify(result, null, 2)
    },
  }),

  new plugins.WebpackMd5HashPlugin(),

  new webpack.LoaderOptionsPlugin({
    minimize: Mix.inProduction,
    options: {
      postcss: Mix.options.postCss,
      context: __dirname,
      output: { path: './' }
    }
  }),

  new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
]);

if (Mix.browserSync) {
  module.exports.plugins.push(
      new plugins.BrowserSyncPlugin(
          Object.assign({
            host: 'localhost',
            port: 3000,
            proxy: 'app.dev',
            files: [
              'app/**/*.php',
              'resources/views/**/*.php',
              'public/js/**/*.js',
              'public/css/**/*.css'
            ]
          }, Mix.browserSync),
          {
            reload: false
          }
      )
  );
}

if (Mix.notifications) {
  module.exports.plugins.push(
      new plugins.WebpackNotifierPlugin({
        title: 'Laravel Mix',
        alwaysNotify: true,
        contentImage: Mix.Paths.root('node_modules/laravel-mix/icons/laravel.png')
      })
  );
}

if (Mix.copy) {
  Mix.copy.forEach(copy => {
    module.exports.plugins.push(
        new plugins.CopyWebpackPlugin([copy])
    );
  });
}

if (Mix.extract) {
  const names = Mix.entryBuilder.extractions.concat([
    path.join(Mix.js.base, 'manifest').replace(/\\/g, '/')
  ])

  module.exports.plugins.push(
      new webpack.optimize.CommonsChunkPlugin({
        names: names,
        minChunks: Infinity,
        children: true
      })
  )
}

// ----- Extracting Chunks -----
exports.entry['vendor/vue'] = ['vue', 'vuex', 'vue-resource', 'vue-router']
exports.entry['vendor/bootstrap'] = ['jquery', 'bootstrap', 'tether']
exports.entry['vendor/components'] = ['bootstrap-for-vue']
exports.entry['vendor/plugins'] = ['moment', 'sifter']
exports.entry['vendor/echo'] = ['pusher-js', 'laravel-echo', 'echo-for-vue']
module.exports.plugins.push(
    new webpack.optimize.CommonsChunkPlugin({
      name: 'manifest'
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'main',
      children: true,
      minChunks: 4,
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/others',
      chunks: ['main'],
      minChunks (module) {
        return module.context && module.context.indexOf('node_modules') !== -1
      }
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/vue',
      chunks: ['main', 'vendor/bootstrap', 'vendor/components', 'vendor/echo', 'vendor/others'],
      minChunks: Infinity
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/bootstrap',
      chunks: ['main', 'vendor/echo', 'vendor/others', 'vendor/components'],
      minChunks: Infinity
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/components',
      chunks: ['main', 'vendor/echo', 'vendor/others', 'vendor/components'],
      minChunks: Infinity
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/plugins',
      chunks: ['main', 'vendor/bootstrap', 'vendor/components', 'vendor/echo', 'vendor/others'],
      minChunks: Infinity
    }),

    new webpack.optimize.CommonsChunkPlugin({
      name: 'vendor/echo',
      chunks: ['main', 'vendor/others'],
      minChunks: Infinity
    })
)

if (Mix.inProduction) {
  module.exports.plugins.push(
      new webpack.DefinePlugin({
        'process.env': {
          NODE_ENV: '"production"'
        },
        VERSION: JSON.stringify(require("package.json").version)
      }),

      new webpack.optimize.UglifyJsPlugin({
        beautify: false,
        comments: false,
        extractComments: false,
        compress: {
          warnings: false,
          drop_console: false, // Drop `console` statements
        },
        mangle: {
          except: ['$'], // Don't mangle $
          screw_ie8: true, // Don't care about IE8
          keep_fnames: true, // Don't mangle function names
        },
        sourceMap: true
      })

      // new webpack.NormalModuleReplacementPlugin(
      //     /(socket\.io-client)/,
      //     path.resolve(__dirname, 'resources/assets/app/empty.js')
      // )
  );
}

if (process.env.VIS !== undefined) {
  exports.plugins.push(new plugins.BundleAnalyzerPlugin())
}

module.exports.plugins.push(
    new plugins.WebpackOnBuildPlugin(
        stats => Mix.events.fire('build', stats)
    )
);

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
Mix.finalize(module.exports);
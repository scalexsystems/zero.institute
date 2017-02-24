/*
 * WatchTower Server (Hot Module Reload)
 * =====================================
 *
 * This file launches an hmr webpack dev server.
 */

process.env.NODE_ENV = process.env.NODE_ENV || 'development'
process.env.DEBUG = process.env.DEBUG || require('../package.json').name+'*'

const spawn = require('cross-spawn')
const fs = require('fs')
const path = require('path')
const cleanup = require('./cleanup')
const env = require('./env')
const config = require('./config')

const log = config.logger
const servers = {}
const hot = path.resolve(__dirname, '../public/hot')

cleanup(function () {
  env.cleanup()
  if (fs.existsSync(hot)) fs.unlinkSync(hot)
  if (servers.laravel) servers.laravel.kill()
  if (servers.webpack) servers.webpack.kill()
})

require('./serve').then(
  function (laravel) {
    log(`Open: ${config.laravel.address}`)
    servers.laravel = laravel
    servers.webpack = spawn(
      './node_modules/.bin/webpack-dev-server',
      ['--inline', '--hot'],
      { env: process.env, stdio: 'inherit' }
    )
  }
)

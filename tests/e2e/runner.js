process.env.NODE_ENV = 'testing'

const spawn = require('cross-spawn')
const fs = require('fs')
const touch = require('touch')
const path = require('path')
const cleanup = require('../../scripts/cleanup')
const env = require('../../scripts/env')
const config = require('../../scripts/config')

function getEnv () {
  const index = process.argv.indexOf('--env')

  if (index < 0 || process.argv.length === (index + 1)) return ['chrome']

  return process.argv[index + 1].split(',')
}

function isSingle () {
  const index = process.argv.indexOf('--test')

  if (index < 0) return []

  return process.argv.slice(index)
}

const processes = {}

// Prepare Laravel .env
env.use('testing')
env.set(env.get().replace(/^APP_URL=.*\r?\n/, `APP_URL=http://${config.laravel.address}`))

// Register cleanup function
cleanup(function () {
  env.cleanup()
  if (processes.laravel) processes.laravel.kill()
  if (processes.runner) processes.runner.kill()
})

// Define nightwatch env
const envs = getEnv()

// if (process.env.CI) {
//   envs = ['phantomjs']
// }

if (envs.indexOf('phantomjs') > -1) {
  process.env.PHANTOMJS = true
}

// Prepare database
const project = path.resolve(__dirname, '../../')
const database = path.resolve(project, 'database/database.sqlite')

if (fs.existsSync(database)) fs.unlinkSync(database)
touch.sync(database)
spawn('php', ['artisan', 'migrate', '--seed'], { stdio: 'inherit' })

// Start e2e tests
require('../../scripts/serve').then((laravel) => {
  processes.laravel = laravel
  processes.runner = spawn(
    './node_modules/.bin/nightwatch',
    ['--config', 'tests/e2e/nightwatch.conf.js', '--env', envs.join(',')].concat(isSingle()),
    { stdio: 'inherit', env: process.env }
  )
  processes.runner.on('exit', (code) => process.exit(code))
}).catch(function () {
  process.exit(5)
})

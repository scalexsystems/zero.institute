/*
 * Application Local Server
 * ========================
 *
 * This file starts a local laravel server.
 */

const spawn = require('cross-spawn')
const config = require('./config')

const log = config.logger

function serve (resolve, reject) {
  let started = false

  if (['0.0.0.0', '127.0.0.1', 'localhost'].indexOf(config.laravel.host) < 0) return resolve() // No need to serve.

  const laravel = spawn('php',
    ['artisan', 'serve', `--host=${config.laravel.host}`, `--port=${config.laravel.port}`],
    { env: process.env, shell: true }
  )

  laravel.on('exit', (code) => {
    if (!started && code !== 0) reject()
  })

  laravel.on('error', error => log(error))
  laravel.on('close', code => log(`Laravel server exited with code ${code}`))
  laravel.stderr.on('data', data => log(data.toString()))
  laravel.stdout.on('data', (data) => {
    if (started) return

    log(data.toString())

    started = true
    resolve(laravel)
  })
}

module.exports = new Promise(serve)

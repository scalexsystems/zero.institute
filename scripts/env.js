/*
 * Laravel Environment
 * ===================
 *
 * This file provides Laravel environment (.env file).
 */

const fs = require('fs')
const path = require('path')

const project = path.resolve(__dirname, '../')
const backup = path.resolve(project, '.env.backup')

/**
 * Absolute path for Laravel .env file.
 *
 * @type {string}
 * @readonly
 */
exports.path = path.resolve(project, '.env')

/**
 * Content of the Laravel .env file.
 *
 * @return {string}
 */
exports.get = function () {
  return fs.readFileSync(exports.path).toString()
}

/**
 * Update .env file with given content
 *
 * @param {string} data Content for the .env file.
 */
exports.set = function (data) {
  fs.writeFileSync(exports.path, data)
}

/**
 * Use the environment.
 *
 * @param  {sring} name Name of the environment
 */
exports.use = function (name) {
  fs.writeFileSync(exports.path, fs.readFileSync(exports.path + '.' + name))
}

/**
 * Reset .env file.
 */
exports.cleanup = function cleanup () {
  fs.writeFileSync(exports.path, fs.readFileSync(backup))
  fs.unlinkSync(backup)
}

// Backup .env file.
fs.writeFileSync(backup, exports.get())

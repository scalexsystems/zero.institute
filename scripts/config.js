/*
 * Configuration
 * =============
 *
 * This file provides development & testing environment configurations.
 */

exports.logger = require('debug')(require('../package.json').name)

exports.laravel = {
  host: process.env.ZERO_HOST || 'localhost',
  port: process.env.ZERO_PORT || 7777
}

exports.laravel.address = `${exports.laravel.host}:${exports.laravel.port}`

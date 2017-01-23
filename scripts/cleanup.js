/*
 * Process Cleanup
 * ===============
 *
 * This file provides a fluent way to exit a process.
 */

function noop () {}

module.exports = function (callback) {
  callback = callback || noop

  process.on('cleanup', callback)
  process.on('exit', () => process.emit('cleanup'))
  process.on('SIGINT', function () {
    console.log('CTRL + C ... exiting')
    process.exit(2)
  })
  process.on('uncaughtException', function (e) {
    console.log('uncaughtException ...')
    console.log(e.stack)
    process.exit(99)
  })
}

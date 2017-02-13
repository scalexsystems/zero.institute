import debug from 'debug'

export default function plugin (Vue, options = {}) {
  if (plugin.installed === true) return
  plugin.installed = true

  if (options.debug !== true) {
    Object.defineProperty(Vue.prototype, '$debug', {
      get () {
        return () => {
          // Ignore!
        }
      }
    })
  } else {
    debug.enable('app*')

    Vue.prototype.$debug = function (...args) {
      debug(`app:${this.$options.name || '< NAME THIS COMPONENT'}`)(...args)
    }
  }
}

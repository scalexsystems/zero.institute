import debug from 'debug'

export default {
  install (Vue, option) {
    Vue.prototype.$debug = function (...args) {
      if (option.debug) {
        debug(`app:${this.$options.name || '< NAME THIS COMPONENT'}`)(...args)
      }
    }
  }
}

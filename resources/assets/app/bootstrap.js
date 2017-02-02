import Vue from 'vue'
import VueResource from 'vue-resource'
import VueBootstrap from 'bootstrap-for-vue'
import Raven from 'raven-js'
import RavenVue from 'raven-js/plugins/vue'

import each from 'lodash/each'

// import VueEcho from './plugins/echo'
import VueDebug from './plugins/debug'
import components from './components'

// Bootstrap & jQuery
window.$ = window.jQuery = require('jquery')
window.Tether = require('tether')
window.io = require('socket.io-client')
require('bootstrap')

// Enable logging in production.
if (process.env.NODE_ENV === 'production') {
  Raven
      .config('https://0e3651de5e1d425da8e296428b4795ea@sentry.io/131049')
      .addPlugin(RavenVue, Vue)
      .install()
}

// Common plugins.
Vue.use(VueDebug, { debug: process.env.NODE_ENV !== 'production' })
Vue.use(VueResource)
// Vue.use(VueEcho, window.Laravel.broadcast)
Vue.use(VueBootstrap, { all: true, custom: true })

// HTTP lib config.
Vue.http.options.root = '/api'
if ('csrfToken' in window.Laravel) {
  Vue.http.headers.common['X-CSRF-Token'] = window.Laravel.csrfToken
} else if ('token' in window.Laravel) {
  Vue.http.headers.common.Authorization = `Bearer ${window.Laravel.token}`
  window.Laravel.broadcast.auth = {
    headers: { Authorization: `Bearer ${window.Laravel.token}` }
  }
}

each(components, (component, name) => Vue.component(name, component))
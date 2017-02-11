import Vue from 'vue'
import VueResource from 'vue-resource'
import VueBootstrap from 'bootstrap-for-vue'
import Raven from 'raven-js'
import RavenVue from 'raven-js/plugins/vue'

import each from 'lodash/each'

import VueEcho from './services/echo'
import VueDebug from './services/debug'
import components from './components'

// Bootstrap & jQuery
window.$ = window.jQuery = require('jquery')
window.Tether = require('tether')
window.io = require('socket.io-client')
require('bootstrap')
window.Vue = Vue

const Laravel = window.Laravel || {}

// Install plugins.
if (process.env.NODE_ENV === 'production') {
  Raven
      .config('https://0e3651de5e1d425da8e296428b4795ea@sentry.io/131049')
      .addPlugin(RavenVue, Vue)
      .install()
}
Vue.use(VueResource)
Vue.use(VueDebug, { debug: process.env.NODE_ENV !== 'production' })
Vue.use(VueEcho, Laravel.broadcast)
Vue.use(VueBootstrap, { all: true, custom: true })

// HTTP lib config.
Vue.http.options.root = '/api'
if ('csrfToken' in Laravel) {
  Vue.http.headers.common['X-CSRF-Token'] = Laravel.csrfToken
} else if ('token' in Laravel) {
  Vue.http.headers.common.Authorization = `Bearer ${Laravel.token}`

  Laravel.broadcast.auth = {
    headers: { Authorization: `Bearer ${Laravel.token}` }
  }
}

each(components, (component, name) => Vue.component(name, component))

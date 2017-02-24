import Vue from 'vue'
import VueResource from 'vue-resource'
import VueBootstrap from 'bootstrap-for-vue'
import Raven from 'raven-js'
import RavenVue from 'raven-js/plugins/vue'

import VueEcho from 'echo-for-vue'
import VueACL from './services/acl'
import VueDebug from './services/debug'
import components from './components'
import directives from './directives'

// Bootstrap & jQuery
window.$ = window.jQuery = require('jquery')
window.Tether = require('tether')
require('bootstrap')
window.Vue = Vue
window.io = (...args) => import('socket.io-client')(...args)

const Laravel = window.Laravel || {}
const dsn = process.env.NODE_ENV === 'production' ? 'https://0e3651de5e1d425da8e296428b4795ea@sentry.io/131049' : false

// Install plugins.
Raven.config(dsn).addPlugin(RavenVue, Vue).install()
Vue.use(VueResource)
Vue.use(VueDebug, { debug: process.env.NODE_ENV !== 'production' })
Vue.use(VueEcho, Laravel.broadcast)
Vue.use(VueACL)
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

Vue.use(directives)
Vue.use(components)

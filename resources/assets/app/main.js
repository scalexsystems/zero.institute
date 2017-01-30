import Vue from 'vue'
import VueResource from 'vue-resource'
import VueRouter from 'vue-router'
import each from 'lodash/each'

import VueEcho from './plugins/echo'
import VueDebug from './plugins/debug'
import * as inputs from './input'
import * as directives from './directives'
import App from './App.vue'
import store from './vuex/store'
import routerOptions from './options/router'
import apps from './options/apps'
import Raven from 'raven-js'
import RavenVue from 'raven-js/plugins/vue'

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
window.$ = window.jQuery = require('jquery')
window.Tether = require('tether')
window.io = require('socket.io-client')
require('bootstrap')

window.Vue = Vue
window.Laravel = window.Laravel || {}

if (process.env.NODE_ENV === 'production') {
  Raven
    .config('https://0e3651de5e1d425da8e296428b4795ea@sentry.io/131049')
    .addPlugin(RavenVue, Vue)
    .install()
}

Vue.use(VueDebug, { debug: process.env.NODE_ENV !== 'production' })
Vue.use(VueResource)
Vue.http.options.root = '/api'


if ('csrfToken' in window.Laravel) {
  Vue.http.headers.common['X-CSRF-Token'] = window.Laravel.csrfToken
} else if ('token' in window.Laravel) {
  Vue.http.headers.common.Authorization = `Bearer ${window.Laravel.token}`
  window.Laravel.broadcast.auth = {
    headers: { Authorization: `Bearer ${window.Laravel.token}` }
  }
}

Vue.use(VueEcho, window.Laravel.broadcast)

each(directives, (directive, name) => Vue.directive(name, directive))
each(inputs, (input, name) => Vue.component(name, input))
each(apps, app => app(Vue, { store, routes: routerOptions.routes }))

const router = new VueRouter(routerOptions)

/* eslint-disable no-new */
new Vue({
  render: h => h(App),
  store,
  router
}).$mount('#app')


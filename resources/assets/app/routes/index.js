import Vue from 'vue'
import VueRouter from 'vue-router'
import hub from './hub'

Vue.use(VueRouter)

/* Pages */
const routes = [
  ...hub
]

export default new VueRouter({
  mode: 'history',
  base: '/',
  routes
})

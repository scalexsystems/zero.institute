import Vue from 'vue'
import VueRouter from 'vue-router'
import groups from './groups'
import messages from './messages'
import people from './people'

Vue.use(VueRouter)

/* Pages */
const routes = [
  ...groups,
  ...messages,
  ...people
]

export default new VueRouter({
  mode: 'history',
  base: '/',
  routes
})

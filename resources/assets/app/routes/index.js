import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../vuex'

import attendance from './attendance'
import courses from './courses'
import finance from './finance'
import groups from './groups'
import messages from './messages'
import people from './people'
import settings from './settings'

Vue.use(VueRouter)

/* Pages */
const routes = [
  {
    name: 'home',
    path: '/',
    redirect: '/hub'
  },
  {
    name: 'hub',
    path: '/hub',
    redirect: () => {
      const groups = store.getters['groups/myGroups']

      if (groups && groups.length) {
        return `/hub/groups/${groups[0].id}`
      }

      return '/hub/groups'
    }
  },
  ...attendance,
  ...courses,
  ...finance,
  ...groups,
  ...messages,
  ...people,
  ...settings,
]

export default new VueRouter({
  mode: 'history',
  base: '/',
  routes
})

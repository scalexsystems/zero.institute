import { toInt } from '../util'

export default [
  {
    name: 'dm',
    path: '/hub/messages',
    component: require('../pages/messages/PeopleDirectory.vue')
  },
  {
    name: 'user.messages',
    path: '/hub/messages/:id',
    component: require('../pages/messages/PeopleMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'user.show',
    path: '/hub/messages/:id/show',
    component: require('../pages/messages/QuickProfile.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]

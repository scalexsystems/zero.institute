import { toInt } from '../util'

export default [
  {
    name: 'dm',
    path: '/hub/messages',
    component: () => import('../pages/messages/PeopleDirectory.vue')
  },
  {
    name: 'user.messages',
    path: '/hub/messages/:id',
    component: () => import('../pages/messages/PeopleMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'user.show',
    path: '/hub/messages/:id/show',
    component: () => import('../pages/messages/QuickProfile.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]

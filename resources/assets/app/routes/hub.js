import { toInt } from '../util'

export default [
  {
    name: 'group.index',
    path: '/hub/messages/groups',
    component: require('../pages/groups/GroupDirectory.vue')
  },
  {
    name: 'group.create',
    path: '/hub/messages/groups/create',
    component: require('../pages/groups/GroupCreate.vue')
  },
  {
    name: 'group.messages',
    path: '/hub/messages/groups/:id',
    component: require('../pages/groups/GroupMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]

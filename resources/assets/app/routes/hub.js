import { toInt } from '../util'

export default [
  {
    name: 'group.index',
    path: '/hub/messages/groups',
    component: require('../pages/messages/GroupDirectory.vue'),
  },
  {
    name: 'group.messages',
    path: '/hub/messages/groups/:id',
    components: require('../pages/messages/Group.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]
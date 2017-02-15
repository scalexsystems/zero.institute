import { toInt } from '../util'

  export default [
  {
    name: 'group.index',
    path: '/hub/groups',
    component: require('../pages/groups/GroupDirectory.vue')
  },
  {
    name: 'group.create',
    path: '/hub/groups/create',
    component: require('../pages/groups/GroupCreate.vue')
  },
  {
    name: 'group.show',
    path: '/hub/groups/:id/show',
    component: require('../pages/groups/Group.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'group.edit',
    path: '/hub/groups/:id/edit',
    component: require('../pages/groups/GroupEdit.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'group.messages',
    path: '/hub/groups/:id',
    component: require('../pages/groups/GroupMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]
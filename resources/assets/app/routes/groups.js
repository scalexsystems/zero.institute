import { toInt } from '../util'

export default [
  {
    name: 'group.index',
    path: '/hub/groups',
    component: () => import('../pages/groups/GroupDirectory.vue')
  },
  {
    name: 'group.create',
    path: '/hub/groups/create',
    component: () => import('../pages/groups/GroupCreate.vue')
  },
  {
    name: 'group.show',
    path: '/hub/groups/:id/show',
    component: () => import('../pages/groups/Group.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'group.edit',
    path: '/hub/groups/:id/edit',
    component: () => import('../pages/groups/GroupEdit.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'group.messages',
    path: '/hub/groups/:id',
    component: () => import('../pages/groups/GroupMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]

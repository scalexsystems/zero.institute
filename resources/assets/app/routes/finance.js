import { toInt } from '../util'
export default [

  {
    name: 'fee-session.index',
    path: '/finance/fee/sessions',
    component: () => import('../pages/finance/FeeSessionManager.vue'),
  },

  {
    name: 'fee-session.show',
    path: '/finance/fee/sessions/:id',
    component: () => import('../pages/finance/FeeSession.vue'),
    props: route => ({
      session_id: toInt(route.params.id)
    })
  }

]
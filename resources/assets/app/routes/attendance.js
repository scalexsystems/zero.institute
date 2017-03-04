import { toInt } from '../util'

export default [
    {
        name: 'attendance',
        path: '/sessions/:id/attendance',
        component: () => import('../pages/attendance/Create.vue'),
        props: route => ({
            id: toInt(route.params.id)
        })
    }
]
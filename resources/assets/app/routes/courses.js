import { toInt } from '../util'

export default [
  {
    name: 'course.index',
    path: '/hub/courses',
    component: () => import('../pages/courses/CourseDirectory.vue')
  },
  {
    name: 'course.create',
    path: '/hub/courses/create',
    component: () => import('../pages/courses/CourseCreate.vue')
  },
  {
    name: 'course.session',
    path: '/hub/courses/sessions/:id',
    component: () => import('../pages/courses/CourseSessionMessages.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'course.session.show',
    path: '/hub/courses/:course/sessions/:session/show',
    component: () => import('../pages/courses/CourseSession.vue'),
    props: route => ({
      sessionId: toInt(route.params.session),
      id: toInt(route.params.course)
    })
  },
  {
    name: 'course.session.enroll',
    path: '/hub/courses/:course/sessions/:session/enroll',
    component: () => import('../pages/courses/CourseSessionEnroll.vue'),
    props: route => ({
      sessionId: toInt(route.params.session),
      id: toInt(route.params.course)
    })
  },
  {
    name: 'course.show',
    path: '/hub/courses/:id/show',
    component: () => import('../pages/courses/Course.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  },
  {
    name: 'course.edit',
    path: '/hub/courses/:id/edit',
    component: () => import('../pages/courses/CourseEdit.vue'),
    props: route => ({
      id: toInt(route.params.id)
    })
  }
]

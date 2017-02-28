export default [
  {
    name: 'settings.index',
    path: '/settings',
    redirect: '/settings/institute'
  },
  {
    name: 'settings.school',
    path: '/settings/institute',
    component: () => import('../pages/settings/Institute.vue')
  },
  {
    name: 'settings.departments',
    path: '/settings/departments',
    component: () => import('../pages/settings/Departments.vue')
  },
  {
    name: 'settings.disciplines',
    path: '/settings/disciplines',
    component: () => import('../pages/settings/Disciplines.vue')
  },
  {
    name: 'settings.invitations',
    path: '/settings/invitations',
    component: () => import('../pages/settings/Invitations.vue')
  },
  {
    name: 'settings.semesters',
    path: '/settings/semesters',
    component: () => import('../pages/settings/Semesters.vue')
  },
  {
    name: 'settings.sessions',
    path: '/settings/sessions',
    component: () => import('../pages/settings/Sessions.vue')
  },
  {
    name: 'settings.roles',
    path: '/settings/roles',
    component: () => import('../pages/settings/Roles.vue')
  }
]

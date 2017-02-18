export default [
  {
    name: 'settings.index',
    path: '/settings',
    redirect: '/settings/institute'
  },
  {
    name: 'settings.school',
    path: '/settings/institute',
    component: require('../pages/settings/Institute.vue')
  },
  {
    name: 'settings.departments',
    path: '/settings/departments',
    component: require('../pages/settings/Departments.vue')
  },
  {
    name: 'settings.disciplines',
    path: '/settings/disciplines',
    component: require('../pages/settings/Disciplines.vue')
  },
  {
    name: 'settings.invitations',
    path: '/settings/invitations',
    component: require('../pages/settings/Invitations.vue')
  },
  {
    name: 'settings.semesters',
    path: '/settings/semesters',
    component: require('../pages/settings/Semesters.vue')
  },
  {
    name: 'settings.sessions',
    path: '/settings/sessions',
    component: require('../pages/settings/Sessions.vue')
  },
  {
    name: 'settings.roles',
    path: '/settings/roles',
    component: require('../pages/settings/Roles.vue')
  }
]
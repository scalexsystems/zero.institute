import store from '../vuex'

const items = [
  {
    name: 'student.dashboard',
    path: '/people/students/dashboard',
    component: () => import('../pages/people/student/Search.vue')
  },
  {
    name: 'student.index',
    path: '/people/students',
    component: () => import('../pages/people/student/Results.vue')
  },
  {
    name: 'student.show',
    path: '/people/students/:uid',
    component: () => import('../pages/people/student/Profile.vue'),
    props: true
  }
]

const teachers = [
  {
    name: 'teacher.dashboard',
    path: '/people/teachers/dashboard',
    component: () => import('../pages/people/teacher/Search.vue')
  },
  {
    name: 'teacher.index',
    path: '/people/teachers',
    component: () => import('../pages/people/teacher/Results.vue')
  },
  {
    name: 'teacher.show',
    path: '/people/teachers/:uid',
    component: () => import('../pages/people/teacher/Profile.vue'),
    props: true
  }
]

const employees = [
  {
    name: 'employee.dashboard',
    path: '/people/employees/dashboard',
    component: () => import('../pages/people/employee/Search.vue')
  },
  {
    name: 'employee.index',
    path: '/people/employees',
    component: () => import('../pages/people/employee/Results.vue')
  },
  {
    name: 'employee.show',
    path: '/people/employees/:uid',
    component: () => import('../pages/people/employee/Profile.vue'),
    props: true
  }
]

export default [
  {
    name: 'people.dashboard',
    path: '/people',
    component: () => import('../pages/people/Dashboard.vue')
  },
  {
    name: 'user.profile',
    path: '/profile',
    redirect: to => {
      const person = store.state.user.person

      return `/people/${person._type}s/${person.uid}`
    }
  },
  ...items,
  ...teachers,
  ...employees
]

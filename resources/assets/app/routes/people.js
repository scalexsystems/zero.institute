const students = [
  {
    name: 'student.dashboard',
    path: '/people/students/dashboard',
    component: require('../pages/people/student/Search.vue')
  },
  {
    name: 'student.index',
    path: '/people/students',
    component: require('../pages/people/student/Results.vue')
  },
  {
    name: 'student.show',
    path: '/people/students/:uid',
    component: require('../pages/people/student/Profile.vue'),
    props: true
  }
]

const teachers = [
  {
    name: 'teacher.dashboard',
    path: '/people/teachers/dashboard',
    component: require('../pages/people/teacher/Search.vue')
  },
  {
    name: 'teacher.index',
    path: '/people/teachers',
    component: require('../pages/people/teacher/Search.vue')
  }
]

const employees = [
  {
    name: 'employee.dashboard',
    path: '/people/employees/dashboard',
    component: require('../pages/people/employee/Search.vue')
  },
  {
    name: 'employee.index',
    path: '/people/employees',
    component: require('../pages/people/employee/Search.vue')
  }
]

export default [
  {
    name: 'people.dashboard',
    path: '/people',
    component: require('../pages/people/Dashboard.vue')
  },
  ...students,
  ...teachers,
  ...employees
]
import Dashboard from './Dashboard.vue'

import StudentSearch from './student/Search.vue'
import StudentResults from './student/Results.vue'
import StudentProfile from './student/Profile.vue'

import StudentProfileEdit from './student/ProfileEdit.vue'
import TeacherProfileEdit from './teacher/ProfileEdit.vue'

import TeacherSearch from './teacher/Search.vue'
import TeacherResults from './teacher/Results.vue'
import TeacherProfile from './teacher/Profile.vue'

import EmployeeSearch from './employee/Search.vue'
import EmployeeResults from './employee/Results.vue'
import EmployeeProfile from './employee/Profile.vue'

import SearchOptionPerson from '../components/SearchOptionPerson.vue'

export default function (Vue, { routes }) {
  Vue.component('search-option-person', SearchOptionPerson)

  routes.push(...[
    {
      name: 'people',
      path: '/people',
      component: Dashboard
    },
    {
      name: 'student',
      path: '/people/students',
      component: StudentSearch
    },
    {
      name: 'student.find',
      path: '/people/students/find',
      component: StudentResults
    },
    {
      name: 'student.profile',
      path: '/people/students/:student',
      component: StudentProfile
    },
    {
      name: 'student.profile.edit',
      path: '/people/students/:student/edit',
      component: StudentProfileEdit
    },
    {
      name: 'teacher',
      path: '/people/teachers',
      component: TeacherSearch
    },
    {
      name: 'teacher.profile.edit',
      path: '/people/teachers/:student/edit',
      component: TeacherProfileEdit
    },
    {
      name: 'teacher.find',
      path: '/people/teachers/find',
      component: TeacherResults
    },
    {
      name: 'teacher.profile',
      path: '/people/teachers/:teacher',
      component: TeacherProfile
    },
    {
      name: 'employee',
      path: '/people/employees',
      component: EmployeeSearch
    },
    {
      name: 'employee.find',
      path: '/people/employees/find',
      component: EmployeeResults
    },
    {
      name: 'employee.profile',
      path: '/people/employees/:employee',
      component: EmployeeProfile
    }
  ])
}

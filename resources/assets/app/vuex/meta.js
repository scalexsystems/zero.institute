export const types = {
  ADD_USER: 'school/ADD_USER',
  ADD_EMPLOYEE: 'school/ADD_EMPLOYEE',
  ADD_STUDENT: 'school/ADD_STUDENT',
  ADD_TEACHER: 'school/ADD_TEACHER',
  ADD_GROUP: 'school/ADD_GROUP',
  ADD_COURSE: 'school/ADD_COURSE',
  SET_USER_IS_MEMBER: 'school/SET_USER_IS_MEMBER',
  SET_VALUE_ON_GROUP: 'school/SET_VALUE_ON_GROUP',
  SET_DISCIPLINES: 'school/SET_DISCIPLINES',
  SET_DEPARTMENTS: 'school/SET_DEPARTMENTS',
  SET_SEMESTERS: 'school/SET_SEMESTERS',
  ADD_DEPARTMENT: 'school/ADD_DEPARTMENT',
  UPDATE_DEPARTMENT: 'school/UPDATE_DEPARTMENT',
  ADD_DISCIPLINE: 'school/ADD_DISCIPLINE',
  UPDATE_DISCIPLINE: 'school/UPDATE_DISCIPLINE',
  ADD_SEMESTER: 'school/ADD_SEMESTER',
  UPDATE_SEMESTER: 'school/UPDATE_SEMESTER',
  SET_SCHOOL: 'school/SET_SCHOOL',

  SET_USER: 'SET_USER'
}

export const actions = {
  getGroups: 'school/getGroups',
  getUsers: 'school/getUsers',
  getStudents: 'school/getStudents',
  getTeachers: 'school/getTeachers',
  getEmployees: 'school/getEmployees',
  getDepartments: 'school/getDepartments',
  getDisciplines: 'school/getDisciplines',
  getSemesters: 'school/getSemesters',
  getCourses: 'school/getCourses',
  findStudent: 'school/findStudent',
  addDepartment: 'school/addDepartment',
  updateDepartment: 'school/updateDepartment',
  addDiscipline: 'school/addDiscipline',
  updateDiscipline: 'school/updateDiscipline',
  addSemester: 'school/addSemester',
  updateSemester: 'school/updateSemester',
  getUser: 'getUser',
  getSchool: 'school/getSchool'
}

export const getters = {
  groups: 'school/groups',
  groupMap: 'school/groupMap',
  users: 'school/users',
  courses: 'school/courses',
  employees: 'school/employees',
  students: 'school/students',
  teachers: 'school/teachers',
  departments: 'school/departments',
  disciplines: 'school/disciplines',
  semesters: 'school/semesters',
  departmentsByType: 'school/departmentsByType',
  departmentCount: 'school/departmentCount',
  user: 'user',
  school: 'school/school'
}

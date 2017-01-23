import map from 'lodash/map';
import isArray from 'lodash/isArray';
import group from 'lodash/groupBy';
import first from 'lodash/first';
import Vue from 'vue';
import { pushIf, pushOrMerge } from '../../util';

const commitUsers = (result, commit) => {
  if ('user' in first(result.data)) {
    commit('ADD_USER', map(result.data, person => ({ person, ...person.user })));
  }
};

export default {
  namespaced: true,
  state: {
    school: {},
    employees: [],
    employeeMap: {},
    groups: [],
    groupMap: {},
    students: [],
    studentMap: {},
    teachers: [],
    teacherMap: {},
    users: [],
    userMap: {},
    departments: [],
    disciplines: [],
    semesters: [],
    courses: [],
  },
  getters: {
    employees(state) {
      return state.employees;
    },
    groups(state) {
      return state.groups;
    },
    groupMap(state) {
      return state.groupMap;
    },
    students(state) {
      return state.students;
    },
    teachers(state) {
      return state.teachers;
    },
    users(state) {
      return state.users;
    },
    departments(state) {
      return state.departments;
    },
    disciplines(state) {
      return state.disciplines;
    },
    departmentsByType(state) {
      const departments = state.departments;
      if (departments.length) {
        const groupedDepartments = group(departments, (department => department.academic));
        return {
          academic: groupedDepartments.true,
          nonAcademic: groupedDepartments.false,
        };
      }
      return {};
    },
    departmentCount(state) {
      return state.departments.length;
    },
    semesters(state) {
      return state.semesters;
    },
    courses(state) {
      return state.courses;
    },
    school(state) {
      return state.school;
    },
  },
  mutations: {
    ADD_USER(state, users) {
      pushIf(state.users, users, state.userMap, []);
    },
    ADD_STUDENT(state, students) {
      pushIf(state.students, students, state.studentMap, []);
    },
    ADD_TEACHER(state, teachers) {
      pushIf(state.teachers, teachers, state.teacherMap, []);
    },
    ADD_EMPLOYEE(state, employees) {
      pushIf(state.employees, employees, state.employeeMap, []);
    },
    ADD_GROUP(state, groups) {
      pushIf(state.groups, groups, state.groupMap, []);
    },
    ADD_COURSE(state, courses) {
      const items = isArray(courses) ? courses : [courses];

      pushOrMerge(state.courses, items);
    },
    SET_USER_IS_MEMBER(state, { groupId, isMember }) {
      const mappedIndex = state.groupMap[groupId];
      state.groups[mappedIndex].is_member = isMember;
    },
    SET_VALUE_ON_GROUP(state, { groupId, key, value }) {
      const mappedIndex = state.groupMap[groupId];

      state.groups[mappedIndex][key] = value;
    },
    SET_DEPARTMENTS(state, departments) {
      state.departments = departments;
    },
    SET_DISCIPLINES(state, disciplines) {
      state.disciplines = disciplines;
    },
    SET_SEMESTERS(state, semesters) {
      state.semesters = semesters;
    },
    ADD_DEPARTMENT(state, departments) {
      pushIf(state.departments, departments, { }, []);
    },
    UPDATE_DEPARTMENT(state, { departmentId, department }) {
      const index = state.departments.findIndex(dep => dep.id === departmentId);
      state.departments[index] = department;
    },
    ADD_DISCIPLINE(state, disciplines) {
      pushIf(state.disciplines, disciplines, { }, []);
    },
    UPDATE_DISCIPLINE(state, { disciplineId, discipline }) {
      const index = state.disciplines.findIndex(discp => discp.id === disciplineId);
      state.disciplines[index] = discipline;
    },
    ADD_SEMESTER(state, semesters) {
      pushIf(state.semesters, semesters, { }, []);
    },
    UPDATE_SEMESTER(state, { semesterId, semester }) {
      const index = state.semesters.findIndex(sem => sem.id === semesterId);
      state.semesters[index] = semester;
    },
    SET_SCHOOL(state, { school }) {
      state.school = school;
    },
  },
  actions: {
    getStudents({ commit }, params = {}) {
      return Vue.http.get('people/students', { params })
          .then(response => response.json())
          .then((result) => {
            commit('ADD_STUDENT', result.data);
            commitUsers(result, commit);

            return result;
          })
          .catch(response => response);
    },
    getEmployees({ commit }, params = {}) {
      return Vue.http.get('people/employees', { params })
          .then(response => response.json())
          .then((result) => {
            commit('ADD_EMPLOYEE', result.data);
            commitUsers(result, commit);

            return result;
          })
          .catch(response => response);
    },
    getTeachers({ commit }, params = {}) {
      return Vue.http.get('people/teachers', { params })
          .then(response => response.json())
          .then((result) => {
            commit('ADD_TEACHER', result.data);
            commitUsers(result, commit);

            return result;
          })
          .catch(response => response);
    },
    getGroups({ commit }, params = {}) {
      return Vue.http.get('groups', { params })
          .then(response => response.json())
          .then((result) => {
            commit('ADD_GROUP', result.data);

            return result;
          })
          .catch(response => response);
    },
    getUsers({ commit }, params = {}) {
      return Vue.http.get('people', { params })
          .then(response => response.json())
          .then((result) => {
            const groups = group(result.data, 'person_type');

            commit('ADD_USER', result.data);

            if ('student' in groups) commit('ADD_STUDENT', groups.student);
            if ('employee' in groups) commit('ADD_EMPLOYEE', groups.employee);
            if ('teacher' in groups) commit('ADD_TEACHER', groups.teacher);

            return result;
          })
          .catch(response => response);
    },
    getDepartments({ commit }, params = {}) {
      return Vue.http.get('departments', { params })
          .then(response => response.json())
          .then((result) => {
            commit('SET_DEPARTMENTS', result.data);
          })
          .catch(response => response);
    },
    getDisciplines({ commit }, params = {}) {
      return Vue.http.get('disciplines', { params })
          .then(response => response.json())
          .then((result) => {
            commit('SET_DISCIPLINES', result.data);
          })
          .catch(response => response);
    },
    getCourses({ commit }, params = {}) {
      return Vue.http.get('courses', { params })
        .then(response => response.json())
        .then((result) => {
          commit('ADD_COURSE', result.data);

          return result;
        })
        .catch(response => response);
    },
    getSemesters({ commit }, params = {}) {
      return Vue.http.get('semesters', { params })
          .then(response => response.json())
          .then((result) => {
            commit('SET_SEMESTERS', result.data);
          })
          .catch(response => response);
    },
    findStudent({ state }, id) {
      const index = state.studentMap[id];

      if (index > -1) {
        return state.students[index];
      }

      return null;
    },
    addDepartment({ commit }, department) {
      commit('ADD_DEPARTMENT', { ...department });
    },
    updateDepartment({ commit }, department) {
      commit('UPDATE_DEPARTMENT', { departmentId: department.id, department });
    },
    addDiscipline({ commit }, discipline) {
      commit('ADD_DISCIPLINE', { ...discipline });
    },
    updateDiscipline({ commit }, discipline) {
      commit('UPDATE_DISCIPLINE', { disciplineId: discipline.id, discipline });
    },
    addSemester({ commit }, semester) {
      commit('ADD_SEMESTER', { ...semester });
    },
    updateSemester({ commit }, semester) {
      commit('UPDATE_SEMESTER', { semesterId: semester.id, semester });
    },
    getSchool({ commit }) {
      return Vue.http.get('school')
        .then(response => response.json())
        .then((school) => {
          commit('SET_SCHOOL', { school });
        });
    },
  },
};

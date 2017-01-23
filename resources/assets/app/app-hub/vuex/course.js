import Vue from 'vue';
import { pushOrMerge } from '../../util';

export default {
  state: {
    courses: [],
  },
  getters: {
    courses(state) {
      return state.courses;
    },
  },
  mutations: {
    ADD_COURSE(state, courses) {
      pushOrMerge(state.courses, courses);
    },
  },
  actions: {
    getCourses({ dispatch }) {
      return Vue.http.get('me/courses')
        .then(response => response.json())
        .then(result => dispatch('setCourses', result.data))
        .catch(response => response);
    },
    findCourse({ dispatch }, id) {
      return Vue.http.get(`me/courses/${id}`)
        .then(response => response.json())
        .then(course => dispatch('setCourses', [course]))
        .catch(response => response);
    },
    setCourses({ commit, dispatch, state }, courses) {
      commit('ADD_COURSE', courses);
      dispatch('setGroups', state.courses.map(course => course.session.group));

      return courses;
    },
  },
};

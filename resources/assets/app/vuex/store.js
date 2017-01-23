import Vue from 'vue';
import Vuex from 'vuex';
import createLogger from 'vuex/dist/logger';
import app from './modules/app';
import school from './modules/school';

require('es6-promise/auto');

Vue.use(Vuex);
const Laravel = window.Laravel || {};

export default new Vuex.Store({
  state: {
    user: Laravel.user || {},
  },
  mutations: {
    SET_USER(state, user) {
      state.user = user;
    },
  },
  getters: {
    user(state) {
      return state.user;
    },
  },
  actions: {
    getUser({ commit }) {
      return Vue.http.get('me')
          .then(response => response.json())
          .then((result) => {
            commit('SET_USER', result);

            return result;
          })
          .catch(response => response);
    },
  },

  modules: { app, school },
  plugins: process.env.NODE_ENV !== 'production' ? [createLogger()] : [],
  strict: process.env.NODE_ENV !== 'production',
});

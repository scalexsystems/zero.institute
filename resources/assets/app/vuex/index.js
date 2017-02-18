import Vue from 'vue'
import Vuex from 'vuex'
import 'es6-promise/auto'
import actions from './actions'
import getters from './getters'
import { default as mutations, state } from './mutations'
import modules from './modules'

Vue.use(Vuex)

export default new Vuex.Store({
  state: state(),
  mutations,
  getters,
  actions,
  modules,

  plugins: [],
  strict: process.env.NODE_ENV !== 'production'
})

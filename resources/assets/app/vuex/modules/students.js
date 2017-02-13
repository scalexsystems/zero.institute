import http from '../api'

const actions = {
  async index (_, params = {}) {
    return await http.get('people/students', { params })
  },

  async find (_, uid) {
    return await http.get(`people/students/${uid}`)
  }
}

const getters = {}

const state = () => ({})

const mutations = {}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
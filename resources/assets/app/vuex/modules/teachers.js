import http from '../api'

const actions = {
  async index (_, { page = 1, q }) {
    return await http.get('people/teachers', { params: { page, q } })
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
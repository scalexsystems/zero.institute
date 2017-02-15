import http from '../api'

const actions = {
  async index (_, { page = 1, q } = {}) {
    return await http.get('people/teachers', { params: { page, q } })
  },

  async find (_, uid) {
    return await http.get(`people/teachers/${uid}`)
  },

  async update (_, { uid, payload }) {
    try {
      const { teacher } = await http.put(true, `people/teachers/${uid}`, payload)

      return { teacher }
    } catch (error) {

      return error
    }
  },

  async updateAddress (_, { uid, payload }) {
    try {
      const { address } = await http.put(true, `people/teachers/${uid}/address`, payload)

      return { address }
    } catch (e) {
      return e
    }
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
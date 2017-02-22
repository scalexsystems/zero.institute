import http from '../api'

const actions = {
  async index (_, params = {}) {
    return await http.get('people/employees', { params })
  },

  async find (_, uid) {
    return await http.get(`people/employees/${uid}`)
  },

  async update (_, { uid, payload }) {
    try {
      const { employee } = await http.put(true, `people/employees/${uid}`, payload)

      return { employee }
    } catch (e) {
      return e
    }
  },

  async updateAddress (_, { uid, payload }) {
    try {
      const { address } = await http.put(true, `people/employees/${uid}/address`, payload)

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

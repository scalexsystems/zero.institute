import http from '../api'

const actions = {
  async index (_, params = {}) {
    return await http.get('people/students', { params })
  },

  async find (_, uid) {
    return await http.get(`people/students/${uid}`)
  },

  async update (_, { uid, payload }) {
    try {
      const { student } = await http.put(true, `people/students/${uid}`, payload)

      return { student }
    } catch (error) {
      return error
    }
  },

  async updateAddress (_, { uid, payload }) {
    try {
      const { address } = await http.put(true, `people/students/${uid}/address`, payload)

      return { address }
    } catch (e) {
      return e
    }
  },

  async updateFather (_, { uid, payload }) {
    try {
      const { guardian } = await http.put(true, `people/students/${uid}/father`, payload)

      return { father: guardian }
    } catch (e) {
      return e
    }
  },

  async updateMother (_, { uid, payload }) {
    try {
      const { guardian } = await http.put(true, `people/students/${uid}/mother`, payload)

      return { mother: guardian }
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

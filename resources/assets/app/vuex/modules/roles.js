import http from '../api'

const actions = {
  async index () {
    const { roles } = await http.get('roles')

    return { roles }
  },

  async users (_, id) {
    const { items } = await http.get(`roles/${id}/users`)

    return { users: items }
  },

  async assign (_, { role, user }) {
    try {
      await http.post(true, `roles/${role}/assign`, { user_id: user })

      return true
    } catch (e) {
      return e
    }
  },

  async revoke (_, { role, user }) {
    try {
      await http.post(true, `roles/${role}/revoke`, { user_id: user })

      return true
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
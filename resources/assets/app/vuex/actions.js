import http from './api'

export default {
  async getUser ({ commit }) {
    const { user } = await http.get('me')

    if (user) commit('ME', user)

    return user
  }
}
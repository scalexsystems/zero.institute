import http from './api'

export default {
  async getUser ({ commit }) {
    const { user } = await http.get('me')

    if (user) commit('ME', user)

    return user
  },

  async updateSchool ({ commit }, { payload }) {
    try {
      const { school } = await http.put(true, 'school', payload)

      commit('SCHOOL', school)

      return school
    } catch (e) {
      return e
    }
  },

  async updateSchoolAddress ({ commit }, { payload }) {
    try {
      const { school } = await http.post(true, 'school/address', payload)

      commit('SCHOOL', school)

      return school
    } catch (e) {
      return e
    }
  },

  async setSchoolLogo ({ commit }, logo) {
    commit('SCHOOL_LOGO', logo)
  }
}

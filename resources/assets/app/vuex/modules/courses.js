import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { courses, meta } = await http.get('courses', { params: { page } })

    if (courses) await dispatch('addToStore', courses)

    if (meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages) {
      dispatch('index', { page: page + 1 })
    }

    return { courses, meta }
  },

  async find ({ dispatch }, id) {
    const { course } = await http.get(`courses/${id}`)

    if (course) await dispatch('addToStore', [course])

    return { course }
  },

  async store ({ dispatch }, payload) {
    try {
      const { course } = await http.post(true, 'courses', payload)

      if (course) await dispatch('addToStore', [course])

      return { course }
    } catch (e) {
      return e
    }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  courses: state => state.courses,

  courseById: state => (id) => binarySearchFind(state.courses, id),
}

const state = () => ({
  courses: []
})

const mutations = {
  INSERT (state, courses) {
    insert(state.courses, courses)
  },

  REMOVE (state, id) {
    remove(state.courses, id)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
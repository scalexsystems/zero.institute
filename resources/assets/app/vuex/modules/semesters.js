import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { semesters, meta } = await http.get('semesters', { params: { page } })

    if (semesters) await dispatch('addToStore', semesters)

    if (meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages) {
      dispatch('index', { page: page + 1 })
    }

    return { semesters, meta }
  },

  async find ({ dispatch }, id) {
    const { semester } = await http.get(`semesters/${id}`)

    if (semester) await dispatch('addToStore', [semester])

    return { semester }
  },

  async store ({ dispatch }, payload) {
    try {
      const { semester } = await http.post(true, 'semesters', payload)

      await dispatch('addToStore', [semester])

      return { semester }
    } catch (e) {
      return e
    }
  },

  async update ({ dispatch }, { id, payload} ) {
    try {
      const { semester } = await http.put(true, `semesters/${id}`, payload)

      await dispatch('addToStore', [semester])

      return { semester }
    } catch (e) {
      return e
    }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  semesters: state => state.semesters,

  semesterById: state => (id) => binarySearchFind(state.semesters, id),
}

const state = () => ({
  semesters: []
})

const mutations = {
  INSERT (state, semesters) {
    insert(state.semesters, semesters)
  },

  REMOVE (state, id) {
    remove(state.semesters, id)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { disciplines, meta } = await http.get('disciplines', { params: { page } })

    if (disciplines) await dispatch('addToStore', disciplines)

    if (meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages) {
      dispatch('index', { page: page + 1 })
    }

    return { disciplines, meta }
  },

  async find ({ dispatch }, id) {
    const { discipline } = await http.get(`disciplines/${id}`)

    if (discipline) await dispatch('addToStore', [discipline])

    return { discipline }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  disciplines: state => state.disciplines,
  disciplineById: state => (id) => binarySearchFind(state.disciplines, id),
}

const state = () => ({
  disciplines: []
})

const mutations = {
  INSERT (state, disciplines) {
    insert(state.disciplines, disciplines)
  },

  REMOVE (state, id) {
    remove(state.disciplines, id)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
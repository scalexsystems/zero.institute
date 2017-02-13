import http from '../api'
import { insert, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1, q } = {}) {
    const { items, meta } = await http.get('people', { q, page })

    if (!q) {
      await dispatch('addToStore', items)
    }

    return { items, meta }
  },

  async show ({ dispatch }, id) {
    const { item } = http.get(`people/${id}`)

    dispatch('addToStore', [item])

    return item
  },

  async statistics ({ commit }) {
    const statistics = await http.get('people/statistics')

    if (statistics) commit('STATISTICS', statistics)
  },

  // -- LOCAL ACTIONS --
  addToStore ({ commit }, items) {
    if (!items) return

    commit('INSERT', items)
  }
}

const getters = {
  personById: state => id => binarySearchFind(state.items, id),
  people: state => state.items,
  statistics: state => state.statistics
}

const state = () => ({
  items: [],
  statistics: {
    $fetch: true,
    student: { count: 0 },
    teacher: { count: 0 },
    employee: { count: 0 }
  }
})

const mutations = {
  INSERT (state, items) {
    insert(state.items, items)
  },

  STATISTICS (state, statistics) {
    state.statistics = statistics
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}

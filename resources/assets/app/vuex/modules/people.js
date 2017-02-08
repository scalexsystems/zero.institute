import http from '../api'
import { insert, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1, q } = {}) {
    const { items, meta } = await http.get('people', { q, page })

    await dispatch('addToStore', items)

    return { items, meta }
  },

  async show ({ dispatch }, id) {
    const { item } = http.get(`people/${id}`)

    dispatch('addToStore', item)

    return item
  },

  // -- LOCAL ACTIONS --
  addToStore ({ commit }, items) {
    if (!items) return

    commit('INSERT', items)
  }
}

const getters = {
  personById: state => id => binarySearchFind(state.items, id),
  items: state => state.items
}

const state = () => ({
  items: []
})

const mutations = {
  INSERT (state, items) {
    insert(state.items, items)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}

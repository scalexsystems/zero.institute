import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const history = []

const actions = {
  async index ({ dispatch }, { q = '' } = {}) {
    q = q.toLocaleLowerCase()

    if (history.indexOf(q) > -1) return {}

    history.push(q)

    const { cities } = await http.get('geo/cities', { params: { q } })

    if (cities) await dispatch('addToStore', cities)

    return { cities }
  },

  async find ({ dispatch }, id) {
    const { city } = await http.get(`geo/cities/${id}`)

    if (city) await dispatch('addToStore', [city])

    return { city }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  cities: state => state.cities,

  cityById: state => (id) => binarySearchFind(state.cities, id),
}

const state = () => ({
  cities: []
})

const mutations = {
  INSERT (state, cities) {
    insert(state.cities, cities)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
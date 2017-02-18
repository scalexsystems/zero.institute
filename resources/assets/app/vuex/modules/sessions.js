import sort from 'lodash.sortby'
import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { sessions, meta } = await http.get('sessions', { params: { page } })

    if (sessions) await dispatch('addToStore', sessions)

    if (meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages) {
      dispatch('index', { page: page + 1 })
    }

    return { sessions, meta }
  },

  async find ({ dispatch }, id) {
    const { session } = await http.get(`sessions/${id}`)

    if (session) await dispatch('addToStore', [session])

    return { session }
  },

  async store ({ dispatch }, payload) {
    try {
      const { session } = await http.post(true, 'sessions', payload)

      await dispatch('addToStore', [session])

      return { session }
    } catch (e) {
      return e
    }
  },

  async update ({ dispatch }, { id, payload }) {
    try {
      const { session } = await http.put(true, `sessions/${id}`, payload)

      await dispatch('addToStore', [session])

      return { session }
    } catch (e) {
      return e
    }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  sessions: state => sort(state.sessions.slice(), 'name'),
  sessionById: state => (id) => binarySearchFind(state.sessions, id),
}

const state = () => ({
  sessions: []
})

const mutations = {
  INSERT (state, sessions) {
    insert(state.sessions, sessions)
  },

  REMOVE (state, id) {
    remove(state.sessions, id)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
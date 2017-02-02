import http from '../api'
import { insert, binarySearchFind } from '../helpers'

const actions = {
  /**
   * Search or list groups
   */
  async index ({ dispatch }, { page = 1, query, type } = {}) {
    const data = await http.get('groups', { params: { page, q: query, type } })

    console.log(data)

    if ('groups' in data) await dispatch('addToStore', data.groups)

    return data
  },

  /**
   * Fetch a particular group
   */
  async find ({ dispatch }, id) {
    const { group } = await http.get(`groups/${id}`)

    if (group) await dispatch('addToStore', group)

    return group
  },

  /**
   * Create new group
   */
  async store ({ dispatch }, attrs) {
    try {
      const { group } = await http.post(true, 'groups', attrs)

      await dispatch('addToStore', group)

      return { group }
    } catch (error) {
      return { error }
    }
  },

  /**
   * Update group information
   */
  async update ({ dispatch }, { id, attrs }) {
    try {
      const group = await http.put(true, `groups/${id}`, attrs)

      await dispatch('addToStore', group)

      return { group }
    } catch (error) {
      return { error }
    }
  },

  // ------- LOCAL ACTIONS ---------
  async addToStore ({ commit }, groups) {
    if (groups) commit('INSERT', groups)

    return groups
  }
}

const getters = {
  groups: state => state.groups.filter(group => group.type === 'group'),
  communities: state => state.groups.filter(group => group.type === 'community'),
  groupById: state => (id) => binarySearchFind(state.groups, id)
}

const state = () => ({
  groups: []
})

const mutations = {
  INSERT (state, groups) {
    insert(state.groups, groups)
  }
}

// THE STORE!
export default {
  namespaced: true,
  state: state(),
  actions,
  getters,
  mutations
}

import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  /**
   * Search or list groups
   */
  async index ({ dispatch }, { page = 1, query, type } = {}) {
    const { groups, meta } = await http.get('groups', { params: { page, q: query, type }})

    if (groups) await dispatch('addToStore', groups)

    return { groups, meta }
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
      return error
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
      return error
    }
  },

  /**
   * Delete group.
   */
  async delete ({ dispatch }, { id }) {
    try {
      await http.delete(true, `groups/${id}`)

      await dispatch('removeFromStore', { id })
    } catch (e) {
      // NOTE: Error is already handled. Try/Catch is required as DELETE does not respond with body.
    }
  },

  /**
   * Fetch members.
   *
   * NOTE: Members are not stored in store.
   */
  async members ({}, { id }) {
    const { users } = await http.get(`groups/${id}/members`)

    return users
  },

  /**
   * Join a group.
   */
  async join ({ dispatch }, { id }) {
    const { group } = await http.get(`group/${id}/join`)

    if (group) dispatch('addToStore', group)

    return group
  },

  // ------- LOCAL ACTIONS ---------
  async addToStore ({ commit }, groups) {
    if (groups) commit('INSERT', groups)

    return groups
  },

  async removeFromStore ({ commit }, id) {
    commit('REMOVE', id)
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
  },

  REMOVE (state, id) {
    remove(state.groups, id)
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

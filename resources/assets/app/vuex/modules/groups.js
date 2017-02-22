import http from '../api'
import { insert, remove, binarySearchFind, binarySearchIndex } from '../helpers'
import { prepareGroup as prepare, prepareMessages, TIMESTAMP } from './messages/helpers'
import { toArray, isObject, each, last } from '../../util'

const actions = {
  /**
   * Search or list groups
   */
  async index ({ dispatch }, { page = 1, query, type } = {}) {
    const { groups, meta } = await http.get('groups', { params: { page, q: query, type } })

    if (!query) {
      await dispatch('addToStore', groups)
    }

    return { groups, meta }
  },

  /**
   * Fetch a particular group
   */
  async find ({ dispatch }, id) {
    const { group } = await http.get(`groups/${id}`)

    await dispatch('addToStore', group)

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
      const { group } = await http.put(true, `groups/${id}`, attrs)

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

      return true
    } catch (e) {
      // NOTE: Error is already handled. Try/Catch is required as
      // DELETE does not respond with body.
      return false
    }
  },

  /**
   * Fetch members.
   */
  async members ({ dispatch }, { group }) {
    const { users, meta } = await http.get(`groups/${group.id}/members`, { params: { page: group.$members_page } })

    if (users) {
      await dispatch('addMembersToStore', { members: users, id: group.id, page: meta.pagination.current_page + 1 })
    }

    return { meta, members: users }
  },

  /**
   * Join a group.
   */
  async join ({ dispatch }, id) {
    const { group } = await http.post(`groups/${id}/join`)

    await dispatch('addToStore', group)

    return { group }
  },

  /**
   * Leave a group.
   */
  async leave ({ dispatch }, id) {
    const { group } = await http.delete(`groups/${id}/leave`)

    await dispatch('removeFromStore', id)

    return { group }
  },

  /**
   * Add member to group
   */
  async add ({ dispatch }, { id, member }) {
    try {
      const { users } = await http.post(true, `groups/${id}/members`, { member: member.user_id })

      if (users) dispatch('addMembersToStore', { id, members: users })

      return true
    } catch (e) {
      return e
    }
  },

  /**
   * Remove member from group.
   */
  async remove ({ dispatch }, { id, member }) {
    try {
      const items = await http.delete(true, `groups/${id}/members`, { body: { member: member.id } })

      if (items.length) dispatch('removeMembersFromStore', { id, member: member.id })

      return true
    } catch (e) {
      return e
    }
  },

  async my ({ dispatch }, page = 1) {
    const { groups, meta } = await http.get('me/groups', { params: { page } })

    if (groups) await dispatch('addToStore', groups)

    return { groups, meta }
  },

  async myFind ({ dispatch }, id) {
    const { group } = await http.get(`me/groups/${id}`)

    if (group) await dispatch('addToStore', group)

    return group
  },

  async messages ({ dispatch }, { group, params = {} }) {
    const options = {
      params: {
        before: TIMESTAMP,
        page: group.$messages_page,
        ...params
      }
    }

    const { messages, meta } = await http.get(`groups/${group.id}/messages`, options)

    if (messages) {
      const payload = {
        id: group.id,
        page: meta.pagination.current_page + 1,
        messages
      }

      await dispatch('addMessageToGroup', payload)
    }

    return { messages, meta }
  },

  async send ({ dispatch, commit, rootState }, { id, content, extras, errors }) {
    const message = {
      id: Date.now(),
      content,
      sender: rootState.user,
      $status: { sending: true, attachments: errors || [] }
    }

    await dispatch('addMessageToGroup', { id, messages: message })

    try {
      const payload = await http.post(true, `groups/${id}/messages`, { content, ...extras })

      commit('MESSAGE_SENT', { id, message, payload: payload.message })

      return payload
    } catch (error) {
      commit('MESSAGE_FAILED', { id, message, error })

      return { error }
    }
  },

  async readAll ({ commit }, { id, messages }) {
    if (messages.length === 0) return false

    try {
      await http.put(true, `messages/read`, { messages: messages.map(message => message.id) })
      each(messages, message => commit('MESSAGE_READ', { id, message }))
    } catch (e) {
    }
  },

  /**
   * @private
   */
  async addToStore ({ commit }, groups) {
    if (groups) {
      commit('INSERT', toArray(groups).map(group => prepare(group)))
    }
  },

  /**
   * @private
   */
  async removeFromStore ({ commit }, id) {
    commit('REMOVE', id)
  },

  /**
   * @private
   */
  async addMembersToStore ({ commit, state, dispatch }, { id, members, page, _isRetry }) {
    const group = binarySearchFind(state.groups, id)

    if (group) {
      commit('MEMBER_ADD', { id, members, page })

      return true
    }

    if (_isRetry === true) {
      throw new Error(`Received members of unexpected group. Group ID ${id}`)
    }

    await dispatch('find', id)

    await dispatch('addMembersToStore', { id, members, page, _isRetry: true })
  },

  /**
   * @private
   */
  async removeMembersFromStore ({ commit }, { id, member }) {
    commit('MEMBER_REMOVE', { id, member: isObject(member) ? member.id : member })
  },

  /**
   * @private
   */
  async addMessageToGroup ({ dispatch, commit, state }, { id, messages, page, _isRetry }) {
    const group = binarySearchFind(state.groups, id)

    if (group) {
      commit('MESSAGE', { id, messages, page })

      return true// Added messages
    }

    if (_isRetry === true) {
      throw new Error(`Received message to unexpected group. Group ID ${id}`)
    }

    // Find group
    await dispatch('find', id)
    // Retry
    await dispatch('addMessageToGroup', { id, messages, page, _isRetry: true })
  }
}

const getters = {
  groups: state => state.groups.filter(group => group.type === 'group'),

  communities: state => state.groups.filter(group => group.type === 'community'),

  my: state => state.groups.filter(group => group.is_member),

  myGroups: (_, getters) => getters.my.filter(group => group.type === 'group'),

  unread_total: (_, getters) => getters.myGroups.reduce((t, g) => t + g.$unread_count, 0),

  myCourses: (_, getters) => getters.my.filter(group => group.type === 'course'),

  myCommunities: (_, getters) => getters.my.filter(group => group.type === 'community'),

  groupById: state => (id) => binarySearchFind(state.groups, id),

  myGroupById: (_, getters) => (id) => binarySearchFind(getters.my, id),

  messagesByGroupId (_, getters) {
    return (id) => {
      const group = getters.myGroupById(id)

      return prepareMessages(group.$messages)
    }
  },

  membersByGroupId (_, getters) {
    return (id) => {
      const group = getters.groupById(id)

      if (group) return group.$members

      return []
    }
  }
}

const state = () => ({
  groups: [],
  /**
   * Tracks unread messages.
   *
   * @type {Object}
   */
  unread: {}
})

const mutations = {
  INSERT (state, groups) {
    insert(state.groups, groups)
  },

  REMOVE (state, id) {
    remove(state.groups, id)
  },

  MEMBER_ADD (state, { id, members, page }) {
    const group = binarySearchFind(state.groups, id)

    insert(group.$members, members)

    if (page) group.$members_page = page
  },

  MEMBER_REMOVE (state, { id, member }) {
    const group = binarySearchFind(state.groups, id)

    remove(group.$members, member)
  },

  MESSAGE (state, { id, messages, page }) {
    const group = binarySearchFind(state.groups, id)

    // Insert and update group unread status
    insert(group.$messages, messages)

    const index = binarySearchIndex(group.$messages, group.$last_message_id) + 1
    const unread = group.$unread_count + group.$messages.slice(index).filter(m => m.unread).length
    state.unread[group.id] = unread
    group.$unread_count = unread
    group.$has_unread = group.$unread_count > 0
    group.$messages_loaded = true
    group.$last_message_id = last(group.$messages).id

    if (page) {
      group.$messages_page = page
    }
  },

  MESSAGE_READ (state, { id, message }) {
    const group = binarySearchFind(state.groups, id)
    const msg = binarySearchFind(group.$messages, message)

    if (msg.unread) {
      state.unread[group.id] = (state.unread[group.id] || 1) - 1
      group.$unread_count = (group.$unread_count || 1) - 1
      group.$has_unread = group.$unread_count > 0
    }

    msg.unread = false
    msg.read_at = new Date().toISOString()
  },

  MESSAGE_SENT (state, { id, message, payload }) {
    const group = binarySearchFind(state.groups, id)
    const index = binarySearchIndex(group.$messages, message)
    const already = binarySearchIndex(group.$messages, payload)

    if (already > -1) {
      group.$messages.splice(index, 1)
    } else {
      group.$messages.splice(index, 1, payload)
    }
  },

  MESSAGE_FAILED (state, { id, message, error }) {
    const group = binarySearchFind(state.groups, id)
    const msg = binarySearchFind(group.$messages, message)

    msg.$status = {
      failed: true,
      message: error.message || 'Message failed due to some unknown error',
      error
    }
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

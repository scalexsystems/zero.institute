import http from '../api'
import { insert, remove, binarySearchFind, binarySearchIndex } from '../helpers'
import { prepare, dateChangesAt, TIMESTAMP } from './messages/helpers'
import { toArray, isObject } from '../../util'

const actions = {
  /**
   * Search or list groups
   */
  async index ({ dispatch }, { page = 1, query, type } = {}) {
    const { groups, meta } = await http.get('groups', { params: { page, q: query, type }})

    await dispatch('addToStore', groups)

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
      dispatch('addMembersToStore', { members: users, id: group.id, page: meta.pagination.next_page })
    }

    return { meta, members: users }
  },

  /**
   * Join a group.
   */
  async join ({ dispatch }, id) {
    const { group } = await http.post(`groups/${id}/join`)

    dispatch('addToStore', group)

    return { group }
  },

  /**
   * Leave a group.
   */
  async leave ({ dispatch }, id) {
    const { group } = await http.delete(`groups/${id}/leave`)

    dispatch('removeFromStore', id)

    return { group }
  },


  async my ({ dispatch }, page = 1) {
    const { groups, meta } = await http.get('me/groups', { params: { page }})

    if (groups) await dispatch('addToStore', groups)

    return { groups, meta }
  },

  async findMy ({ dispatch }, id) {
    const { group } = await http.get(`me/groups/${id}`)

    if (group) await dispatch('addToStore', group)

    return group
  },

  async messages ({ dispatch }, { group, params = {}}) {
    const options = {
      params: {
        before: TIMESTAMP,
        page: group.$messages_page,
        ...params
      }
    }

    const { messages, meta } = http.get(`groups/${group.id}/messages`, options)

    if (messages) {
      const payload = {
        id: group.id,
        page: meta.pagination.next_page,
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
      $status: { sending: true, attachment: errors }
    }

    await dispatch('addMessageToGroup', { id, message })

    try {
      const payload = await http.post(true, `groups/${id}/messages`, { content, ...extras })

      commit('MESSAGE_SENT', { id, message, payload })

      return { message: payload }
    } catch (error) {
      commit('MESSAGE_FAILED', { id, message, error })

      return { error }
    }
  },

  async read ({ commit }, { id, messages }) {
    const response = await http.put(`groups/${id}/messages/read`, { ids: messages.map(message => message.id) })

    if (!response) {
      messages.forEach(message => commit('MESSAGE_READ', { id, message }))
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
  async addMembersToStore ({ commit, state }, { id, members, page, _isRetry }) {
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
    commit('MEMBER_REMOVE', { id, memberId: isObject(member) ? member.id : member })
  },

  /**
   * @private
   */
  async addMessageToGroup ({ dispatch, commit, state }, { id, messages, page, _isRetry }) {
    const group = binarySearchFind(state.groups.groups, id)

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
  myCourses: (_, getters) => getters.my.filter(group => group.type === 'course'),
  myCommunities: (_, getters) => getters.my.filter(group => group.type === 'community'),
  groupById: state => (id) => binarySearchFind(state.groups, id),
  myGroupById: (_, getters) => (id) => binarySearchFind(getters.my, id),
  messagesByGroupId (_, getters) {
    return (id) => {
      const group = getters.myGroupById(id)

      const messages = []

      for (let i = 0; i < group.$messages.length; i += 1) {
        const prev = i > 0 ? messages[i - 1] : null
        const current = group.$messages[i]
        const $dateChanges = dateChangesAt(current, prev)
        const $continued = prev && // Not first message
            !$dateChanges && // Not first message of the day
            current.attachments.length === 0 && // Has no attachments
            current.sender.id === prev.sender.id // From same sender

        messages.push({
          $continued,
          $dateChanges,
          $receivedAt: $continued ? (prev.$receivedAt || prev.received_at) : null,
          ...current
        })
      }

      return messages
    }
  },
  membersByGroupId (_, getters) {
    return (id) => {
      const group = getters.groupById(id)

      return group.$members
    }
  }
}

const state = () => ({
  groups: [],
  /**
   * Tracks unread messages.
   *
   * @type {Object.<int,int>}
   */
  unread: {
    $total: 0
  }
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

  MEMBER_REMOVE (state, { id, memberId }) {
    const group = binarySearchFind(state.groups, id)

    remove(group.$members, memberId)
  },

  MESSAGE (state, { id, messages, page }) {
    const unread = toArray(messages).filter(message => message.unread === true).length
    const group = binarySearchFind(state.groups, id)

    // Calculate quick unread count.
    state.unread.$total += unread
    state.unread[group.id] = (state.unread[group.id] || 0) + unread

    // Insert and update group unread status
    insert(group.$messages, messages)
    group.$unread_count += unread
    group.$has_unread = group.$unread_count > 0
    group.$messages_loaded = true

    if (page) {
      group.$messages_page = page
    }
  },

  MESSAGE_READ (state, { id, message }) {
    const group = binarySearchFind(state.groups, id)
    const msg = binarySearchFind(group.$messages, message)

    msg.unread = true
    msg.read_at = new Date().toISOString()
  },

  MESSAGE_SENT (state, { id, message, payload }) {
    const group = binarySearchFind(state.groups, id)
    const index = binarySearchIndex(group.$messages, message)

    group.$messages.splice(index, 1, payload)
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

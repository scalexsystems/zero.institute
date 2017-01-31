// @flow
import moment from 'moment'
import http from '../../api'
import { toArray } from '../../../util'
import { insert, binarySearchIndex, binarySearchFind } from '../../helpers'

function prepareGroup (group) {
  group.$messages = []
  group.$next_page = 1
  group.$messages_loaded = false
  group.$has_unread = false
  group.$unread_count = 0

  return group
}

function dateChangesAt (a, b) {
  return ! moment(a.received_at).isSame(moment(b.received_at), 'day')
}

const TIMESTAMP = Date.now()

const actions = {
  async index ({ dispatch }, page = 1) {
    const data = await http.get('me/groups', { params: { page } })

    if (data) dispatch('addToStore', data.groups)

    return data
  },

  async find ({ dispatch }, id) {
    const group = await http.get(`me/groups/${id}`)

    if (group) await dispatch('addToStore', group)

    return group
  },

  async messages ({ dispatch }, { group, params }) {
    const options = {
      params: {
        before: TIMESTAMP,
        page: group.$next_page,
        ...(params || {})
      }
    }

    const data = http.get(`me/groups/${group.id}/messages`, options)

    if (data) {
      const payload = {
        id: group.id,
        page: data.meta.pagination.next_page,
        messages: data.messages
      }

      await dispatch('addMessageToGroup', payload)
    }

    return data
  },

  async send({ dispatch, commit, rootState }, { id, content, extras, errors }) {
    const message = {
      id: Date.now(),
      content,
      sender: rootState.user,
      $status: { sending: true, attachment: errors },
    }

    await dispatch('addMessageToGroup', { id, message })

    try {
      const payload = await http.post(true, `groups/${id}/messages`, { content, ...extras})

      commit('MESSAGE_SENT', { id, message, payload })

      return { message: payload }
    } catch (error) {

      commit('MESSAGE_FAILED', { id, message, error })

      return { error }
    }
  },

  async read({ commit }, { id, messages }) {
    const response = await http.put(`groups/${id}/messages/read`, { ids: messages.map(message => message.id) })

    if (!response) {
      messages.forEach(message => commit('MESSAGE_READ', { id, message }))
    }
  },

  async addToStore ({ commit }, groups) {
    commit('INSERT', toArray(groups).map(group => prepareGroup(group)))
  },

  async addMessageToGroup({ dispatch, commit, state }, { id, messages, page, _isRetry }) {
    const group = binarySearchFind(state.groups, id)

    if (group) {
      commit('MESSAGE', { id, messages, page })

      return // Added messages
    }

    if (_isRetry === true) {
      throw new Error(`Received message to unexpected group. Group ID ${groupId}`)
    }

    // Find group
    await dispatch('find', groupId)
    // Retry
    await dispatch('addMessageToGroup',{ groupId, messages, _isRetry: true })
  }
}


/**
 * GETTERS
 */
const getters = {
  groups: state => state.groups.filter(group => group.type === 'group'),

  courses: state => state.groups.filter(group => group.type === 'course'),

  findGroup: state => (id => state.groups.find(group => group.id === id)),

  findUnreadCount: state => (id => state.unread[id]),

  findMessages (state, getters) {
    return (id) => {
      const group = getters.group(id)
      const messages = []
      for (let i = 0; i < group.$messages.length; i += 1) {
        const prev = i > 0 ? messages[i - 1] : null
        const current = group.$messages[i]
        const $dateChanges = dateChangesAt(current, prev)
        const $continued = prev // Not first message
            && !$dateChanges // Not first message of the day
            && current.attachments.length === 0 // Has no attachments
            && current.sender.id === prev.sender.id // From same sender

        messages.push({
          $continued,
          $receivedAt: $continued ? (prev.$receivedAt || prev.received_at) : null,
          ...current
        })
      }

      return messages
    }
  }
}


/**
 * INITIAL STATE
 */
const state = () => ({
  /**
   * List of groups.
   *
   * @type {Array.<Group>}
   */
  groups: [],

  /**
   * Tracks unread messages.
   *
   * @type {Object.<int,int>}
   */
  unread: {
    $total: 0,
  }
})


/**
 * MUTATIONS!
 */
const mutations = {
  INSERT (state, groups) {
    insert(state.groups, groups)
  },

  REMOVE (state, id) {
    const index = binarySearchIndex(state.groups, id)

    state.groups.splice(index, 1)
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
      group.$next_page = page
    }
  },

  MESSAGE_READ (state, { id, message }) {
    const group = binarySearchFind(state.groups, id)
    const message = binarySearchFind(group.$messages, message)

    message.unread = true
    message.read_at = new Date().toISOString()
  },

  MESSAGE_SENT (state, { id, message, payload }) {
    const group = binarySearchFind(state.groups, id)
    const index = binarySearchIndex(group.$messages, message)

    group.$messages.splice(index, 1, payload)
  },

  MESSAGE_FAILED (state, { id, message, error }) {
    const group = binarySearchFind(state.groups, id)
    const message = binarySearchFind(group.$messages, message)

    message.$status = {
      failed: true,
      message: error.message || 'Message failed due to some unknown error',
      error
    }
  }
}

/**
 * EXPORT THE STORE!
 */
export default {
  namespaced: true,
  state: state(),
  actions,
  getters,
  mutations
}
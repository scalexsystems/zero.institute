import http from '../api'
import { toArray, each, last } from '../../util'
import { insert, binarySearchFind, binarySearchIndex } from '../helpers'
import { TIMESTAMP, prepareMessages, prepareUser } from './messages/helpers'

const actions = {
  async index ({ dispatch }, page = 1) {
    const { users, meta } = await http.get('me/users', { params: { page } })

    if (users) await dispatch('addToStore', users)

    return { users, meta }
  },

  async find ({ dispatch }, id) {
    const { user } = await http.get(`me/users/${id}`)

    if (user) await dispatch('addToStore', user)

    return user
  },

  async fetchMessages ({ dispatch }, { user, params }) {
    const options = {
      params: {
        before: TIMESTAMP,
        page: user.$next_page,
        ...(params || {})
      }
    }

    const { messages, meta } = await http.get(`messages/direct/${user.id}/messages`, options)

    if (messages) {
      const payload = {
        id: user.id,
        page: meta.pagination.next_page,
        messages
      }

      await dispatch('addMessageToUser', payload)
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

    await dispatch('addMessageToUser', { id, messages: message })

    try {
      const payload = await http.post(true, `messages/direct/${id}/messages`, { content, ...extras })

      commit('MESSAGE_SENT', { id, message, payload: payload.message })

      return payload
    } catch (e) {
      commit('MESSAGE_FAILED', { id, message, errors: e.errors || {} })

      return e
    }
  },

  async read ({ commit }, { id, message }) {
    const response = await http.put(`messages/${message.id}/read`)

    if (!response) {
      commit('MESSAGE_READ', { id, message })
    }
  },

  async readAll ({ commit }, { id, messages }) {
    if (!messages.length) return false

    try {
      await http.put(true, `messages/read`, { messages: messages.map(message => message.id) })

      each(messages, message => commit('MESSAGE_READ', { id, message }))
    } catch (e) {
      console.warn(e)
    }
  },

  /**
   * @private
   */
  async addToStore ({ commit }, users) {
    if (users) commit('INSERT', toArray(users).map(user => prepareUser(user)))

    return users
  },

  /**
   * @private
   */
  async addMessageToUser ({ dispatch, commit, state }, { id, messages, page, _isRetry }) {
    const user = binarySearchFind(state.users, id)

    if (user) {
      commit('MESSAGE', { id, messages, page })

      return true// Added messages
    }

    if (_isRetry === true) {
      throw new Error(`Received message from unexpected user. User ID ${id}`)
    }

    // Find user
    await dispatch('find', id)
    // Retry
    await dispatch('addMessageToUser', { id, messages, page, _isRetry: true })
  }
}

const getters = {
  users: state => state.users,

  unread_total: (_, getters) => getters.users.reduce((t, g) => t + g.$unread_count, 0),

  userById: state => id => binarySearchFind(state.users, id),

  messagesByUserId: (_, getters) => {
    return (id) => {
      const user = getters.userById(id)

      return prepareMessages(user.$messages)
    }
  }
}

const state = () => ({
  users: [],

  unread: {}
})

const mutations = {
  INSERT (state, users) {
    insert(state.users, users)
  },

  MESSAGE (state, { id, messages, page }) {
    const user = binarySearchFind(state.users, id)

    insert(user.$messages, messages)

    // << UPDATE UNREAD COUNT
    const index = binarySearchIndex(user.$messages, user.$last_message_id) + 1
    const after = user.$messages.slice(index).filter(m => m.unread).length
    const unread = user.$unread_count + after
    state.unread[user.id] = unread
    user.$unread_count = unread
    user.$has_unread = user.$unread_count > 0
    user.$messages_loaded = true
    user.$last_message_id = last(user.$messages).id
    // UPDATE UNREAD COUNT >>

    if (page) {
      user.$messages_page = page
    }
  },

  MESSAGE_READ (state, { id, message }) {
    const user = binarySearchFind(state.users, id)
    const msg = binarySearchFind(user.$messages, message)

    if (msg.unread) {
      state.unread[user.id] = (state.unread[user.id] || 1) - 1
      user.$unread_count = (user.$unread_count || 1) - 1
      user.$has_unread = user.$unread_count > 0
    }

    msg.unread = false
    msg.read_at = new Date().toISOString()
  },

  MESSAGE_SENT (state, { id, message, payload }) {
    const user = binarySearchFind(state.users, id)
    const index = binarySearchIndex(user.$messages, message)
    const already = binarySearchIndex(user.$messages, payload)

    if (already > -1) {
      user.$messages.splice(index, 1)
    } else {
      user.$messages.splice(index, 1, payload)
    }

    if (user.$last_message_id === id) {
      user.$last_message_id = payload.id
    }
  },

  MESSAGE_FAILED (state, { id, message, errors }) {
    const user = binarySearchFind(state.users, id)
    const msg = binarySearchFind(user.$messages, message)

    msg.$status = {
      failed: true,
      message: errors.$message || 'Message failed due to some unknown error',
      errors
    }
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  mutations,
  state: state()
}

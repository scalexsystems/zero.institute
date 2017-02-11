import http from '../../api'
import { toArray } from '../../../util'
import { insert, binarySearchFind, binarySearchIndex } from '../../helpers'
import { TIMESTAMP, prepareMessages, prepareUser } from './helpers'

const actions = {
  async index ({ dispatch }, page = 1) {
    const { users, meta } = await http.get('me/users', { params: { page }})

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

    const { messages, meta } = http.get(`messages/direct/${user.id}/messages`, options)

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
    } catch (error) {
      commit('MESSAGE_FAILED', { id, message, error })

      return { error }
    }
  },

  async read ({ commit }, { id, message }) {
    const response = await http.put(`messages/${message.id}/read`)

    if (!response) {
      commit('MESSAGE_READ', { id, message })
    }
  },

  async readAll ({ commit }, { id, messages }) {
    const response = await http.put(`messages/read`, { ids: messages.map(message => message.id) })

    if (!response) {
      messages.forEach(message => commit('MESSAGE_READ', { id, message }))
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

  unread: {
    $total: 0
  }
})

const mutations = {
  INSERT (state, users) {
    insert(state.users, users)
  },

  MESSAGE (state, { id, messages, page }) {
    const user = binarySearchFind(state.users, id)
    const old = state.unread[user.id] || 0
    state.unread[user.id] = user.$unread_count

    // Insert and update user unread status
    insert(user.$messages, messages)

    const unread = user.$messages.filter(m => m.unread).length

    state.unread.$total += unread - old
    state.unread[user.id] += unread - old
    user.$unread_count += unread - old
    user.$has_unread = user.$unread_count > 0
    user.$messages_loaded = true

    if (page) {
      user.$messages_page = page
    }
  },

  MESSAGE_READ (state, { id, message }) {
    const user = binarySearchFind(state.user, id)
    const msg = binarySearchFind(user.$messages, message)

    msg.unread = true
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
  },

  MESSAGE_FAILED (state, { id, message, error }) {
    const user = binarySearchFind(state.users, id)
    const msg = binarySearchFind(user.$messages, message)

    msg.$status = {
      failed: true,
      message: error.message || 'Message failed due to some unknown error',
      error
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

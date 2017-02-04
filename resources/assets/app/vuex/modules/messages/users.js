import http from '../../api'
import { toArray } from '../../../util'
import { insert, binarySearchIndex, binarySearchFind } from '../../helpers'
import { TIMESTAMP, prepare as prepareUser, dateChangesAt } from './helpers'

const actions = {
  async index ({ dispatch }, page = 1) {
    const { users, meta } = await http.get('me/messages/users', { params: { page }})

    if (users) await dispatch('addToStore', users)

    return { users, meta }
  },

  async find ({ dispatch }, id) {
    const { user } = await http.get(`me/messages/users/${id}`)

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

    const { messages, meta } = http.get(`me/messages/${user.id}`, options)

    if (messages) {
      const payload = {
        id: user.id,
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
      const payload = await http.post(true, `me/messages/${id}`, { content, ...extras })

      commit('MESSAGE_SENT', { id, message, payload })

      return { message: payload }
    } catch (error) {
      commit('MESSAGE_FAILED', { id, message, error })

      return { error }
    }
  },

  async read ({ commit }, { id, messages }) {
    const response = await http.put(`me/messages/${id}/messages/read`, { ids: messages.map(message => message.id) })

    if (!response) {
      messages.forEach(message => commit('MESSAGE_READ', { id, message }))
    }
  },

  // -------
  async addToStore ({ commit }, users) {
    if (users) commit('INSERT', users)

    return users
  }
}

const getters = {
  users: state => state.users,

  userById: state => id => binarySearchFind(state.users, id),

  unreadByUserId: state => id => state.unread[id],

  messagesByUserId: (state, getters) => {
    return (id) => {
      const user = getters.userById(id)
      const messages = []
      for (let i = 0; i < user.$messages.length; i += 1) {
        const prev = i > 0 ? messages[i - 1] : null
        const current = user.$messages[i]
        const $dateChanges = dateChangesAt(current, prev)
        const $continued = prev && // Not first message
            !$dateChanges && // Not first message of the day
            current.attachments.length === 0 && // Has no attachments
            current.sender.id === prev.sender.id // From same sender

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

const state = () => ({
  users: [],

  unread: {
    $total: 0
  }
})

const mutations = {
  INSERT (state, users) {
    insert(state.users, users)
  }
}

export default {
  namespaced: true,
  actions,
  mutations,
  state: state()
}

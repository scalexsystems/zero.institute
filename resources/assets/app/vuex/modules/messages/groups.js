import http from '../../api'
import { toArray } from '../../../util'
import { insert, binarySearchIndex, binarySearchFind } from '../../helpers'
import { TIMESTAMP, dateChangesAt } from './helpers'

const actions = {

  // ------- LOCAL ACTIONS ------
  async addToStore ({ dispatch }, groups) {
    dispatch('groups/addToStore', groups, { root: true })
  },
}


/**
 * GETTERS
 */
const getters = {
  _groups: (_, __, state) => state.groups.groups.filter(group => group.is_member),

  groups: (_, getters) => getters._groups.filter(group => group.type === 'group'),

  courses: (_, getters) => getters._groups.filter(group => group.type === 'course'),

  groupById: (_, getters) => id => getters._groups.find(group => group.id === id),

  unreadByGroupId: state => id => state.unread[id],

  messagesByGroupId (_, getters) {
    return (id) => {
      const group = getters.groupById(id)
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
   * Tracks unread messages.
   *
   * @type {Object.<int,int>}
   */
  unread: {
    $total: 0
  }
})

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

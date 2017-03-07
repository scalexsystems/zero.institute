import http from '../api'
import { insert, remove, binarySearchFind } from '../helpers'
import { isArray } from '../../util'
import moment from 'moment'

const actions = {

  async index ({ dispatch }, { page = 1, q } = {}) {
    const { fee_sessions, meta } = await http.get('finance/fee/sessions', { query: { page, q } })

    if (fee_sessions) dispatch('addToStore', fee_sessions)

    return { fee_sessions, meta }
  },

  async find ({ dispatch }, id) {
    const { fee_session } = await http.get(`finance/fee/sessions/${id}`)

    if (fee_session) dispatch('addToStore', [fee_session])

    return { fee_session }
  },

  async store ({ dispatch }, attributes) {
    try {
      const { fee_session } = await http.post(true, 'finance/fee/sessions', attributes)

      dispatch('addToStore', [fee_session])

      return { fee_session }
    } catch (e) {
      return e
    }
  },

  async update ({ dispatch }, { id, attributes }) {
    try {
      const { fee_session } = await http.put(true, `finance/fee/sessions/${id}`, attributes)

      dispatch('addToStore', [fee_session])

      return { fee_session }
    } catch (e) {
      return e
    }
  },

  async delete ({ dispatch }, id) {
    try {
      await http.delete(true, `finance/fee/sessions/${id}`)

      dispatch('removeFromStore', id)

      return true
    } catch (e) {
      return e
    }
  },

  addToStore({ commit }, sessions) {
    if (isArray(sessions)) commit('INSERT', sessions)

    return sessions
  },

  removeFromStore ({ commit }, session) {
    commit('REMOVE', session)
  }

}

const now = new Date()

const getters = {
  sessions: state => state.sessions,

  active: state => state.sessions.filter(session =>
      moment(session.started_at, moment.ISO_8601, true).isBefore(now) &&
      moment(session.ended_at, moment.ISO_8601, true).isAfter(now)
  ),

  feeSessionById: state => id => binarySearchFind(state.sessions, id),

  future: state => state.sessions.filter(session => moment(session.started_at, moment.ISO_8601, true).isAfter(now)),

  old: state => state.sessions.filter(session => moment(session.ended_at, moment.ISO_8601, true).isBefore(now)),
}

const state = () => ({
  sessions: []
})

const mutations = {
  INSERT (state, sessions) {
    insert(state.sessions, sessions)
  },

  REMOVE (state, session) {
    remove(state.sessions, session)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations,
}
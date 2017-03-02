import http from '../api'
import sortBy from 'lodash.sortby'
import { insert, remove, binarySearchFind } from '../helpers'
import { notLastPage } from '../../util'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { courses, meta } = await http.get('courses', { params: { page } })

    if (courses) await dispatch('addToStore', courses)

    if (notLastPage(meta)) {
      dispatch('index', { page: page + 1 })
    }

    return { courses, meta }
  },

  async find ({ dispatch }, id) {
    const { course } = await http.get(`courses/${id}`)

    if (course) await dispatch('addToStore', [course])

    return { course }
  },

  async store ({ dispatch }, payload) {
    try {
      const { course } = await http.post(true, 'courses', payload)

      if (course) await dispatch('addToStore', [course])

      return { course }
    } catch (e) {
      return e
    }
  },

  async update ({ dispatch }, { id, payload }) {
    try {
      const { course } = await http.put(true, `courses/${id}`, payload)

      if (course) await dispatch('addToStore', [course])

      return { course }
    } catch (e) {
      return e
    }
  },

  async my ({ dispatch }, { page = 1 } = {}) {
    const { course_sessions, meta } = await http.get('me/courses')

    if (course_sessions) await dispatch('addSessionsToStore', course_sessions)

    if (notLastPage(meta)) {
      dispatch('my', { page: page + 1 })
    }

    return { course_sessions, meta }
  },

  async enrollments ({ commit, dispatch, getters }, id) {
    if (!getters.sessionById(id)) {
      await dispatch('myFind', id)
    }

    const session = getters.sessionById(id)

    const { students } = await http.get(`courses/${session.course_id}/sessions/${session.id}/enrolled`)

    if (students) commit('SESSION_STUDENTS', { id, students })

    return { students }
  },

  async enroll (_, { session, student }) {
    try {
      await http.post(true, `courses/${session.course_id}/sessions/${session.id}/enroll`, { student })

      return true
    } catch (e) {
      return e
    }
  },

  async expel (_, { session, student }) {
    try {
      await http.post(true, `courses/${session.course_id}/sessions/${session.id}/expel`, { student })

      return true
    } catch (e) {
      return e
    }
  },

  async updateSession ({ dispatch }, { session, payload }) {
    try {
      const { course_session } = await http.put(true, `courses/${session.course_id}/sessions/${session.id}`, payload)

      dispatch('addSessionsToStore', [course_session])

      return { course_session }
    } catch (e) {
      return e
    }
  },

  async addToStore ({ commit }, items) {
    if (items) commit('INSERT', items)
  },

  async addSessionsToStore ({ commit }, items) {
    if (items) {
      commit('INSERT_SESSION', items.map(item => ({ ...item, $students: null })))
    }
  }
}

const getters = {
  courses: state => sortBy(state.courses, 'name'),

  courseById: state => (id) => binarySearchFind(state.courses, id),

  sessions: state => sortBy(state.sessions, 'name'),

  sessionById: state => (id) => binarySearchFind(state.sessions, id),

  sessionsBySemester: state => (semesterId) => state.sessions.filter(session => session.semester_id === semesterId)
}

const state = () => ({
  courses: [],
  sessions: []
})

const mutations = {
  INSERT (state, courses) {
    insert(state.courses, courses)
  },

  REMOVE (state, id) {
    remove(state.courses, id)
  },

  INSERT_SESSION (state, sessions) {
    insert(state.sessions, sessions)
  },

  REMOVE_SESSION (state, id) {
    remove(state.sessions, id)
  },

  SESSION_STUDENTS (state, { id, students }) {
    const session = binarySearchFind(state.sessions, id)

    session.$students = students
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}

import http from '../api'
import sortBy from 'lodash.sortby'
import { insert, remove, binarySearchFind } from '../helpers'
import { notLastPage, each } from '../../util'

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

  async my ({ dispatch }, { page = 1 } = {}) {
    const { sessions, meta } = await http.get('me/courses')

    if (sessions) await dispatch('addSessionsToStore', sessions)

    if (notLastPage(meta)) {
      dispatch('my', { page: page + 1 })
    }

    return { sessions, meta }
  },

  async myFind ({ dispatch }, id) {
    const { session } = await http.get(`me/courses/${id}`)

    if (session) await dispatch('addSessionsToStore', [session])

    return { session }
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

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  },

  async addSessionsToStore ({ commit, dispatch, getters }, items) {
    if (items) {
      commit('INSERT_SESSION', items.map(item => ({ ...item, $students: null })))
    }
  }
}

const getters = {
  courses: state => state.courses,

  courseById: state => (id) => binarySearchFind(state.courses, id),

  sessions: state => sortBy(state.sessions, 'name'),

  sessionById: state => (id) => binarySearchFind(state.sessions, id),
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
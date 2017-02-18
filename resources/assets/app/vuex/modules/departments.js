import http from '../api'
import sort from 'lodash.sortby'
import { insert, remove, binarySearchFind } from '../helpers'

const actions = {
  async index ({ dispatch }, { page = 1 } = {}) {
    const { departments, meta } = await http.get('departments', { params: { page } })

    if (departments) await dispatch('addToStore', departments)

    if (meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages) {
      dispatch('index', { page: page + 1 })
    }

    return { departments, meta }
  },

  async find ({ dispatch }, id) {
    const { department } = await http.get(`departments/${id}`)

    if (department) await dispatch('addToStore', [department])

    return { department }
  },

  async store ({ dispatch }, payload) {
    try {
      const { department } = await http.post(true, 'departments', payload)

      await dispatch('addToStore', [department])

      return { department }
    } catch (e) {
      return e
    }
  },

  async update ({ dispatch }, { id, payload} ) {
    try {
      const { department } = await http.put(true, `departments/${id}`, payload)

      await dispatch('addToStore', [department])

      return { department }
    } catch (e) {
      return e
    }
  },

  async addToStore({ commit }, items) {
    if (items) commit('INSERT', items)
  }
}

const getters = {
  departments: state => sort(state.departments.slice(), 'name'),

  academic: (_, getters) => getters.departments.filter(d => d.academic),

  departmentById: state => (id) => binarySearchFind(state.departments, id),
}

const state = () => ({
  departments: []
})

const mutations = {
  INSERT (state, departments) {
    insert(state.departments, departments)
  },

  REMOVE (state, id) {
    remove(state.departments, id)
  }
}

export default {
  namespaced: true,
  actions,
  getters,
  state: state(),
  mutations
}
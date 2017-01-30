import http from '../api'

const actions = {
  index ({ dispatch }, page = 1) {
    const data = http.get('groups', { params: { page } })

    dispatch('INSERT', data.groups)

    return data
  }
}

const getters = {
  groups: state => state.groups.fitler(group => group.type === 'group'),
  courses: state => state.groups.filter(group => group.type === 'course'),
  group: state => (id => state.groups.find(group => group.id === id)),
  unread: state => (id => state.unread[id])
}

const state = () => {
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
  },
}

const mutations = {}

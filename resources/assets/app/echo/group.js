export default {
  // GroupCreated ({ group_id }, store) {},

  Updated ({ group }, store) {
    store.dispatch('groups/find', group)
  },

  Deleted ({ group }, store) {
    store.commit('groups/REMOVE', group)
  }
}

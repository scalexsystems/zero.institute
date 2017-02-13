export default {
  // GroupCreated ({ group_id }, store) {},

  GroupUpdated ({ group_id }, store) {
    store.dispatch('groups/find', group_id)
  },

  GroupDeleted ({ group_id }, store) {
    store.commit('groups/REMOVE', group_id)
  }
}

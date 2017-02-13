export default {
  NewMessage (message, store, _, group) {
    if (group && group._type === 'group') {
      store.dispatch('groups/addMessageToGroup', { id: group.id, messages: [message] })
    }
  }
}

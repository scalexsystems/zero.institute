export default {
  Created (message, store) {
    const sender = message.sender
    if (sender._type === 'group') {
      store.dispatch('groups/addMessageToGroup', { id: sender.id, messages: [message] })
    } else if (sender._type === 'user') {
      store.dispatch('messages/addMessageToUser', { id: sender.id, messages: [message] })
    }
  }
}

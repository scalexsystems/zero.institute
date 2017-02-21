export default {
  Created (message, store) {
    const receiver = { _type: message.receiver_type, id: message.receiver_id }

    if (store.state.state.user.id === message.sender.id) {
      message.unread = false
      message.read_at = new Date().toISOString()
    }

    if (receiver._type === 'group') {
      store.dispatch('groups/addMessageToGroup', { id: receiver.id, messages: [message], isNew: true })
    } else if (receiver._type === 'user') {
      store.dispatch('messages/addMessageToUser', { id: message.sender.id, messages: [message], isNew: true })
    }
  }
}

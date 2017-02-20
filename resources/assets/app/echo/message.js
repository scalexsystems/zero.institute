export default {
  Created (message, store) {
    const receiver = { _type: message.receiver_type, id: message.receiver_id }
    console.log('on new message', receiver, message)
    if (receiver._type === 'group') {
      store.dispatch('groups/addMessageToGroup', { id: receiver.id, messages: [message], isNew: true })
    } else if (receiver._type === 'user') {
      store.dispatch('messages/addMessageToUser', { id: message.sender.id, messages: [message], isNew: true })
    }
  }
}

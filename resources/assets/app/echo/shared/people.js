export function PhotoUpdated({ user, photo }, store) {
  // Fetch latest if user is there in messages.
  if (store.getters['messages/userById'](user)) {
    store.dispatch('messages/find', user)
  }

  // If it's me update the photo.
  if (store.state.user.id === user) {
    store.commit('PHOTO', photo)
  }
}
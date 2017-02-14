import store from '../vuex'

export default {
  TeacherPhotoUpdated ({ user_id, photo }) {
    // Fetch latest if user is there in messages.
    if (store.getters.messages.userById(user_id)) {
      store.dispatch('messages/find', user_id)
    }

    // If it's me update the photo.
    if (store.state.user.id === user_id) {
      store.commit('PHOTO', photo)
    }
  }
}
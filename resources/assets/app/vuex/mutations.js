import { keepLocals } from './helpers'

export const state = () => ({
  user: window.Laravel ? window.Laravel.user : null
})

export default {
  ME (state, user) {
    state.user = keepLocals(user, state.user)
  },

  PHOTO (state, photo) {
    state.user.photo = photo
  }
}

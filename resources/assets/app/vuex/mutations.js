import { keepLocals } from './helpers'

export const state = () => ({
  user: window.Laravel ? window.Laravel.user : null
})

export default {
  ME (state, user) {
    state.user = keepLocals(user, state.user)
  }
}
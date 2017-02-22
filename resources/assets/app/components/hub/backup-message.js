export default {

  methods: {

    restoreMessage (route) {
      route = route || this.$route
      this.$debug(`restore - ${route.path}`)
      this.message = sessionStorage.getItem(`message-composer:${route.path}`) || ''
    },

    backupMessage () {
      this.$debug(`backup - ${this.$route.path}`)
      if (this.value) {
        sessionStorage.setItem(`message-composer:${this.$route.path}`, this.message)
      }
      this.message = ''
    },

    clearMessage () {
      this.$debug(`clear - ${this.$route.path}`)
      this.message = ''
      sessionStorage.removeItem(`message-composer:${this.$route.path}`)
    }
  },

  beforeDestroy () {
    this.backupMessage()
  },

  created () {
    this.restoreMessage()
  },

  beforeRouteUpdate (to, from, next) {
    this.backupMessage()
    this.restoreMessage(to)

    next()
  },

  beforeRouteLeave (_, __, next) {
    this.backupMessage()

    next()
  }
}
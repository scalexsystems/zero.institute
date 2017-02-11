import { mapGetters, mapActions } from 'vuex'

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },

  computed: {
    user () {
      return this.userById(this.id)
    },
    ...mapGetters('messages', ['userById'])
  },

  methods: mapActions('messages', { find: 'find' }),

  created () {
    if (!this.userById(this.id)) {
      this.find(this.id)
    }
  },

  watch: {
    id (id) {
      if (!this.userById(id)) {
        this.find(id)
      }
    }
  }
}

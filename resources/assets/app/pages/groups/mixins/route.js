import { mapGetters, mapActions } from 'vuex'

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },

  computed: {
    group () {
      return this.groupById(this.id)
    },
    ...mapGetters('groups', ['groupById'])
  },

  methods: mapActions('groups', { find: 'find' }),

  created() {
    if (!this.groupById(this.id)) {
      this.find(this.id)
    }
  },

  watch: {
    id (id) {
      if (!this.groupById(id)) {
        this.find(id)
      }
    }
  }
}
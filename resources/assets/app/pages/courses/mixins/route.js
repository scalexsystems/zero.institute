import { mapActions, mapGetters } from 'vuex'

export default {
  props: {
    id: {
      type: Number,
      required: true
    }
  },

  computed: {
    course () {
      return this.courseById(this.id)
    },
    ...mapGetters('courses', ['courseById'])
  },

  methods: mapActions('courses', ['find']),

  created () {
    if (!this.course) {
      this.find(this.id)
    }
  },

  watch: {
    id (id) {
      if (!this.courseById(id)) {
        this.find(this.id)
      }
    }
  }
}

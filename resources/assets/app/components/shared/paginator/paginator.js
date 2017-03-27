export default {
  props: {
    top: {
      type: Boolean,
      default: false
    },

    bottom: {
      type: Boolean,
      default: false
    },

    value: {
      type: Object,
      required: true
    }
  },

  data: () => ({ waiting: false }),

  methods: {
    onNext () {
      this.emit('next')
    },

    onPrev () {
      this.emit('prev')
    },

    emit (event) {
      if (this.waiting) return

      this.waiting = true
      this.$emit(event, {
        done: () => {
          this.waiting = false
        }
      })
    }
  },

  created () {
    if (this.bottom) {
      this.emit('next')
    } else if (this.top) {
      this.emit('prev')
    }
  }
}
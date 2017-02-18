export default {

  props: {
    source: {
      type: Object,
      required: true
    },

    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    waiting: false
  }),

  methods: {
    onEdit () {
      this.$refs.edit.$emit('edit')
      this.$emit('editing')
    },

    onSave () {
      this.waiting = true
      this.$refs.edit.$emit('save')
      this.$emit('edited')
    },

    onUpdated () {
      this.waiting = false
    },

    onCancel () {
      this.waiting = false
      this.$emit('edited')
    },

    onSubmit () {
      this.$refs.form.$emit('submit')
    },

    resetFormButtons () {
      this.$refs.form.$emit('error')
      this.$emit('editing')
      this.waiting = false
    }
  }
}

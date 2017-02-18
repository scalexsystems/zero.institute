import { formHelper } from 'bootstrap-for-vue'

export default {

  props: {
    submit: {
      type: Function,
      required: true
    }
  },

  methods: {

    async save () {
      const { errors, response } = await this.callAPI()

      if (errors) {
        this.formErrors = errors
        this.formStatus = errors.$message
      } else if (response) {
        this.formStatus = 'Where does this error come from? You may contact support if this persists.'
      } else {
        this.$emit('updated')

        return true
      }

      this.$emit('error')
    }

  },

  created () {
    this.$on('edit', () => {
      this.clearErrors()
      this.prepareAttributes()
    })
    this.$on('save', () => {
      this.clearErrors()
      this.save()
    })
  },

  mixins: [formHelper]
}

import  { formHelper } from 'bootstrap-for-vue'
import { isFunction, isObject, isBoolean } from '../../util'

export default {

  provide () {
    return {
      formState: this
    }
  },

  methods: {

    resetAttributes () {
      this.attributes = this.$options.data().attributes
    },

    async onFormSubmit () {
      this.clearErrors()

      const item = this.$options.resource

      if (isFunction(this.onUpdate)) {
        const response = await this.onUpdate()

        if (isObject(response) && response[item]) {
          this.onUpdated(response[item])
        } else if (isObject(response) && response.errors) {
          this.setErrors(response.errors)
          this.formStatus = response.errors.$message
        } else {
          this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
        }
      } else if (isFunction(this.onCreate)) {
        const response = await this.onCreate()

        if (isObject(response) && response[item]) {
          this.onCreated(response[item])
          this.resetAttributes()
        } else if (isObject(response) && response.errors) {
          this.setErrors(response.errors)
          this.formStatus = response.errors.$message
        } else {
          this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
        }
      } else {
        throw new Error('Resource component should have create or update method.')
      }
    },

    async onFormDelete () {
      if (!isFunction(this.onDelete)) {
        this.$debug('<warn>Define onDelete method.</warn>')

        return
      }

      this.clearErrors()

      const response = await this.onDelete()

      if (isBoolean(response)) {
        this.onDeleted()
        this.resetAttributes()
      } else if (isObject(response) && response.errors) {
        this.setErrors(response.errors)
        this.formStatus = response.errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

  },

  beforeCreate () {
    if (!('resource' in this.$options)) {
      throw new Error('Resource component should have `resource` option.')
    }
  },

  mixins: [formHelper]
}
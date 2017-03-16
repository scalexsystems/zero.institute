import  { formHelper } from 'bootstrap-for-vue/dist/mixins'
import { isFunction, isObject, isBoolean } from '../../util'

export default {

  provide () {
    const provided = formHelper.provide.call(this)

    provided.onFormSubmit = this.onFormSubmit

    return provided
  },

  methods: {

    resetAttributes () {
      this.attributes = this.$options.data().attributes
    },

    async onFormSubmit () {
      this.clearFormErrors()

      const item = this.$options.resource

      if (isFunction(this.onUpdate)) {
        const response = await this.onUpdate()

        if (isObject(response) && response[item]) {
          this.onUpdated(response[item])
        } else if (isObject(response) && response.errors) {
          this.setFormErrors(response.errors)
          this.setFormStatus(response.errors.$message)
        } else {
          this.setFormStatus('Ah! Oh! This is not expected. Contact support.')
        }
      } else if (isFunction(this.onCreate)) {
        const response = await this.onCreate()

        if (isObject(response) && response[item]) {
          this.onCreated(response[item])
          this.resetAttributes()
        } else if (isObject(response) && response.errors) {
          this.setFormErrors(response.errors)
          this.setFormStatus(response.errors.$message)
        } else {
          this.setFormStatus('Ah! Oh! This is not expected. Contact support.')
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

      this.clearFormErrors()

      const response = await this.onDelete()

      if (isBoolean(response)) {
        this.onDeleted()
        this.resetAttributes()
      } else if (isObject(response) && response.errors) {
        this.setFormErrors(response.errors)
        this.setFormStatus(response.errors.$message)
      } else {
        this.setFormStatus('Ah! Oh! This is not expected. Contact support.')
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

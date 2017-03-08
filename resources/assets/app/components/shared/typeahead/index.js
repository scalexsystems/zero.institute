import student from '../../student/InputStudent.vue'
import employee from '../../employee/InputEmployee.vue'

const components = {
  employee,
  student
}

export default {
  functional: true,

  props: {
    dataType: {
      type: String,
      required: true,
      validator (type) {
        return type in components
      }
    }
  },

  render (h, ctx) {
    const component = components[ctx.props.dataType]

    return h(component, ctx.data, ctx.children)
  }
}
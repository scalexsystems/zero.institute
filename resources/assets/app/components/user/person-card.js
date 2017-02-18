import StudentCard from '../student/Card.vue'
import TeacherCard from '../teacher/Card.vue'
import EmployeeCard from '../employee/Card.vue'

export default {
  functional: true,

  props: {
    person: {
      type: Object,
      required: true
    }
  },

  render (h, ctx) {
    const type = ctx.props.person._type

    ctx.data.props = (ctx.data.props || {})
    ctx.data.props[type] = ctx.props.person

    switch (type) {
      case 'student':
        return h(StudentCard, ctx.data, ctx.children)
      case 'teacher':
        return h(TeacherCard, ctx.data, ctx.children)
      case 'employee':
        return h(EmployeeCard, ctx.data, ctx.children)
    }
  }
}

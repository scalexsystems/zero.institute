export default {
  computed: {
    isStudent () {
      return this.source._type === 'student'
    },

    isTeacher () {
      return this.source._type === 'teacher'
    },

    isEmployee () {
      return this.source._type === 'employee'
    }
  }
}
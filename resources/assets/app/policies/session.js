export default {
  updateSyllabus (user, session) {
    return user.isPerson('teacher', session.instructor_id)
  },

  enrollStudents (user, session) {
    return user.isPerson('teacher', session.instructor_id)
  }
}

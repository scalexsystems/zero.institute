function isMe(user, student) {
  return user.id === student.user_id
}

function canViewStudent(user) {
  return user.hasPermission('people.student.read') || user.hasPermission('people.manage')
}

function canUpdateStudent(user) {
  return user.hasPermission('people.student.write') || user.hasPermission('people.manage')
}

export default {
  viewPersonalInformation () {
    return true
  },

  updatePersonalInformation (user, student) {
    return canUpdateStudent(user)
  },

  viewContactInformation (user, student) {
    return isMe(user, student) || canViewStudent(user)
  },

  updateContactInformation (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  }
}
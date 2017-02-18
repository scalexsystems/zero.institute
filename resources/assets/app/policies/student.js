function isMe(user, student) {
  return user.id === student.user_id
}

function canViewStudent(user) {
  return user.hasPermission('student.read')
}

function canUpdateStudent(user) {
  return user.hasPermission('student.update')
}

export default {
  viewPersonalInformation () {
    return true
  },

  updatePersonalInformation (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  },

  viewContactInformation (user, student) {
    return isMe(user, student) || canViewStudent(user)
  },

  updateContactInformation (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  },

  viewSchoolRelatedInformation (user, student) {
    return isMe(user, student) || canViewStudent(user)
  },

  updateSchoolRelatedInformation (user) {
    return canUpdateStudent(user)
  },

  viewMedicalInformation (user, student) {
    return isMe(user, student) || canViewStudent(user)
  },

  updateMedicalInformation (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  },

  viewGuardianInformation (user, student) {
    return isMe(user, student) || canViewStudent(user)
  },

  updateGuardianInformation (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  },

  updatePhoto (user, student) {
    return isMe(user, student) || canUpdateStudent(user)
  }
}
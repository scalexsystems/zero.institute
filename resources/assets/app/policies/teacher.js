function isMe (user, teacher) {
  return user.id === teacher.user_id
}

function canViewTeacher (user) {
  return user.hasPermission('teacher.read')
}

function canUpdateTeacher (user) {
  return user.hasPermission('teacher.update')
}

export default {
  viewPersonalInformation () {
    return true
  },

  updatePersonalInformation (user, teacher) {
    return isMe(user, teacher) || canUpdateTeacher(user)
  },

  viewContactInformation (user, teacher) {
    return isMe(user, teacher) || canViewTeacher(user)
  },

  updateContactInformation (user, teacher) {
    return isMe(user, teacher) || canUpdateTeacher(user)
  },

  viewSchoolRelatedInformation (user, teacher) {
    return isMe(user, teacher) || canViewTeacher(user)
  },

  updateSchoolRelatedInformation (user) {
    return canUpdateTeacher(user)
  },

  viewMedicalInformation (user, teacher) {
    return isMe(user, teacher) || canViewTeacher(user)
  },

  updateMedicalInformation (user, teacher) {
    return isMe(user, teacher) || canUpdateTeacher(user)
  },

  viewGuardianInformation (user, teacher) {
    return isMe(user, teacher) || canViewTeacher(user)
  },

  updateGuardianInformation (user, teacher) {
    return isMe(user, teacher) || canUpdateTeacher(user)
  },

  updatePhoto (user, teacher) {
    return isMe(user, teacher) || canUpdateTeacher(user)
  }
}

function isMe(user, employee) {
  return user.id === employee.user_id
}

function canViewEmployee(user) {
  return user.hasPermission('employee.read')
}

function canUpdateEmployee(user) {
  return user.hasPermission('employee.update')
}

export default {
  viewPersonalInformation () {
    return true
  },

  updatePersonalInformation (user, employee) {
    return isMe(user, employee) || canUpdateEmployee(user)
  },

  viewContactInformation (user, employee) {
    return isMe(user, employee) || canViewEmployee(user)
  },

  updateContactInformation (user, employee) {
    return isMe(user, employee) || canUpdateEmployee(user)
  },

  viewSchoolRelatedInformation (user, employee) {
    return isMe(user, employee) || canViewEmployee(user)
  },

  updateSchoolRelatedInformation (user) {
    return canUpdateEmployee(user)
  },

  viewMedicalInformation (user, employee) {
    return isMe(user, employee) || canViewEmployee(user)
  },

  updateMedicalInformation (user, employee) {
    return isMe(user, employee) || canUpdateEmployee(user)
  },

  viewGuardianInformation (user, employee) {
    return isMe(user, employee) || canViewEmployee(user)
  },

  updateGuardianInformation (user, employee) {
    return isMe(user, employee) || canUpdateEmployee(user)
  },

  updatePhoto (user, employee) {
    return isMe(user, employee) || canUpdateEmployee(user)
  }
}
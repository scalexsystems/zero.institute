function canUpdateSchool (user) {
  return user.hasPermission('school.update')
}

export default {
  viewContactInformation (user) {
    return canUpdateSchool(user)
  },

  updateContactInformation (user) {
    return canUpdateSchool(user)
  },

  viewSchoolInformation (user) {
    return canUpdateSchool(user)
  },

  updateSchoolInformation (user) {
    return canUpdateSchool(user)
  }
}

import group from './group';
import user from './user';
import course from './course';

export default {
  namespaced: true,
  state: {
    ...group.state,
    ...user.state,
    ...course.state,
  },
  getters: {
    ...group.getters,
    ...user.getters,
    ...course.getters,
  },
  mutations: {
    ...group.mutations,
    ...user.mutations,
    ...course.mutations,
  },
  actions: {
    ...group.actions,
    ...user.actions,
    ...course.actions,
  },
};

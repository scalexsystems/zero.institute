import Hub from './Hub.vue';

import GroupCreate from './GroupCreate.vue';
import GroupEdit from './GroupEdit.vue';
import GroupDirectory from './GroupDirectory.vue';
import GroupMessages from './GroupMessages.vue';
import GroupPreview from './GroupPreview.vue';

import Course from './CoursePage.vue';
import CourseDashboard from './CourseDashboard.vue';
import CourseCreate from './CourseCreate.vue';
import CourseEdit from './CourseEdit.vue';
import CoursePreview from './CoursePreview.vue';

import UserDirectory from './UserDirectory.vue';
import UserMessages from './UserMessages.vue';
import UserPreview from './UserPreview.vue';

import Settings from './Settings.vue';
import Departments from './Departments.vue';
import Disciplines from './Disciplines.vue';
import Semesters from './Semesters.vue';
import CourseManagement from './CourseManagement.vue';
import InstituteDetails from './InstituteDetails.vue';
import Invite from './Invite.vue';

import hubStore from './vuex/store';

export default function (Vue, { store, routes }) {
  store.registerModule('hub', hubStore);
  routes.push(...[
    {
      name: 'hub',
      path: '/hub',
      component: Hub,
      children: [
        // Groups.
        { name: 'hub.group-create', path: 'groups/create', component: GroupCreate },
        { name: 'hub.group-preview', path: 'groups/:group/preview', component: GroupPreview },
        { name: 'hub.group-edit', path: 'groups/:group/edit', component: GroupEdit },
        { name: 'hub.group', path: 'groups/:group', component: GroupMessages },
        { name: 'hub.groups', path: 'groups', component: GroupDirectory },
        { name: 'hub.user-preview', path: 'people/:user/preview', component: UserPreview },
        { name: 'hub.users', path: 'people', component: UserDirectory },
        { name: 'hub.user', path: 'people/:user', component: UserMessages },
        // Courses.
        { name: 'acad', path: 'courses', component: CourseDashboard },
        { name: 'acad.create', path: 'courses/create', component: CourseCreate },
        { name: 'acad.edit', path: 'courses/:course/edit', component: CourseEdit },
        { name: 'acad.course', path: 'courses/:course', component: Course },
        { name: 'acad.course-preview', path: 'courses/:course/preview', component: CoursePreview },
        // Settings.
        { name: 'settings', path: 'settings', component: Settings },
        { name: 'departments', path: 'settings/departments', component: Departments },
        { name: 'disciplines', path: 'settings/disciplines', component: Disciplines },
        { name: 'semesters', path: 'settings/semesters', component: Semesters },
        { name: 'course-management', path: 'settings/courses', component: CourseManagement },
        { name: 'institute-details', path: 'settings/institute', component: InstituteDetails },
        { name: 'send-invites', path: 'settings/invites', component: Invite },
      ],
    },
    { path: '/', redirect: '/hub' },
  ]);
}

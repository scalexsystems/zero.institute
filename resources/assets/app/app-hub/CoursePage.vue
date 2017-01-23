<template>
<div class="group-messages-wrapper">
  <message-box v-if="context"
               :title="course.name"
               subtitle="Click here to open group information"
               :photo="course.session.group.photo"
               type="group"
               @openSubtitle="openTitle"
               @openPhoto="openTitle"
               @openTitle="openTitle">
    <message-list :messages="context.messages"
                  @load-more="getOlderMessages"
                  @seen="markMessagesSeen" ref="messages"></message-list>

    <message-editor slot="footer"ref="input" v-model="message" :dest="`groups/${context.id}/attachment`"
                    @send="send" @focused="markMessagesSeen">
    </message-editor>
  </message-box>

  <loading-placeholder v-else></loading-placeholder>
</div>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex';
import int from 'lodash/toInteger';
import groupHelper from './mixins/group';

export default {
  name: 'Course',
  mixins: [groupHelper],
  computed: {
    course() {
      const courses = this.courses;
      const courseId = int(this.$route.params.course);

      return courses.find(course => course.id === courseId);
    },
    groupId() {
      const course = this.course;

      if (course) {
        return course.session.group.id;
      }

      return undefined;
    },
    ...mapGetters('hub', ['courses']),
  },
  methods: {
    openTitle() {
      this.$router.push({ name: 'acad.course-preview', params: { course: this.course.id } });
    },
    fetchCourse(id) {
      const index = this.courses.findIndex(course => course.id === id);

      if (index > -1) return;

      this.find(id);
    },
    ...mapActions('hub', { find: 'getCourses' }),
  },
  created() {
    this.fetchCourse(int(this.$route.params.course));
  },
  watch: {
    $route(to, from) {
      if (this.message.trim().length) {
        const key = `course.${from.params.course}.message`;

        window.localStorage.setItem(key, this.message);
      }

      const key = `course.${to.params.course}.message`;

      this.message = window.localStorage.getItem(key) || '';

      this.fetchCourse(int(to.params.course));
    },
  },
  beforeRouteEnter(to, from, next) {
    const key = `course.${to.params.course}.message`;

    if (key in window.localStorage) {
      next(vm => vm.$set(vm, 'message', window.localStorage.getItem(key)));
    } else {
      next(vm => vm.$set(vm, 'message', ''));
    }
  },
  beforeRouteLeave(to, from, next) {
    if (this.message.trim().length) {
      const key = `course.${this.course.id}.message`;

      window.localStorage.setItem(key, this.message);
    }

    next();
  },
};
</script>

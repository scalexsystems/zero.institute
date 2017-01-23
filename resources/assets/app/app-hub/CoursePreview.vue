<template>
<div>
  <activity-box v-if="course" class="course-preview"
                v-bind="{ title, subtitle, disableFooter: true }"
                @close="$router.push({ name: 'acad.course', params: { course: course.id } })">

    <div class="container py-2">
      <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
          <div class="row">
            <div class="col-xs-12 text-xs-center">
              <img :src="course.photo || course.session.group.photo" class="course-preview-photo">
            </div>

            <div class="col-xs-12">
              <h2 class="text-xs-center my-2">{{ course.name }}</h2>

              <div class="text-xs-center">
                <a v-if="isInstructor" class="btn btn-primary" @click="onAction" @enrolled="resetInfinite()" role="button" tabindex>Enroll Students</a>
              </div>

              <p></p>
            </div>

            <div class="col-xs-12">
              <div class="input-group input-group-lg">
                <span class="input-group-addon"><i class="fa fa-search" /></span>
                <input class="form-control" type="search" v-model="q" @keyup="search">
              </div>
            </div>

            <div class="col-xs-12">
              <div class="text-xs-center group-preview-member-count">
                <small> {{ course.session.student_count_text }} </small>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-lg-6" v-for="student of students" :key="student.id">
              <item-card :item="student" @open="openProfile(student)"></item-card>
            </div>

            <infinite-scroll class="col-xs-12" :on-infinite="onInfinite" ref="infinite"></infinite-scroll>
          </div>

        </div>
      </div>
    </div>

    <course-enrollment ref="enroll"></course-enrollment>
  </activity-box>

  <loading-placeholder v-else></loading-placeholder>
</div>
</template>

<script lang="babel">
import int from 'lodash/toInteger';
import { mapGetters, mapActions } from 'vuex';
import throttle from 'lodash/throttle';
import InfiniteScroll from 'vue-infinite-loading';

import CourseEnrollment from './components/CourseEnrollment.vue';
import { pushOrMerge as set, isLastRecord } from '../util';
import { LoadingPlaceholder, ActivityBox, PersonCard as ItemCard, ActionMenu, PhotoHolder } from '../components';

export default {
  name: 'CoursePreview',
  components: {
    ActivityBox,
    ActionMenu,
    CourseEnrollment,
    InfiniteScroll,
    ItemCard,
    LoadingPlaceholder,
    PhotoHolder,
  },
  data() {
    return {
      students: [],
      q: '',
      page: 0,
    };
  },
  computed: {
    title() {
      const course = this.course;

      return course ? course.name : '';
    },
    subtitle() {
      return 'Course Information';
    },
    courseId() {
      const route = this.$route;

      return int(route.params.course);
    },
    course() {
      const courses = this.courses;
      const courseId = this.courseId;

      return courses.find(course => course.id === courseId);
    },
    isInstructor() {
      const course = this.course;
      const user = this.user;

      if (course && user) {
        return course.session.instructor_id === user.person.id && user.person._type === 'teacher';
      }

      return false;
    },
    ...mapGetters('hub', ['courses']),
    ...mapGetters(['user']),
  },
  methods: {
    search: throttle(function search() {
      this.page = 0;
      this.onInfinite();
    }),
    fetchCourse() {
      const course = this.course;

      this.students = [];

      if (!course && this.coruseId) {
        this.find(this.courseId);
      }
    },
    onAction() {
      this.$refs.enroll.$emit('open', this.course);
    },
    resetInfinite() {
      this.page = 0;
      this.onInfinite(false);
    },
    onInfinite(fromInfinite = true) {
      const actions = {
        loaded: () => this.$refs.infinite.$emit('$InfiniteLoading:loaded'),
        complete: () => this.$refs.infinite.$emit('$InfiniteLoading:complete'),
        reset: () => this.$refs.infinite.$emit('$InfiniteLoading:reset'),
      };

      if (!fromInfinite) actions.reset();

      this.page += 1;

      this.$http.get(`me/courses/${this.course.id}/enrolled`, { page: this.page })
        .then(response => response.json())
        .then((result) => {
          set(this.students, result.data);
          if (isLastRecord(result)) {
            actions.complete();
          } else {
            actions.loaded();
          }
        })
        .catch(() => actions.complete());
    },
    openProfile(student) {
      this.$router.push({ name: 'hub.user-preview', params: { user: student.user.id } });
    },
    ...mapActions('hub', { find: 'findCourse' }),
  },
  created() {
    this.fetchCourse();
  },
  watch: {
    courseId: 'fetchCourse',
  },
};
</script>

<style lang="scss">
@import "../styles/variables";
@import "../styles/methods";

.course-preview {
  &-photo {
    width: rem(160px);
    height: rem(160px);
    border-radius: 100%;
  }
}
</style>

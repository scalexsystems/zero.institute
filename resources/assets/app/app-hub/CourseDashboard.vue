<template>
  <activity-box title="Manage Courses" subtitle="Add/remove/manage coures">
    <template slot="icon">

    </template>
    <template slot="actions">
      <router-link :to="{ name: 'acad.create' }" class="btn btn-primary">
        <i class="fa fa-fw fa-plus" v-tooltip="'Add Course'"></i> <span class="hidden-md-down">Add Course</span></router-link>
    </template>
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
          <div class="row">
            <div class="col-xs-12 py-2">
              <div class="input-group input-group-lg">
                  <span class="input-group-addon"><i class="fa fa-search"></i></span>
                  <input class="form-control" type="search" v-model="q" @keyup="$emit('search', q)" placeholder="Search courses">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-lg-6" v-for="course in courses">
              <div class="card card-block" @click="openCourse(course)" role="button">
                <h6>{{ course.name }} <small>({{ course.code }})</small></h6>
                <small v-for="instructor in course.instructors.data" class="text-muted d-block">{{ instructor.name }}</small>
                <small v-if="!course.instructors.data.length" class="text-muted d-block"> Instructor not assigned </small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <modal :show="showCourse" @hide="course = null">
      <div class="card card-block" v-if="course">
        <div class="card-title text-primary course-title">{{ course.name }}</div>
        <div class="small">
          {{ department }} &centerdot; {{ discipline }} &centerdot; {{ course.year_text }} &centerdot; {{ semester }}
        </div>

        <div class="text-muted pt-2">
          Course Instructor
        </div>
        <div class="row">
          <div v-for="instructor in course.instructors.data" class="col-xs-12 col-lg-6">
            <person-card :item="instructor"></person-card>
          </div>
        </div>

        <div v-if="course.prerequisites.data.length">
          <div class="text-muted pt-2">
            Course Prerequisites
          </div>
          <div class="row">
            <div class="col-xs-12 col-lg-6" v-for="p in course.prerequisites.data">
              <div class="card card-block">
                <h6>{{ p.course.name }}</h6>
                <small class="text-muted d-block">{{ p.course.code }}</small>
              </div>
            </div>
          </div>
        </div>

        <div class="pt-2">
          <router-link class="btn btn-secondary" :to="{ name: 'acad.edit', params: { course: course.id } }">Update Details</router-link>
        </div>
      </div>
    </modal>
  </activity-box>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex';

import { ActivityBox, Modal, PersonCard } from '../components';

export default {
  name: 'CourseDashboard',
  components: { ActivityBox, Modal, PersonCard },
  data() {
    return { q: '', course: null };
  },
  created() {
    if (!this.courses.length) {
      this.getCourses();
    }
  },
  computed: {
    showCourse() {
      return this.course !== null;
    },
    department() {
      const course = this.course;
      const departments = this.departments;

      if (course) {
        return (departments.find(d => course.department_id === d.id) || {}).name;
      }

      return '';
    },
    discipline() {
      const course = this.course;
      const disciplines = this.disciplines;

      if (course) {
        return (disciplines.find(d => course.discipline_id === d.id) || {}).name;
      }

      return '';
    },
    semester() {
      const course = this.course;
      const semesters = this.semesters;

      if (course) {
        return (semesters.find(semester => semester.id === course.semester_id) || {}).name;
      }

      return '';
    },
    ...mapGetters('school', ['courses', 'departments', 'disciplines', 'semesters']),
  },
  methods: {
    openCourse(course) {
      this.course = course;
    },
    ...mapActions('school', ['getCourses']),
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/variables';

.course-title {
    font-size: 1.28571rem;
    margin: 0;
}



</style>

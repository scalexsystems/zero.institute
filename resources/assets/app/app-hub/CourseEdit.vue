<template>
  <div>
    <activity-box title="Edit Course" subtitle="This would update course details." @close="$router.push({ name: 'acad' })" v-show="hasCourse">

      <template slot="actions">
        <a class="btn btn-primary" role="button" tabindex @click.prevent.stop="updateCourse" ref="action">
          <i class="fa fa-fw fa-save hidden-lg-up" v-tooltip:bottom="'Update Course'"></i> <span class="hidden-md-down">Update Course</span>
        </a>
      </template>

      <div class="container py-2">
        <div class="row">
          <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="row">

              <div class="col-xs-12">
                <input-text title="Course Name" required v-model="course.name" :feedback="errors.name"></input-text>
              </div>

              <div class="col-xs-12 col-lg-6">
                <input-text title="Course code" required v-model="course.code" :feedback="errors.code"></input-text>
              </div>
              <div class="col-xs-12 col-lg-6">
                <input-select title="Department" required v-model.number="course.department_id" :feedback="errors.department_id" :options="departments" />
              </div>

              <div class="col-xs-12 col-lg-4">
                <input-select title="Discipline" v-model.number="course.discipline_id" :feedback="errors.discipline_id" :options="disciplines" />
              </div>
              <div class="col-xs-12 col-lg-4">
                <input-select title="Year" v-model.number="course.year_id" :feedback="errors.year_id" :options="years" />
              </div>
              <div class="col-xs-12 col-lg-4">
                <input-select title="Semester" v-model.number="course.semester_id" :feedback="errors.semester_id" :options="semesters" />
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="fl fl-middle">
        <hr class="fl-auto">
        <small class="px-1 text-uppercase">
          Course Instructors
        </small>
        <hr class="fl-auto">
      </div>
      <div class="container py-2">
        <div class="row">
          <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="row">
              <div class="col-xs-12">
                <input-search title="Course Instructor" ref="instructor"
                  subtitle="Course Instructor will be notified. He/she can collaborate with students."
                  v-model="qi" v-bind="{ suggestions: teachers }" @suggest="findInstructor"
                              @select="addInstructor"></input-search>
              </div>
              <div class="col-xs-12 col-lg-6" v-for="instructor in instructors" :key="instructor.id">
                <person-card :item="instructor">
                  <a slot="actions" class="text-muted" href="#" v-tooltip="'Remove'"
                     @click.stop.prevent="removeInstructor(instructor)"
                  ><i class="fa fa-fw fa-trash-o"></i></a>
                </person-card>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="fl fl-middle">
        <hr class="fl-auto">
        <small class="px-1 text-uppercase">
          Pre-requisite Courses
        </small>
        <hr class="fl-auto">
      </div>
      <div class="container py-2">
        <div class="row">
          <div class="col-xs-12 col-lg-8 offset-lg-2">
            <div class="row">
              <div class="col-xs-12">
                <input-search title="Course Name" ref="course"
                  v-model="qc" v-bind="{ suggestions: courses }" @suggest="findPreRequisiteCourse"
                              @select="addPreRequisiteCourse"></input-search>
              </div>
              <div class="col-xs-12 col-lg-6" v-for="course in prerequisites" :key="course.id">
                <div class="card card-block fl">
                  <div class="fl-auto">
                    <h6>{{ course.name }}</h6>
                    <small class="text-muted">{{ course.code }}</small>
                  </div>
                  <a class="text-muted" href="#" v-tooltip="'Remove'"
                     @click.stop.prevent="removePreRequisiteCourse(courses)"
                  ><i class="fa fa-fw fa-trash-o"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="py-3">

      </div>
    </activity-box>

    <loading-placeholder v-if="!hasCourse"></loading-placeholder>
  </div>
</template>

<script>
import throttle from 'lodash/throttle';
import int from 'lodash/toInteger';
import { mapGetters, mapActions } from 'vuex';

import { actions, getters } from '../vuex/meta';
import { mapObject } from '../util';
import { ActivityBox, PersonCard, LoadingPlaceholder } from '../components';

export default {
  name: 'CourseEdit',
  data() {
    return {
      qi: '',
      qc: '',
      course: {},
      instructors: [],
      prerequisites: [],
      errors: {},
    };
  },
  components: { ActivityBox, PersonCard, LoadingPlaceholder },
  computed: {
    hasCourse() {
      return 'id' in this.course;
    },
    years() {
      return [
        { id: 1, name: 'First Year' },
        { id: 2, name: 'Second Year' },
        { id: 3, name: 'Third Year' },
        { id: 4, name: 'Fourth Year' },
      ];
    },
    departments() {
      return this.allDepartments.filter(department => department.academic);
    },
    ...mapGetters({
      courses: getters.courses,
      teachers: getters.teachers,
      disciplines: getters.disciplines,
      allDepartments: getters.departments,
    }),
    ...mapGetters('school', ['semesters']),
  },
  methods: {
    findInstructor: throttle(function findInstructor({ value, start, end }) {
      start();
      this.findTeachers({ q: value }).then(end);
    }, 400),
    addInstructor(teacher) {
      if (this.instructors.indexOf(teacher) > -1) return;

      this.instructors.splice(0, 1, teacher);
    },
    removeInstructor(teacher) {
      const index = this.instructors.indexOf(teacher);
      if (index > -1) {
        this.instructors.splice(index, 1);
        this.$refs.instructor.$emit('unselect', teacher);
      }
    },
    findPreRequisiteCourse: throttle(function findInstructor({ value, start, end }) {
      start();
      this.findCourses({ q: value }).then(end);
    }, 400),
    addPreRequisiteCourse(course) {
      if (this.prerequisites.indexOf(course) > -1) return;

      this.prerequisites.push(course);
    },
    removePreRequisiteCourse(course) {
      const index = this.prerequisites.indexOf(course);
      if (index > -1) {
        this.prerequisites.splice(index, 1);
        this.$refs.course.$emit('unselect', course);
      }
    },
    updateCourse() {
      // TODO: Add validation.
      const payload = {
        ...mapObject(this.course, ['name', 'code', 'department_id', 'discipline_id', 'year_id', 'semester_id']),
        instructors: this.instructors.map(instructor => instructor.id),
        prerequisites: this.prerequisites.map(course => course.id),
      };

      this.$refs.action.classList.add('disabled');
      this.$http.put(`courses/${this.course.id}`, payload)
        .then(response => response.json())
        .then((course) => {
          this.errors = {};
          this.$store.commit('school/ADD_COURSE', this.course = course);

          setTimeout(() => this.$router.push({ name: 'acad' }), 0);
        })
        .catch(response => response.json())
        .then(result => this.$set(this, 'errors', result.errors))
        .catch(error => error)
        .then(() => this.$refs.action && this.$refs.action.classList.remove('disabled'));
    },
    fetchCourse(id) {
      this.course = {};
      this.instructors = [];
      this.prerequisites = [];
      this.errors = {};

      this.$http.get(`courses/${id}`)
        .then(response => response.json())
        .then((course) => {
          this.course = course;
          this.instructors.push(...course.instructors.data);
          this.prerequisites.push(...course.prerequisites.data.map(p => p.course));
        })
        .catch(response => response);
    },
    ...mapActions({
      findTeachers: actions.getTeachers,
      findCourses: actions.getCourses,
    }),
  },
  watch: {
    $route({ params }) {
      this.fetchCourse(int(params.course));
    },
  },
  created() {
    if (!this.courses.length) {
      this.findCourses();
    }
    if (!this.teachers.length) {
      this.findTeachers();
    }

    this.fetchCourse(int(this.$route.params.course));
  },
};
</script>

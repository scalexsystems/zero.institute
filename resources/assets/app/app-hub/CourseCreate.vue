<template>
  <activity-box title="Create Course" subtitle="This would create a new course." @close="$router.push({ name: 'acad' })">
    <template slot="actions">
      <a class="btn btn-primary" role="button" tabindex @click.prevent.stop="createCourse" ref="action">
        <i class="fa fa-fw fa-save hidden-lg-up" v-tooltip:bottom="'Create Course'"></i> <span class="hidden-md-down">Create Course</span>
      </a>
    </template>

    <div class="container py-2">
      <div class="row">
        <div class="col-xs-12 col-lg-8 offset-lg-2">
          <div class="row">
            <div class="col-xs-12">
              <input-text title="Course Name" required placeholder="enter course name" v-model="course.name" :feedback="errors.name"></input-text>
            </div>

            <div class="col-xs-12 col-lg-6">
              <input-text title="Course code" required placeholder="enter course code" v-model="course.code" :feedback="errors.code"></input-text>
            </div>
            <div class="col-xs-12 col-lg-6">
              <input-select title="Department" required v-model.number="course.department_id" :feedback="errors.department_id" :options="departments"></input-select>
            </div>

            <div class="col-xs-12 col-lg-4">
              <input-select title="Discipline" v-model.number="course.discipline_id" :feedback="errors.discipline_id" :options="disciplines"></input-select>
            </div>
            <div class="col-xs-12 col-lg-4">
              <input-select title="Year" v-model.number="course.year_id" :feedback="errors.year_id" :options="years"></input-select>
            </div>
            <div class="col-xs-12 col-lg-4">
              <input-select title="Semester" v-model.number="course.semester_id" :feedback="errors.semester_id" :options="semesters"></input-select>
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
          </div>
          <div class="row">
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
                   @click.stop.prevent="removePreRequisiteCourse(course)"
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
</template>

<script>
import throttle from 'lodash/throttle';
import { mapGetters, mapActions } from 'vuex';

import { actions, getters } from '../vuex/meta';
import { ActivityBox, PersonCard } from '../components';

export default {
  name: 'CourseCreate',
  data() {
    return {
      qi: '',
      qc: '',
      course: { name: '', code: '', department_id: '', discipline_id: '', year_id: '', semester_id: '' },
      instructors: [],
      prerequisites: [],
      errors: {},
    };
  },
  components: { ActivityBox, PersonCard },
  computed: {
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
      // if (this.instructors.indexOf(teacher) > -1) return;
      // this.instructors.push(teacher);
      if (this.instructors.length) this.removeInstructor(this.instructors[0]);
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
    createCourse() {
      // TODO: Add validation.
      const payload = {
        ...this.course,
        instructors: this.instructors.map(instructor => instructor.id),
        prerequisites: this.prerequisites.map(course => course.id),
      };

      this.$refs.action.classList.add('disabled');
      this.$http.post('courses', payload)
        .then(response => response.json())
        .then((course) => {
          this.course = { name: '', code: '', department_id: null, discipline_id: null, year: null, semester: null };
          this.instructors = [];
          this.prerequisites = [];
          this.errors = {};
          this.$store.commit('school/ADD_COURSE', course);
          this.$router.push({ name: 'acad' });
        })
        .catch(response => response.json())
        .then(result => this.$set(this, 'errors', result.errors))
        .catch(error => error)
        .then(() => this.$refs.action && this.$refs.action.classList.remove('disabled'));
    },
    ...mapActions({
      findTeachers: actions.getTeachers,
      findCourses: actions.getCourses,
    }),
  },
  created() {
    if (!this.courses.length) {
      this.findCourses();
    }
    if (!this.teachers.length) {
      this.findTeachers();
    }
  },
};
</script>

<style lang="scss">
</style>

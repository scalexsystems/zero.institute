<template>
<container-window title="Create Course" subtitle="Add institute courses for students & teachers." @back="$router.go(-1)"
                  back>

  <template slot="buttons">
  <input-button value="Create" @click.native="create" ref="submit"/>
  </template>

  <div class="container-zero mt-3">
    <alert v-if="formStatus" type="danger" v-html="formStatus" v-autofocus/>
  </div>

  <div class="container-zero">
    <form class="row" @submit.prevent="create">
      <input type="submit" hidden>

      <div class="col-12 col-lg-6">
        <input-text title="Name" v-model="attributes.name" autofocus required v-bind="{ errors }"
                    subtitle="Complete course name e.g. Introduction to Computing 1"/>
      </div>

      <div class="col-12 col-lg-6">
        <input-text title="Code" v-model="attributes.code" required v-bind="{ errors }"
                    subtitle="A short name/code for the course e.g. CS50"/>
      </div>

      <div class="col-12 col-lg-6">
        <input-typeahead title="Department" v-model="attributes.department_id" required
                         v-bind="{ errors, suggestions: departments }"
                         subtitle="Offerred by the department."/>
      </div>

      <div class="col-12 col-lg-6">
        <input-typeahead title="Instructor" v-model="attributes.instructor" v-bind="{ suggestions: instructors }"
                         @select="onInstructorSelect" component="SelectOptionUser"
                         @search="onInstructorSearch"/>
      </div>

      <div class="col-12">
        <input-textarea title="Brief description" v-model="attributes.description" v-bind="{ errors }"
                        subtitle="A brief description of the course. This is not course syllabus (Instructors can add course syllabus later)."/>
      </div>

    </form>

  </div>

  <h6 class="split-header mt-3 py-3 text-muted text-uppercase">Prerequisite Courses</h6>

  <div class="container-zero">
    <div class="row">

      <div class="col-12">
        <div class="form-group">
          <label>Prerequisite courses</label>
          <typeahead v-bind="{ suggestions: courses, value: [] }" @select="onCourseSelect"/>
        </div>
      </div>

      <div class="col-12 col-lg-6 mb-3" v-for="course in prerequisites">
        <course-card v-bind="{ course }" remove @remove="onCourseRemove"/>
      </div>

      <div v-if="prerequisites.length === 0" class="col-12 text-center text-muted" style="padding: 27px 0">
        No prerequisite courses.
      </div>

    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import throttle from 'lodash/throttle'
import { formHelper } from 'bootstrap-for-vue'
import { mapGetters, mapActions } from 'vuex'
import CourseCard from '../../components/course/Card.vue'
import TeacherCard from '../../components/teacher/Card.vue'

export default {
  name: 'CourseCreate',

  data: () => ({
    attributes: {
      name: '',
      code: '',
      department_id: '',
      instructor: 0,
      courses: []
    },
    instructor: null,
    teachers: []
  }),

  computed: {
    prerequisites () {
      return this.attributes.courses.map(id => this.courseById(id))
    },
    years () {
      return [
        { id: 1, name: 'First Year' },
        { id: 2, name: 'Second Year' },
        { id: 3, name: 'Third Year' },
        { id: 4, name: 'Fourth Year' }
      ]
    },
    instructors () {
      const instructor = this.instructor
      const teachers = this.teachers

      if (!instructor) return teachers

      const index = teachers.findIndex(teacher => teacher.id === instructor.id)

      if (index > -1) return teachers

      return [instructor].concat(teachers)
    },
    ...mapGetters({
      departments: 'departments/academic',
      disciplines: 'disciplines/disciplines',
      courses: 'courses/courses',
      semesters: 'semesters/semesters',
      courseById: 'courses/courseById'
    })
  },
  methods: {
    processResponse: function (course, errors, response) {
      if (course) {
        this.$router.replace({ name: 'course.show', params: { id: course.id }})
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else if (response) {
        this.formStatus = 'Ah! Oh! This is unexpected. Call support now!'
      }
    },

    async create () {
      this.clearErrors()

      this.$refs.submit.$el.classList.add('disabled')
      const { course, errors, response } = await this.store(this.attributes)
      this.$refs.submit.$el.classList.remove('disabled')

      this.processResponse(course, errors, response)
    },

    onCourseSelect (course) {
      if (this.attributes.courses.indexOf(course.id) < 0) {
        this.attributes.courses.push(course.id)
      }
    },

    onCourseRemove (course) {
      const index = this.attributes.courses.indexOf(course.id)

      if (index > -1) {
        this.attributes.courses.splice(index, 1)
      }
    },
    onInstructorSearch: throttle(async function (q) {
      const { teachers } = await this.search({ q })

      this.teachers = teachers || []
    }),
    onInstructorSelect (instructor) {
      this.instructor = instructor
    },
    ...mapActions('courses', ['index', 'store']),
    ...mapActions('teachers', { search: 'index' })
  },

  created () {
    if (!this.courses.length) {
      this.index()
    }

    this.onInstructorSearch()
  },

  components: { CourseCard, TeacherCard },
  mixins: [formHelper]
}
</script>

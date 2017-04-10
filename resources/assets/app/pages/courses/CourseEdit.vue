<template>
<container-window title="Edit Course" subtitle="Add institute courses for students & teachers." @back="$router.go(-1)"
                  back>

  <template slot="buttons">
  <input-button value="Save" @click.native="save" ref="submit"/>
  </template>

  <div class="container mt-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2 my-2">
        <alert v-if="formStatus" type="danger" v-html="formStatus" v-autofocus/>

        <form class="row">
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
                             @select="onInstructorSelect" component="SelectOption User"
                             @search="onInstructorSearch"/>
          </div>

          <div class="col-12">
            <input-textarea title="Brief description" v-model="attributes.description" v-bind="{ errors }"
                            subtitle="A brief description of the course. This is not course syllabus (Instructors can add course syllabus later)."/>
          </div>

          <h6 class="col-12 my-3 text-center text-uppercase text-muted">Constraints & Requisites</h6>

          <div class="col-12">
            <div class="form-group">
              <label>Prerequisite courses</label>
              <typeahead v-bind="{ suggestions: courses, value: [] }" @select="onCourseSelect"/>
            </div>
          </div>

          <div class="col-12 col-lg-6 mb-3" v-for="course in prerequisites" :key="course">
            <course-card v-bind="{ course }" remove @remove="onCourseRemove"/>
          </div>

          <div v-if="prerequisites.length === 0" class="col-12 text-center text-muted" style="padding: 64px 0">
            No prerequisite courses.
          </div>

        </form>
      </div>
    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import CourseCreate from './CourseCreate.vue'
import { only } from '../../util'
import CourseRoute from './mixins/route'

export default {
  name: 'CourseEdit',

  extends: CourseCreate,

  computed: mapGetters(['school']),

  methods: {
    setAttributes () {
      const course = this.course

      if (!course) return

      const session = (course.sessions || []).find(s => s.session_id === this.school.session_id)
      this.attributes = only(course, Object.keys(this.attributes))
      this.attributes.courses = (course.prerequisites || []).map(c => c.id)
      this.attributes.instructor = session ? session.instructor_id : 0
      this.instructor = session ? session.instructor : null
    },

    async save () {
      this.clearErrors()

      this.$refs.submit.$el.classList.add('disabled')
      const { course, errors, response } = await this.update({ id: this.id, payload: this.attributes })
      this.$refs.submit.$el.classList.remove('disabled')

      this.processResponse(course, errors, response)
    },

    ...mapActions('courses', ['update'])
  },

  created () {
    if (this.course) {
      this.setAttributes()
    }
  },

  mixins: [CourseRoute],

  watch: {
    course: 'setAttributes'
  }
}
</script>


<style lang="scss">
</style>

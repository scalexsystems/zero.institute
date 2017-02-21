<template>
<container-window v-bind="{ title }" subtitle="Course information" back @back="$router.go(-1)">
  <template slot="buttons">
  <router-link :to="{ name: 'course.edit', params: { id } }" class="btn btn-primary">Edit</router-link>
  </template>

  <div class="my-3" v-if="course">
    <div class="container-zero text-center">
      <img :src="course.photo" class="rounded m-3" height="128">
    </div>

    <div class="conatiner-zero text-center">
      <h2 class="mb-1">{{ course.code }} - {{ course.name }}</h2>

      <p>
        <small>{{ department.name }} &centerdot; {{ semester.name || 'Semester not set' }}</small>
      </p>

      <p>{{ course.description }}</p>
    </div>

    <h6 class="split-header my-3 p-3 text-uppercase">Prerequisite Courses</h6>
    <div class="container-zero">

      <div class="row">
        <div class="col-12 col-lg-6 mb-3" v-for="item in course.prerequisites">
          <router-link class="no-link" :to="{ name: 'course.show', params: { id: item.id } }">
            <course-card v-bind="{ course: item }"/>
          </router-link>
        </div>

        <div class="col-12 py-3 mb-3" v-if="course.prerequisites.length === 0">
          <span class="text-muted">No prerequisites</span>
        </div>
      </div>

    </div>

    <h6 class="split-header my-3 p-3 text-uppercase">Sessions</h6>
    <div class="container-zero">

      <div class="row">

        <div class="col-12 col-lg-6 mb-3" v-for="item in course.sessions">
          <session-card v-bind="{ session: item }"/>
        </div>

        <div class="col-12 py-3 mb-3" v-if="course.sessions.length === 0">
          <span class="text-muted">No sessions</span>
        </div>

      </div>

    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import CourseCard from '../../components/course/Card.vue'
import SessionCard from '../../components/course/session/Card.vue'
import TeacherCard from '../../components/teacher/Card.vue'
import CourseRoute from './mixins/route'

export default {
  name: 'Course',

  computed: {
    title () {
      return this.course ? this.course.name : '...'
    },
    department () {
      return this.course ? this.departmentById(this.course.department_id) || {} : {}
    },
    semester () {
      return this.course ? this.semesterById(this.course.semester_id) || {} : {}
    },
    disciplines () {
      const course = this.course

      if (!course) return []

      if (!course.prerequisites) return []

      return course.prerequisites
          .filter(req => req.constraint_type === 'discipline')
          .map(req => this.disciplineById(req.constraint_id))
    },
    ...mapGetters({
      departmentById: 'departments/departmentById',
      disciplineById: 'disciplines/disciplineById',
      semesterById: 'semesters/semesterById'
    })
  },

  components: { CourseCard, SessionCard, TeacherCard },

  mixins: [CourseRoute]
}
</script>

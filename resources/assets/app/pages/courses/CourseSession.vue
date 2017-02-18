<template>
<container-window v-bind="{ title }" subtitle="Course information" back @back="$router.go(-1)">
  <div class="container my-3">
    <div class="row">
      <div class="col-12 col-lg-8 offset-lg-2">
        <div class="row" v-if="course">

          <div class="col-12 text-center">
            <img :src="course.photo" class="rounded m-3" height="128">
          </div>

          <div class="col-12 text-center">
            <h2 class="mb-1">{{ course.code }} - {{ course.name }}</h2>

            <p>
              <small>{{ department.name }} &centerdot; {{ semester.name || 'Semester not set' }}</small>
            </p>

            <p>{{ course.description }}</p>
          </div>

        </div>

        <div class="row" v-if="course && session">
          <div class="col-12 mb-3">
            <div class="card" v-if="session.syllabus">
              <div class="card-block" v-html="session.syllabus | marked"></div>
            </div>
            <div class="text-center" v-else-if="$can('update-syllabus', session)">
              <input-button value="Add Syllabus"/>
            </div>
          </div>

          <div class="col-12 mt-3">
            <enrollment-list :session="session"/>
          </div>
        </div>

        <div class="row" v-else-if="error">
          <div class="col-12">
            <alert type="danger" v-html="error"/>
          </div>
        </div>

        <div class="row" v-else>
          <div class="col-12">
            <loading/>
          </div>
        </div>
      </div>
    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import Course from './Course.vue'
import EnrollmentList from '../../components/course/session/EnrollmentList.vue'

export default {
  name: 'CourseSession',

  extends: Course,

  props: {
    sessionId: {
      type: Number,
      required: true
    }
  },

  computed: {
    session () {
      return this.sessionById(this.sessionId)
    },

    ...mapGetters('courses', ['sessionById'])
  },

  components: { EnrollmentList },

  watch: {
    sessionId (id) {
      if (!this.sessionById(id)) {
        this.$store.dispatch('courses/myFind', id)
      }
    }
  }
}
</script>

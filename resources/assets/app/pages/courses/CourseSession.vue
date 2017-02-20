<template>
<container-window v-bind="{ title }" subtitle="Course information" back @back="$router.go(-1)">

  <template slot="buttons">
  <router-link class="btn btn-primary" :to="{ name: 'course.session.enroll' }">Enroll Students</router-link>
  </template>

  <div class="container-zero my-3">
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
  </div>

  <div class="row" v-if="course && session">
    <div class="container-zero mb-3">
      <div class="card" v-if="session.syllabus">
        <div class="card-header d-flex flex-row align-items-center">
          <h5 class="card-title mb-0">Syllabus</h5>
          <input-button v-if="$can('update-syllabus', session)" class="ml-auto"
                        value="Update" @click.native="$refs.syllabus.$emit('open')"/>
        </div>
        <div class="card-block">
          <div class="p-course-syllabus" v-html="syllabus"></div>
        </div>
      </div>
      <div class="text-center" v-else-if="$can('update-syllabus', session)">
        <input-button value="Add Syllabus" @click.native="$refs.syllabus.$emit('open')"/>
      </div>

      <modal ref="syllabus" :dismissable="false">
        <div class="container-zero">

          <div class="card">
            <div class="card-header d-flex flex-row align-items-center">

              <h4 class="card-title mb-0">Course Syllabus</h4>

              <div class="ml-auto">
                <input-button value="Cancel" class="btn btn-secondary"
                              @click.native="$refs.syllabus.$emit('close')"/>
                <input-button value="Save" @click.native="onUpdateSyllabus"/>
              </div>

            </div>

            <div class="card-block text-left">

              <input-textarea title="Syllabus" v-model="attributes.syllabus" required/>

            </div>
          </div>

        </div>
      </modal>
    </div>

    <enrollment-list class="col-12 mt-3" :session="session"/>

    <div class="col-12" style="margin-bottom: 128px"></div>
  </div>

  <div class="row" v-else>
    <div class="col-12">
      <loading/>
    </div>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import Course from './Course.vue'
import marked from 'marked'
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

  data: () => ({
    attributes: {
      syllabus: ''
    }
  }),

  computed: {
    session () {
      return this.sessionById(this.sessionId)
    },

    syllabus () {
      return marked(this.session.syllabus || '', { sanitize: true })
    },

    ...mapGetters('courses', ['sessionById'])
  },

  methods: {
    async onUpdateSyllabus () {
      await this.updateSession({ session: this.session, payload: this.attributes })

      this.$refs && this.$refs.syllabus.$emit('close')
    },
    ...mapActions('courses', ['updateSession'])
  },

  components: { EnrollmentList },

  watch: {
    sessionId (id) {
      if (!this.sessionById(id)) {
        this.$store.dispatch('courses/myFind', id)
      }
    },
    session (session) {
      this.attributes.syllabus = session.syllabus
    }
  }
}
</script>

<style lang="scss">
.p-course-syllabus {
  h1 {
    font-size: 18px;
  }

  h2 {
    font-size: 16px;
  }

  h3, h4, h5, h6 {
    font-size: 14px;
  }
}
</style>
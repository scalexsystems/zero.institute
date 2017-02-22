<template>
<container-window v-bind="{ title }" subtitle="Enroll students" back @back="$router.go(-1)">

  <div class="row" v-if="course && session">

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
import EnrollmentList from '../../components/course/session/EditEnrollmentList.vue'

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
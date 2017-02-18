<template>
<searchable-list v-model="query" placeholder="Start typing..." ref="list"
                 @infinite="({ complete }) => complete()" class="mb-3" col="col-12">

  <h5 class="text-center" slot="header">Enrolled Students</h5>

  <div class="row">
    <router-link class="col-12 col-lg-6 mt-3 no-link" v-for="student in students" :key="student"
                 :to="{ name: 'student.show', params: { uid: student.uid } }">
      <student-card :student="student"/>
    </router-link>
  </div>
</searchable-list>
</template>

<script lang="babel">
import Sifter from 'sifter'
import { mapActions } from 'vuex'
import StudentCard from '../../student/Card.vue'

export default {
  name: 'CourseSessionEnrollmentList',

  props: {
    session: {
      type: Object,
      required: true
    }
  },

  data: () => ({
    query: ''
  }),

  computed: {
    students () {
      const students = this.session.$students || []
      const index = new Sifter(students)

      const result = index.search(this.query, { fields: ['uid', 'name'] })

      return result.items.map(({ id }) => students[id])
    }
  },

  methods: mapActions('courses', ['enrollments']),

  components: { StudentCard },

  created () {
    if (!this.session.$students) {
      this.enrollments(this.session.id)
    }
  }
}
</script>

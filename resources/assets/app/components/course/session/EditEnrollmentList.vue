<template>

<div class="container-zero">

  <typeahead v-bind="{ suggestions: items, value: [] }"
             component="SelectOptionUser" placeholder="Start typing..."
             @search="onSearch" @select="add"/>

  <div class="row">

    <div class="col-12 mt-3" v-if="error">
      <alert type="danger" v-html="error" dissmissable/>
    </div>

    <div class="col-12 col-lg-6 mt-3" v-for="student in source">

      <student-card :student="student" remove @remove="remove(student)"/>

    </div>

    <div class="col-12 my-3 py-3 text-center text-muted" v-if="source.length === 0">
      No Students
    </div>

  </div>
</div>

</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions, mapGetters } from 'vuex'
import EnrollmentList from './EnrollmentList.vue'
import StudentCard from '../../student/Card.vue'
import { clone } from '../../../util'

export default {
  name: 'EditEnrollmentList',

  extends: EnrollmentList,

  data: () => ({ items: [], error: null }),

  methods: {
    onSearch: throttle(async function (q) {
      const { items } = await this.search({ q, personType: ['student'] })

      this.items = items || []
    }, 400),

    async add (student) {
      if (this.source.findIndex(u => student.id === u.id) > -1) return false

      student = clone(student)

      this.source.push(student)
      student.$wait = true
      this.error = null
      const result = await this.enroll({ session: this.session, student: student.id })

      if (result === true) {
        student.$wait = false
      } else {
        this.error = result.errors.$message

        const index = this.source.findIndex(u => student.id === u.id)

        if (index > -1) this.source.splice(index, 1)
      }
    },

    async remove (student) {
      if (student.$wait === true) return false

      student.$wait = true
      this.error = null
      const result = await this.expel({ session: this.session, student: student.id })
      student.$wait = false

      if (result === true) {
        const index = this.source.findIndex(u => student.id === u.id)

        if (index > -1) this.source.splice(index, 1)
      } else if ('errors' in result) {
        this.error = result.errors.$message
      }
    },

    ...mapActions('people', { search: 'index' }),

    ...mapActions('courses', ['enroll', 'expel'])
  },

  created () {
    this.onSearch('')
  },

  components: { StudentCard }
}
</script>

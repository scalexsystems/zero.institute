<template>
    <div>
      <div class="student-list-wrapper">
          <attendance-card :student="student" v-for="student in students"></attendance-card>
      </div>




    </div>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'StudentList',
  data: () => ({
    students: [],
  }),
  props: {
  },
  computed: {
  },

  methods: {
     async getEnrollments() {
       const { students, meta } = await this.enrollments();
       this.students = students;
     },
    ...mapActions('courses', ['enrollments']),
  },

}
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';


</style>

<template>
    <div>

      <div class="student-list-wrapper">
          <attendance-card :student="student" v-for="student in students" @toggle="toggleAttendance"></attendance-card>
      </div>




    </div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import AttendanceCard  from './Card.vue'


export default {
  name: 'StudentList',
  data: () => ({
    attendance: [],
  }),
  props: {
        students: {
            type: Array,
            required: true
        },
        session: {
          type: Number,
          required: true
        }
    },
    computed: {},
    components: { AttendanceCard },

    methods: {
      toggleAttendance(event, value, studentId){
        if(value) {
          const index = this.attendance.indexOf(studentId);
          if(index) {
            this.attendance.splice(index, 1);
          }
        }
          if (!value) {
          this.attendance.push(studentId);
        }
      },

      submitAttendance() {
        this.store(this.session, this.attendance)
      },

      ...mapActions('attendance', ['store'])
    },
}
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';


</style>

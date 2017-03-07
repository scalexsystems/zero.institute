<template>
    <div>

      <div class="student-list-wrapper">
          <attendance-card :student="student" v-for="student in students"></attendance-card>
      </div>




    </div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import AttendanceCard  from './Card.vue'

export default {
  name: 'StudentList',
  data: () => ({}),
  props: {
        students: {
            type: Array,
            required: true
        }
    },
    computed: {},
    components: { AttendanceCard },

    methods: {},
}
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';


</style>

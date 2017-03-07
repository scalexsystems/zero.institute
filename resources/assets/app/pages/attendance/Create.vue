<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector startDate="01-01-2015"></date-selector>

            <a role="button" href="#" class="btn btn-primary"> Take Attendance </a>
          </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
              <student-list :students="students" :session="id"></student-list>
            </div>
        </div>
    </container-window>
</template>

<script lang="babel">
    import DateSelector from '../../components/attendance/DateSelector.vue'
    import StudentList from '../../components/attendance/StudentList.vue'
    import { mapGetters, mapActions } from 'vuex'


    export default {
        name: 'CreateAttendance',
        components: { DateSelector, StudentList },
        data: () => ({
          students: []
        }),
        props: {
          id: {
            type: Number,
            required: true,
          }
        },
        computed: {
          session() {
            return this.sessionById(this.id)
          },
          ...mapGetters('courses', ['sessionById'])

        },

        methods: {
          async init() {
            const { students } = await this.enrollments(this.id);
            this.students = students;
          },
            ...mapActions('courses', ['enrollments'])
        },

        created() {
          this.init()
        }



    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

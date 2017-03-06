<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector startDate="01-01-2015"></date-selector>

            <a role="button" href="#" class="btn btn-primary"> Take Attendance </a>
          </div>
        </div>

        <div class="row">
            <!--<student-list></student-list>-->
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
            semester: 0,
            errors: {},
        }),
        props: {
//          id: {
//            type: Number,
//            required: true,
//          }
        },
        computed: {
//          session() {
//            this.sessionById(this.id)
//          },
//          students() {
//                this.enrolled(this.id);
//          },
          ...mapGetters('courses', ['sessionById'])

        },

        methods: {

            ...mapActions('courses' ['enrolled'])
        },



    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

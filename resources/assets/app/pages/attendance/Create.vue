<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector startDate="01-01-2015" v-model="date"></date-selector>

            <div v-if="!enabled">
              <a role="button" class="btn btn-primary" @click.prevent="takeAttendance"> Take Attendance </a>
            </div>
            <div v-else>
                <a role="button" class="btn btn-primary" @click.prevent="cancel"> Cancel </a>
                <a role="button" class="btn btn-primary" @click.prevent="saveAttendance"> Save Attendance </a>
             </div>

            </div>

        </div>

        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2">
                <attendance-card :student="student" v-for="student in students" @toggle="toggleAttendance"></attendance-card>
            </div>
        </div>
    </container-window>
</template>

<script lang="babel">
    import DateSelector from '../../components/attendance/DateSelector.vue'
    import AttendanceCard from '../../components/attendance/Card.vue'
    import { mapGetters, mapActions } from 'vuex'


    export default {
        name: 'CreateAttendance',
        components: { DateSelector, AttendanceCard },
        data: () => ({
          students: [],
          attendance: [],
          enabled: false,
          date: '',
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
          takeAttendance() {
             this.enabled = true;
          },
          cancel() {
             this.enabled = false;
          },
          toggleAttendance(value, studentId){
            debugger;
            if(!value) {
                const index = this.attendance.indexOf(studentId);
                if(index) {
                    this.attendance.splice(index, 1);
                }
             }
             else {
              this.attendance.push(studentId);
             }
            },

            async saveAttendance() {
                const attendance = {
                   date: this.date,
                   attendance: this.attendance,
                };
                const { attendances } = await this.store({ session: this.session, attendance })
            },

            ...mapActions('courses', ['enrollments']),
            ...mapActions('attendance', ['store']),
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

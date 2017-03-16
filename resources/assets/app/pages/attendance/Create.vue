<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <!--<smart-form>-->
        <div class="row py-4">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector min="01-01-2015" class="col-12 col-lg-8 mx-auto" v-model="date"></date-selector>

            <div class="mb-3 text-center py-2">
            <div v-if="!enabled">
              <input-button @click.native="takeAttendance" value="Take Attendance"/>
            </div>
            <div v-else>
                <input-button @click.native="cancel" value="Cancel"/>
                <input-button type="submit" @click.native="saveAttendance" value="Save Attendance"/>
             </div>

            </div>
            </div>

        </div>
        <!--</smart-form>-->

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
          date: new Date().toDateString(),
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
             this.attendance = [];
          },
          toggleAttendance(value, studentId){
            debugger;
            if(value) {
                const index = this.attendance.indexOf(studentId);
                if(index >= 0) {
                    this.attendance.splice(index, 1);
                }
             } else {
              this.attendance.push(studentId);
             }
            },

          async saveAttendance() {
                const attendance = {
                   date: this.date,
                   attendance: this.attendance,
                };

               await this.store({ session: this.session, attendance })
               this.enabled = false;
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

    .switch .slider {
       background-color: $gray-lightest
    }



</style>

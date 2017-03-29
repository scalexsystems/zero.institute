<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <div class="row py-4">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector :min="startDate" class="col-12 col-lg-8 mx-auto" v-model="date"></date-selector>

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

        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2" :class="{ disabled : !enabled }">
                <div class="text-center">
                    Attendance: {{ aggregate.percent }}% | {{ aggregate.total }} Students - {{ aggregate.absent }} Absent
                </div>
                <div class="py-4">
                    <attendance-card :student="student" v-for="student in students" :key="item.id"
                                     @toggle="toggleAttendance" :disabled="!enabled"></attendance-card>

                </div>
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
          startedOn: '',
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
            const session = this.sessionById(this.id);
            this.startDate = session.started_on;
            return session;
          },
          startDate() {
            return this.startedOn;
          },
          aggregate() {
              const total = this.students.length
              const absent = this.attendance.length
              const  percent = (1 - absent / total) * 100
              return {
                  total, absent, percent
              }
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

    .disabled {
       opacity: 0.6;
    }



</style>

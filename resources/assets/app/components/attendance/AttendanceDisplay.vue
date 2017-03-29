<template>
    <div class="row">
      <div class="col-lg-10 m-auto">
         <div class="card">
        <div class="card-header">
            Attendance
        </div>

        <div class="card-block">
           <div class="row">
             <div class="col-6 col-lg-5 mr-3">
                 <input-select title="Semester" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                 <session-list :items="courseSessions" @listClicked="sessionClicked">

                 </session-list>
             </div>

             <div class="col-6 col-lg-6 graph-wrapper align-items-center mx-3 px-2">
                 <contribution-graph v-bind="{ rowHeadings, columnHeadings}" :startDate="activeSession.started_on" :dates="attendance">
                 </contribution-graph>
           </div>
         </div>
       </div>
     </div>
     </div>
    </div>
</template>

<script lang="babel">
    import moment from 'moment'
    import { range } from 'lodash/util'
    import SessionList from './SessionList.vue'
    import { mapGetters, mapActions } from 'vuex'
    import ContributionGraph from './ContributionGraph.vue'

    export default {
        name: 'AttendanceDisplay',
        components: { SessionList, ContributionGraph },
        data: () => ({
            semester: 0,
            errors: {},
            courseSessions: [],
            activeSession: 0,
            attendance: {},
            rowHeadings: ['M', 'T', 'W', 'T', 'F', 'S', 'Su'],
        }),
        props: {
          source: {
            type: Object,
            required: true,
          },
        },
        computed: {
          columnHeadings(){
            const startingWeek = moment(this.activeSession.started_on).isoWeek()
            const startingMonday = moment().day('Sunday').isoWeek(startingWeek - 1)
            const difference = moment(this.activeSession.ended_on).diff(startingMonday, 'weeks') + 1;
            return range(1, difference);
          },

        ...mapGetters('semesters', ['semesters']),
        },

        methods: {
          semesterChosen(semester) {
            this.attendance = {};
            this.getCourseSessions();
          },
          init() {
            const semester = this.semesters[0] || {};
            if(semester) {
              this.semester = semester.id;
              this.semesterChosen();
              if(this.courseSessions.length)
              {
              this.sessionClicked(this.courseSessions[0]);
              }
            }
          },
          async sessionClicked(session){
            this.activeSession = session;
              const dates = {};
              const { attendances } = await this.find({sessionId: session.id, student: this.source});
              if(attendances) {
                  attendances.forEach(data => {
                      Object.assign(dates, ({
                          [data.date]: false
                      }))
                  })
                  this.attendance = dates;
              } else {
                 this.attendance = {};
              }
          },
          async getCourseSessions(){
            const { course_sessions } = await this.forSemesterAndStudent({ semesterId: this.semester, student: this.source});
            this.courseSessions = course_sessions || [];
          },
        ...mapActions('attendance', ['find']),
        ...mapActions('sessions', ['forSemesterAndStudent']),
        },

        created(){
          this.init();
        }
    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

    .card-header {
       margin: 0;
    }
</style>

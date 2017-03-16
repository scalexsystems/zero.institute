<template>
    <div>
      <div class="card">
        <div class="card-header">
            Attendance
        </div>

        <div class="card-block">
           <div class="row">
             <div class="col-6 col-lg-6">
                 <input-select title="Semester" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                 <session-list :items="courseSessions" @listClicked="sessionClicked">

                 </session-list>
             </div>

             <div class="col-6 col-lg-6">
                 <contribution-graph v-bind="{ rowHeadings, columnHeadings}"></contribution-graph>
           </div>
         </div>
       </div>
     </div>
</template>

<script lang="babel">
    import SessionList from './SessionList.vue'
    import { mapGetters, mapActions } from 'vuex'
    import ContributionGraph from './ContributionGraph.vue'

    export default {
        name: 'AttendanceDisplay',
        components: { SessionList, ContributionGraph },
        data: () => ({
            semester: 0,
            errors: {},
            items: {},
            courseSessions: [],
            rowHeadings: ['M', 'T', 'W', 'T', 'F', 'S', 'Su'],
            columnHeadings: ['W1', '2', '3'],
        }),
        props: {
          source: {
            type: Object,
            required: true,
          },
        },
        computed: {

        ...mapGetters('semesters', ['semesters']),
        },



        methods: {
          semesterChosen(event, semester) {
            this.getCourseSessions();
          },
          async sessionClicked(event, session){
            this.activeSession = session;
            const { attendance } = await this.find({session: session, student: this.source});
            this.attendance = attendance;

          },
          async getCourseSessions(){
            const { course_sessions } = await this.forSemesterAndStudent({ semesterId: this.semester, student: this.source});
            this.courseSessions = course_sessions;
          },

        ...mapActions('attendance', ['find']),
        ...mapActions('sessions', ['forSemesterAndStudent']),
        },


    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

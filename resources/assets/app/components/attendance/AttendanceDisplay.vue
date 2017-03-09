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
           </div>
         </div>
       </div>
     </div>
</template>

<script lang="babel">
    import SessionList from './SessionList.vue'
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: 'AttendanceDisplay',
        components: { SessionList },
        data: () => ({
            semester: 0,
            errors: {},
            items: {},
            courseSessions: [],
        }),
        props: {
          source: {
            type: Object,
            required: true,
          },
        },
        computed: {
          semesterList() {
          },
         attendances() {
         },
        ...mapGetters('semesters', ['semesters']),
        },



        methods: {
          semesterChosen(event, semester) {
            this.getCourseSessions();
          },
          sessionClicked(event, session){
            this.activeSession = session;
          },
          async getCourseSessions(){
            const { sessions } = await this.forSemesterAndStudent({ semesterId: this.semester, student: this.source});
            this.courseSessions = [sessions];
          },

        ...mapActions('attendances', ['find']),
        ...mapActions('sessions', ['forSemesterAndStudent']),
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

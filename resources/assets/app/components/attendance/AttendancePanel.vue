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
                 <list :items="courseSessions" @listClicked="sessionClicked">

                 </list>
             </div>
           </div>
         </div>
       </div>
     </div>
</template>

<script lang="babel">
    import List from './List.vue'
    import { mapGetters, mapActions } from 'vuex'

    export default {
        name: 'AttendancePanel',
        components: { List },
        data: () => ({
            semester: 0,
            errors: {},
            items: {},
            courseSessions: [],
        }),
        computed: {
          semesterList() {
          },
         attendances() {
           return this.find();
         },
        ...mapGetters('courses', ['sessions']),
        ...mapGetters('semesters', ['semesters']),
        },



        methods: {
          semesterChosen(event, semester) {
            this.getCourseSessions();
          },
          sessionClicked(event, session){
            this.activeSession = session;
          },
          getCourseSessions(){
            const sessions = this.sessions;
            this.items = sessions ? Object.keys(sessions).filter(key => sessions[key].semester_id === this.semester) : {};
            this.courseSessions = [sessions];
          },

        ...mapActions('attendances', ['find']),
        ...mapActions('courses', ['my']),
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

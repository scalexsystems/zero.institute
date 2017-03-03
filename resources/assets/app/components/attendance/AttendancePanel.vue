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
           return this.find();
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
            debugger;
            const { sessions } = await this.forSemesterAndStudent(this.semester, this.source);
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

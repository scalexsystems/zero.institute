<template>
    <div>
      <div class="card">
        <div class="card-header">
            Attendance
        </div>

        <div class="card-block">
           <div class="row">
             <div class="col-6 col-lg-6">
                 <input-select title="Semester" v-model.number="semester" :options="semesters" />
                 <list :items="sessions" @listClicked="sessionClicked">

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
        }),
        computed: {
          semesterList() {
          },
          items() {
          },
         sessions(){
           return this.sessionsBySemester(this.semester);
         },
         attendances() {
           return this.find();
         },
        ...mapGetters('courses', ['sessionsBySemester']),
        ...mapGetters('semesters', ['semesters']),
        },



        methods: {
          sessionClicked(event, session){
            this.activeSession = session;
          },

        ...mapActions('attendances', ['find'])
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

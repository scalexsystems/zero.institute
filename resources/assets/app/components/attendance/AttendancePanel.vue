<template>
    <div>
      <div class="card">
        <div class="card-header">
            Attendance
        </div>

        <div class="card-block">
         <div class="row">
             <div class="col-6 col-lg-6">
                 <input-select title="Semester" v-model.number="course.semester_id" :feedback="errors.semester_id" :options="semesters" />
                 <list :items="sessions">

                 </list>




             </div>




    </div>
</template>

<script lang="babel">
    import { mapActions } from 'vuex'
    import { formHelper } from 'bootstrap-for-vue'

    export default {}
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

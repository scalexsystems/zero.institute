<template>
    <container-window title="Student Attendance" subtitle="Attendance" back @back="$router.go(-1)">

        <div class="row">
          <div class="col-12 col-lg-8 offset-lg-2">
            <date-selector startDate="01-01-2015"></date-selector>

            <a role="button" href="#" class="btn btn-primary"> Take Attendance </a>
          </div>
        </div>
    </container-window>
</template>

<script lang="babel">
    import DateSelector from '../../components/attendance/DateSelector.vue'

    export default {
        name: 'CreateAttendance',
        components: { DateSelector },
        data: () => ({
            semester: 0,
            errors: {},
        }),
        computed: {
        },



        methods: {
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

<template>
    <container-window title="Institute Attendance Report"  back @back="$router.go(-1)">

        <div class="row py-2">
            <div class="col-12 col-lg-10 m-auto">
                <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>


                <div class="card">
                    <div class="card-header">
                        <input-select title="Semester" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                        <!--<input-select title="Courses" v-model.number="courses" :options="courses" @input="courseChosen"/>-->

                    </div>

                    <div class="card-block">
                        <!--{{ semester }}-->
                        <!--{{ course }}-->

                        <vue-chart chartType="BarChart" :columns="sessionDates">

                        </vue-chart>


                    </div>
                </div>

            </div>
        </div>

    </container-window>
</template>

<script lang="babel">
    import { mapGetters, mapActions } from 'vuex'
    import vueChart from 'vue-charts'

    export default {
        name: 'AttendanceReport',
        components: {},
        data: () => ({
            query: '',
            semester: 0,
            courses: 0,
        }),
        props: {},
        computed: {
            sessionDates() {
                return ['1', '2', '3', '4']
            },
            ...mapGetters('semesters', ['semesters']),


        },

        methods: {
          semesterChosen() {
                this.getCourseSessions();
          },

          async getCourseSessions(){
                const { course_sessions } = await this.forSemester({ semesterId: this.semester });
                this.courseSessions = course_sessions || [];
          },
        },

        created() {
        }


    };
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';




</style>

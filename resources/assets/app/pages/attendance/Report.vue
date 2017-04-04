<template>
    <container-window title="Institute Attendance Report"  back @back="$router.go(-1)">

        <div class="row py-2">
            <div class="col-12 col-lg-10 m-auto">
                <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>


                <div class="card">
                    <div class="card-header">

                        <input-select title="Semester" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                        <input-select title="Courses" v-model.number="course" :options="courses" @input="courseChosen" />

                    </div>

                    <div class="card-block">
                        <!--{{ semester }}-->
                        <!--{{ course }}-->

                        <bar-chart
                                id="bar" :data="chartData" xkey="date" ykeys='[ "attendance" ]' resize="true"
                                labels='["attendance"]' bar-colors='[ "#36A2EB" ]'
                                grid="true" grid-text-weight="bold">
                        </bar-chart>


                    </div>
                </div>

            </div>
        </div>

    </container-window>
</template>

<script lang="babel">
import Raphael from 'raphael/raphael'
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment'
import { BarChart } from 'vue-morris'
import { range, sortBy, uniqBy } from 'lodash'
global.Raphael = Raphael

export default {
    name: 'AttendanceReport',
    data: () => ({
        query: '',
        semester: 0,
        course: 0,
        aggregates: {},
        chartData: [],
    }),
    props: {},
    components: { BarChart },
    computed: {

        ...mapGetters('semesters', ['semesters']),
        ...mapGetters('courses', ['courses']),

    },
    methods: {
      semesterChosen() {
            this.loadAggregates();
            this.loadCourses();
      },

      courseChosen() {
          this.loadAggregates();
      },

      getFirstOrLast(end = false) {
         const keys = Object.keys(this.aggregates)
         const dates = this.convertToDate(keys).sort((first, second) => {
             return first - second
         })
         return end ? dates.pop() : dates[0]
      },

      convertToDate(strings){
          return strings.map(string => moment(string));
      },

      onInput() {

      },

      prepareDatesWithData(){
          const startDate = this.getFirstOrLast();
          const dateSeries = this.getDatesBetween(startDate, moment());


          const aggregates = Object.keys(this.aggregates).map(( key) => ({
             date: key,
             attendance: this.aggregates[key]
          }));



          return uniqBy(sortBy([...aggregates, ...dateSeries ], ((dateObject) => {
              return moment(dateObject.date)
          })), (dateObject => { return dateObject.date }));

      },

      getDatesBetween(startDate, endDate){
          const diff = moment(endDate).diff(startDate, 'days');
          const diffRange = range(0, diff + 1);
          const dates = [];
          diffRange.forEach((offset) => {
              const date = moment(startDate).add(offset, 'days').format('YYYY-MM-DD');
              dates.push({ date, attendance: 0 });
              return dates;
          });

          return dates;
      },

      loadCourses() {
         const semester = this.semester;
         this.courses = this.courses.filter(course => course.semester_id === semester);

      },

      async loadAggregates() {
          const params = (this.semester || this.course) ? { semester: this.semester, course: this.course} : {};

          const { attendances } = await this.getAggregates(params);
          this.aggregates = attendances || {};
          this.chartData = this.prepareDatesWithData();
      },

     ...mapActions('attendance', ['getAggregates'])
    },

    created() {
      this.loadAggregates();
    }


};
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';




</style>

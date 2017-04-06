<template>
    <container-window title="Institute Attendance Report"  back @back="$router.go(-1)">

        <div class="row py-2">
            <div class="col-12 col-lg-10 m-auto">
                <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>


                <div class="card">
                    <div class="card-header row mx-0">

                        <input-select title="Semester" class="col-lg-4" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                        <input-select title="Courses" class="col-lg-4" v-model.number="course" :options="courses" @input="courseChosen" />

                    </div>

                    <div class="card-block py-5">
                        <div class="chart-semester-name"> {{ semesterName }} </div>
                        <h4> {{ courseName }} </h4>

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
import { map, range, sortBy, uniqBy } from 'lodash'
global.Raphael = Raphael

export default {
    name: 'AttendanceReport',
    data: () => ({
        query: '',
        semester: 0,
        course: 0,
        aggregates: {},
        chartData: [],
        semesterName: '',
        courseName: '',

    }),
    props: {},
    components: { BarChart },
    computed: {
        semesterName () {
            return this.semester ? this.semesterById(this.semester) || {} : {}
        },

        courseName() {
            return this.course ? this.courseById(this.semester) || {} : {}
        },

        ...mapGetters('semesters', ['semesters', 'semesterById' ]),
        ...mapGetters('courses', ['courses', 'courseById']),

    },
    methods: {
      semesterChosen() {
            this.loadAggregates();
            this.loadCourses();
            this.semesterName = this.semesterById(this.semester).name || '';
      },

      courseChosen() {
          this.loadAggregates();
          this.courseName = this.courseById(this.course).name || '';
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


          const aggregates = Object.keys(this.aggregates).map((date) => ({
             date: moment(date),
             attendance: this.aggregates[date]
          }));

          const mergedDates =  uniqBy(sortBy([...aggregates, ...dateSeries ], ((dateObject) => {
              return dateObject.date
          })), (dateObject => { return dateObject.date.format('YYYY-MM-DD') }), );
          return this.formatDataForChart(mergedDates);
      },

      getDatesBetween(startDate, endDate){
          const diff = moment(endDate).diff(startDate, 'days');
          const diffRange = range(0, diff + 1);
          const dates = [];
          diffRange.forEach((offset) => {
              const date = moment(startDate).add(offset, 'days');
              dates.push({ date, attendance: 0 });
              return dates;
          });

          return dates;
      },

      formatDataForChart(dates){
          return map(dates, (entity) => ({
              date: moment(entity.date).format('D'),
              attendance: entity.attendance
          }))
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

.chart-semester-name {
    color: $brand-primary;
}



</style>

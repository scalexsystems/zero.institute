<template>
    <container title="Institute Attendance Report"  back @back="$router.go(-1)">

        <div class="row py-2">
            <div class="col-12 col-lg-8 m-auto">
                <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>


                <div class="card">
                    <div class="card-header row mx-0">

                        <input-select title="Semester" class="col-lg-4" v-model.number="semester" :options="semesters" @input="semesterChosen"/>
                        <input-select title="Courses" class="col-lg-4" v-model.number="course" :options="courses" @input="courseChosen" />

                    </div>

                    <div class="card-block chart-block">
                        <div class="chart-semester-name"> {{ semesterName }} </div>
                        <h4> {{ courseName }} </h4>

                        <div class="chart-wrapper">
                            <bar-chart
                                    id="bar" :data="chartData" xkey="date" ykeys='[ "attendance" ]' resize="true"
                                    labels='["attendance"]' bar-colors='[ "#36A2EB" ]'
                                    grid="true" grid-text-weight="bold" ref="chart">
                            </bar-chart>
                        </div>

                        <input-button value="<" @click.native="moveLeft"></input-button>
                        <input-button value=">" @click.native="moveRight"></input-button>


                    </div>
                </div>

            </div>
        </div>

    </container>
</template>

<script lang="babel">
import Raphael from 'raphael/raphael'
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment'
import { BarChart } from 'vue-morris'
import { isEmpty, map, range, sortBy, uniqBy } from 'lodash'
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
        month: 1,

    }),
    props: {},
    components: { BarChart },
    computed: {
        session(){
            return this.sessionById();
        },
        ...mapGetters('semesters', ['semesters', 'semesterById' ]),
        ...mapGetters('courses', ['courses', 'courseById']),
        ...mapGetters('sessions', ['sessionById']),

    },
    methods: {
      semesterChosen() {
            this.loadAggregates();
            this.loadCourses();
            this.semesterName = this.semesterById(this.semester).name || '';

      },

      courseChosen() {
          this.loadCourseAggregates();
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
          const month = this.getMonthFromAggregate();

          const dateSeries = this.getDatesForMonth(month)

          const aggregates = Object.keys(this.aggregates).map((date) => ({
             date: moment(date).format('D'),
             attendance: this.aggregates[date]
          }));

          const mergedDates =  uniqBy(sortBy([...aggregates, ...dateSeries ], ((dateObject) => {
              return dateObject.date
          })), (dateObject => { return dateObject.date }), );
          return this.formatDataForChart(mergedDates);
      },

      getDatesForMonth(month){
          const startDate = moment(month).date(1)
          const monthDays = startDate.daysInMonth()

          const diffRange = range(0, monthDays - 1)
          const dates = []
          diffRange.forEach((offset) => {
              const date = moment(startDate).add(offset, 'days')
              dates.push({ date, attendance: 0 })
              return dates;
          });

          return dates;

      },

      getMonthFromAggregate() {
          return !isEmpty(this.aggregates) ? moment(Object.keys(this.aggregates)[0]).format('M') : 0
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
          const params = (this.semester || this.course) ? { semester: this.semester, course: this.course, month: this.month} : {};

          const { attendances } = await this.getAggregates(params);
          this.aggregates = attendances || {};
          this.chartData = this.prepareDatesWithData();
      },

     async loadCourseAggregates() {
          const course = this.course;

          const { attendances } = await this.getCourseAggregates(course);

          this.aggregates = attendances || {};

     },

     ...mapActions('attendance', ['getAggregates']),
    ...mapActions('attendance', ['getCourseAggregates'])
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

.chart-block {
    padding-left: to-rem(40px);
}



</style>

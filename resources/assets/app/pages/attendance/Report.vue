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

                        <chart :chartData="chartData"></chart>


                    </div>
                </div>

            </div>
        </div>

    </container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import moment from 'moment'
import Chart from '../../components/attendance/Chart'

export default {
    name: 'AttendanceReport',
    data: () => ({
        query: '',
        semester: 0,
        course: 0,
        aggregates: {},
        chartData: {},
    }),
    props: {},
    computed: {
        ...mapGetters('semesters', ['semesters']),
    },
    components: { Chart },

    methods: {
      semesterChosen() {
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
          const dates = Object.keys(this.aggregates);
          const data = [];
          dates.forEach((date) => {
              const diff = moment(date).diff(startDate, 'days');
              debugger
              data[diff] = this.aggregates[date];
              return data;
          });

          return {
                  labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                      datasets: [
                          {
                              label: 'News reports',
                              backgroundColor: '#3c8dbc',
                              data: [12, 20, 12, 18, 10, 6, 9, 32, 29, 19, 12, 11]
                          }
                      ]
              }
      },

      async loadAggregates() {
        const { attendances } = await this.getAggregates();
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

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

                        <vue-chart chart-type="BarChart" :rows="rows" :columns="columns" :options="options"></vue-chart>


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
        chartData: [],
    }),
    props: {},
    computed: {
        columns() {
            return [{
                'type': 'string',
                'label': 'Year'
            }, {
                'type': 'number',
                'label': 'Sales'
            }, {
                'type': 'number',
                'label': 'Expenses'
            }]
        },
        rows() {
            return [
            ['2004', 1000, 400],
            ['2005', 1170, 460],
            ['2006', 660, 1120],
            ['2007', 1030, 540]
        ]},
        options() {
            return {
                title: 'Company Performance',
                hAxis: {
                    title: 'Year',
                    minValue: '2004',
                    maxValue: '2007'
                },
                vAxis: {
                    title: '',
                    minValue: 300,
                    maxValue: 1200
                },
                width: 900,
                height: 500,
                curveType: 'function'
            }
        },
        ...mapGetters('semesters', ['semesters']),
    },
    mixins: { Chart },

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
          return dates.map((date) => ['test', this.aggregates[date]]);
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

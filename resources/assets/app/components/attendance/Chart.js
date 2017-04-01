import Vue from 'vue'
import charts from 'vue-charts'


Vue.use(charts);

export default {
    name: 'AttendanceChart',
    props: {

        },
        components: {},
        data: () => ({
        }),
        computed: {

            },

        methods: {
        },

        mounted() {
           debugger;
           this.renderChart(this.chartData, this.options)
        }


};

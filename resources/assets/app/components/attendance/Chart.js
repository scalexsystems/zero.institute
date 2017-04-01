import { Bar, mixins } from 'vue-chartjs'
const { ReactiveProp } = mixins;

export default Bar.extend ({
        name: 'AttendanceChart',
        mixins: [ReactiveProp],
        props: {
            options: {
                type: Object,
            },

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


});

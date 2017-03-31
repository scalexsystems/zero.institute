import { Bar, mixins } from 'vue-chartjs'

export default Bar.extend ({
        name: 'AttendanceChart',
        mixins: [ mixins ],
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
           this.renderChart(this.chartData, this.options)
        }


});

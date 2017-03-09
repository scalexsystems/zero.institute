<template>
<div>
        <a role="button" @click.prevent="prev">
            <icon class="icon" type="chevron-left"></icon>
        </a>
        <div class="date-selector-datebox">
          <p> {{ date | dateForHumans }} </p>
          <!--<h5> {{ dayOfWeek }} </h5>-->
        </div>
        <a role="button" @click.prevent="next">
            <icon class="icon" type="chevron-right"></icon>
        </a>
    </div>
</template>

<script lang="babel">
    import moment from 'moment'
    import { dateForHumans } from '../../filters'
    export default {
        name: 'DateSelector',
        data: () => ({
          value: moment(),
          weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],

        }),
        props: {
            min: {
                type: String,
                required: true,
            },
            max: {
                type: String,
                default: () => new Date().toDateString(),
            },

            format: {
                type: String,
                default: 'DD-MM-YYYY'
            }
        },
        computed: {
            dayOfWeek() {
//              return this.weekdays[this.date.getDay()];
            }
        },
        methods: {
            prev() {
              const date = this.date;
              if(date.isAfter(this.startDate, 'date')) {
                date.subtract(1, 'days');
              }
            },

            next() {
              const date = this.date;
              if(date < this.endDate) {
                  date.setDate(date.getDate() + 1);
              }
            }
        },
        filters: {
            dateForHumans
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

    .icon {
      display: inline;
    }

    .date-selector-datebox {
       display: inline;
       width: 400px;
    }

</style>

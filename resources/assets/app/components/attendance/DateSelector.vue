<template>
<div class="d-flex flex-row align-items-center text-center">
        <a role="button" @click.prevent="prev">
            <icon class="icon" type="chevron-left"></icon>
        </a>
        <div class="date-selector-datebox text-center">
          <h3> {{ currentDate | dateForHumans }} </h3>
          <h5> {{ dayOfWeek }} </h5>
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
          value: new Date().toDateString(),
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
                return moment(this.value).format('dddd');
            },

            currentDate: {
                get() {
                    return moment(this.value);
                },
                set(val) {
                    this.$emit('input', val);
                }
            }
        },
        methods: {
            prev() {
              const date = this.currentDate;
              if(date.isAfter(this.min, 'date')) {
                this.value = date.subtract(1, 'days');
              }
            },

            next() {
               const date = this.currentDate;
               if(date.isBefore(this.max, 'date')) {
                this.value = date.add(1, 'days');
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

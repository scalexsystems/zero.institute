<template>
    <div>
        <div class="d-flex flex-row align-items-center">

            <div class="row-heading flex-column">
                <div class="row-heading-cell align-self-center" v-for="heading in rowHeadings">
                    <div class="small text-muted"> {{ heading }} </div>
                </div>
            </div>
            <div class="d-inline-flex flex-row align-items-center align-self-start" v-for="(column, weekNumber) in columnHeadings">
                <div class="flex-column">
                    <div class="small text-center text-muted"> {{ column }} </div>
                    <div v-for="(row, dayNumber) in rowHeadings">
                        <div class="square" :class="{ filled : isData(weekNumber, dayNumber)}">  </div>
                        <slot></slot>
                    </div>
                </div>
            </div>
        </div>

        <div class="legend my-2">
            <div class="d-flex flex-row align-items-center" v-for="entry in legend">
                <div class="legend-square square" :class="entry.styleClass"></div>
                <div class="legend-text text-muted text-uppercase px-2"> {{ absentLength }} {{ entry.name }} </div>
            </div>
        </div>
    </div>
</template>
<script lang="babel">
import moment from 'moment'
import { forOwn } from 'lodash'

    export default {
        name: 'ContributionGraph',
        data: () => ({
          chartInput: {},
        }),
        props: {
            rowHeadings: {
                type: Array,
                default: () => [],
            },
            columnHeadings: {
                type: Array,
                default: () => [],
            },
            startDate: {
                type: String,
                default: () => new Date().toDateString(),
            },
            dates: {
               type: Object,
               required: true,
            },
            legend: {
               type: Array,
               default: () => ([{
                   name: 'Absent',
                   styleClass: 'filled',
               }]),
            },
        },
        computed: {
            datesInWeekForm() {
                if (Object.keys(this.dates).length) {
                    const dates = {};
                    Object.keys(this.dates).forEach(date => {
                        const week = this.fromWeek(date);
                        const weekday = this.fromDayOfWeek(date);
                        if(dates[week]) {
                            dates[week].push(weekday);

                        } else {
                            Object.assign(dates, {
                                [week] : [weekday]
                            })
                        }

                    }   )
                    return dates;
                }
                return {};
            },
            absentLength() {
              return Object.keys(this.dates).length || 0;
            }
        },
        methods: {
          fromDayOfWeek(date) {
            return moment(date).isoWeekday();
          },
          fromWeek(date) {
            const startingWeek = moment(this.startDate).isoWeek()
            const startingMonday = moment().day('Sunday').isoWeek(startingWeek-1)
            return moment(date).diff(startingMonday, 'weeks') + 1
          },
          isData(weekNumber, dayNumber) {
            return this.datesInWeekForm[weekNumber+1] && this.datesInWeekForm[weekNumber+1].indexOf(dayNumber + 1) > -1
          },
    },
}

</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

    $dimension: 1.5rem !default;
    $padding: $dimension / 2 !default;
    $background: $gray-lightest !default;
    $dataColour: #ee1100 !default;


    .square {
        min-height: $dimension;
        width: $dimension;
        background: $background;
        border-radius: 0.5rem;
        margin: $padding / 2 $padding / 2 0 0 !important;
    }

    .row-heading-cell {
        margin: $padding !important;
    }

    .row-heading {
        padding-top: 1rem;
    },

    .filled {
        background: $dataColour;
    }

    .legend-text {
        height: $dimension;
    }

    .legend-square {
        margin: 0 !important;
    }



</style>

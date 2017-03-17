<template>
    <div>
        <div class="d-flex flex-row align-items-center" >

            <div class="row-heading flex-column">
                <div class="row-heading-cell align-self-center" v-for="heading in rowHeadings">
                    <div class="small"> {{ heading }} </div>
                </div>
            </div>
            <div class="d-inline-flex flex-row align-items-center align-self-start" v-for="(column, r) in columnHeadings">
                <div class="flex-column">
                    <div class="small text-center"> {{ column }} </div>
                <div v-for="(row, c) in rowHeadings">
                    <div class="square">  </div>
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="babel">
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
//               required: true,
            },
        },
        computed: {

        },
        methods: {
          dayofWeek(date) {
            return moment(date).format('dddd');
          },
          getWeek(date) {
            return moment(date).diff(this.startDate);
          },
          formatData() {
             this.data.forEach(data => {
                 const dayofWeek = this.dayofWeek()
                 const getWeek = this.getWeek()
             })
          }





        },

    }

</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

    $dimension: 1.5rem !default;
    $padding: $dimension / 2 !default;
    $background: $gray-lightest !default;


    .square {
        min-height: $dimension;
        min-width: $dimension;
        background: $background;
        border-radius: 0.5rem;
        margin: $padding / 2 $padding / 2 0 0 !important;
    }

    .row-heading-cell {
        margin: $padding !important;
    }

    .row-heading {
        padding-top: 1rem;
        }

</style>

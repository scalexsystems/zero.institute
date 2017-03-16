<template>
    <div>
        <div class="d-flex flex-row align-items-center" >

            <div class="row-heading flex-column">
                <div class="row-heading-cell align-self-center" v-for="heading in rowHeadings">
                    {{ heading }}
                </div>
            </div>
            <div class="d-inline-flex flex-row align-items-center align-self-start" v-for="(column, r) in columnHeadings">
                <div class="flex-column">
                    <span class="text-center"> {{ column }} </span>
                <div v-for="(row, c) in rowHeadings">
                    <div class=square>  </div>
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
           data: {
              W1 : {
                 M : 'test',
                 T : 'test',
                },
              W2: {
                 M: 'test'
              }
           } ,
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
//            data: {
//               type: Object,
//               required: true,
//            },
        },
        computed: {
        },
        methods: {
        },
        filters: {
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
        padding-top: $padding;
    }

</style>

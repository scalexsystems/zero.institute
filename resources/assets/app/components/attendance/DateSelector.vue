<template>
<div>

        <a role="button" @click.prevent="prev">
            <icon class="icon" type="chevron-left"></icon>
        </a>
        <h3> {{ date }} </h3>

        <h5> {{ dayOfWeek }} </h5>

        <a role="button" @click.prevent="next">
            <icon class="icon" type="chevron-right"></icon>
        </a>
    </div>
</template>

<script lang="babel">
    export default {
        name: 'DateSelector',
        data: () => ({
          date: new Date(),
          weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],

        }),
        props: {
            startDate: {
                type: String,
                required: true,
            },
            endDate: {
                type: String,
                default: new Date().toDateString(),
            },

            format: {
                type: String
            }
        },
        computed: {
            dayOfWeek() {
              return this.weekdays[this.date.getDay()];
            },

        },
        methods: {
            prev() {
              const date = this.date;
              if(date >= this.startDate) {
              date.setDate(date.getDate() - 1);
              }
            },

            next() {
              const date = this.date;
              if(date < this.endDate) {
                  date.setDate(date.getDate() + 1);
              }
            }
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

    .icon {
      display: inline;
    }

</style>

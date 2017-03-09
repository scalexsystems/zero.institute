<template>
    <abstract-card v-bind="{ remove }" class="c-attendance-card" @remove="$emit('remove', student)">
        <div class="d-flex flex-row align-items-center">
            <img :src="student.photo" class="rounded-circle c-attendance-card-photo fit-cover">
            <div class="mr-auto">
                <div class="c-attendance-card-title" :class="{ 'text-muted': !student.name.trim() }">
                    {{ student.name.trim() || 'Name not set' }}
                </div>
                <div class="c-attendance-card-subtitle flex-auto">
                    <span class="text-muted">Roll Number: {{ student.uid }} {{ attendanceStatus }} </span>
                </div>

             </div>
             <div class="flex ml-auto">
                    <toggle v-model="attendance" @input="toggle"> </toggle>
              </div>
            </div>


        <slot></slot>
    </abstract-card>
</template>

<script lang="babel">
    import { mapGetters } from 'vuex'

    export default {
        name: 'AttendanceCard',
        data: () => ({
          attendance: true,
        }),
        props: {
            student: {
                type: Object,
                required: true
            },

            remove: {
                type: Boolean,
                default: false
            }
        },

        computed: {
            attendanceStatus() {
              return this.attendance ? 'Present' : 'Absent';
            },
            department () {
                const student = this.student

                return this.departmentById(student.department_id) || {}
            },
            ...mapGetters('departments', ['departmentById'])
        },

        methods: {
          toggle(value) {
            return this.$emit('toggle', value, this.student.user_id);
          }
        }
        }
</script>

<style lang="scss">
    @import '../../styles/methods';

    .c-attendance-card {
        &-photo {
            width: to-rem(48px);
            height: to-rem(48px);
            margin-right: to-rem(10px);
        }

        &-title {
            font-size: 1.14285rem;
        }

        &-subtitle {
            font-size: .75rem;
        }

        &-block {
            padding: .64286rem .71429rem;
        }
    }
</style>

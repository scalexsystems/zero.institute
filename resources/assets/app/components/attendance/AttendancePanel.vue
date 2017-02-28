<template>
    <div>
        <div class="card">
            <div class="card-header">
                Attendance
            </div>

            <div class="card-block">
                <div class="row">
                    <div class="col-6 col-lg-6">
                        <input-select title="Semester" v-model.number="semester_id" :feedback="errors.semester_id" :options="semesters" />
                        <list :items="sessions" @listClicked="sessionClicked">

                        </list>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="babel">
    import List from './List.vue'
    import { mapGetters } from 'vuex'

    export default {
        name: 'AttendancePanel',
        data: () => [{
            activeSession: null
        }],
        computed: {
            items() {
                const sessions = this.sessions;
                sessions.forEach(session => {
                })


            },
            ...mapGetters('courses', ['sessions']),

        },

        methods: {
            sessionClicked(event, session){
                this.activeSession = session;
            }
        }

    }
</script>

<style lang="scss" scoped>
    @import '../../styles/methods';
    @import '../../styles/variables';

</style>

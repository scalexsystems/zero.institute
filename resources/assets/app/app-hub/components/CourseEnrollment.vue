<template>
  <modal :show="show" @hide="show = false">
    <div class="card" v-if="course">
      <h4 class="card-header">
        Course Enrollment

        <button type="button" class="btn btn-primary float-xs-right" v-show="selected.length"
                :dissmiss-on-backdrop="false" ref="enroll"
                @click.prevent="enroll">Enroll Now</button>
      </h4>
      <div class="card-block">
        <div class="alert" v-if="message" :class="[ message.success ? 'alert-success' : 'alert-danger' ]">
          {{ message.message }}
        </div>
        <input-search v-model="query"
          title="Student"
          subtitle="Search a student by name or roll number."
          @suggest="onSuggest"
          @select="onSelect"
          :suggestions="students"
          ref="students" />

          <div class="row mt-1">
            <div class="col-xs-12 col-lg-6" v-for="student in selected" :key="student.id">
              <person-card :item="student" style="cursor: auto">
                <small class="fl-auto">{{ department(student) }} &centerdot; {{ discipline(student) }}</small>
                <a @click="onRemove(student)" role="button">
                  <i class="fa fa-fw fa-trash-o"></i>
                </a>
              </person-card>
            </div>
          </div>
      </div>
    </div>
  </modal>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import throttle from 'lodash/throttle';

import { Modal, PersonCard } from '../../components';

export default {
  name: 'CourseEnrollment',
  data() {
    return { show: false, course: null, query: '', selected: [], message: null };
  },
  computed: {
    ...mapGetters('school', ['students', 'departments', 'disciplines']),
  },
  methods: {
    department(student) {
      return (this.departments.find(d => student.department_id === d.id) || {}).name;
    },
    discipline(student) {
      return (this.disciplines.find(d => student.discipline_id === d.id) || {}).name;
    },
    enroll() {
      const ids = this.selected.map(student => student.id);

      if (!ids.length) return;

      this.$refs.enroll.classList.add('disabled');
      this.$http.post(`courses/${this.course.id}/enroll`, { students: ids, session_id: this.course.session.id })
        .then(() => {
          this.$refs.enroll.classList.remove('disabled');
          this.selected = [];
          this.message = { success: true, message: 'All students enrolled.' };
          this.$emit('enrolled');
        })
        .catch(() => {
          this.$refs.enroll.classList.remove('disabled');

          this.message = { success: false, message: 'Failed to enroll these students.' };
        });
    },
    onSelect(student) {
      if (this.selected.indexOf(student) < 0) this.selected.push(student);
      this.message = null;
    },
    onRemove(student) {
      const index = this.selected.indexOf(student);

      if (index > -1) {
        this.selected.splice(index, 1);
        this.$refs.students.$emit('remove', student);
      }
    },
    onSuggest: throttle(function onSuggest({ value, start, end }) {
      start();
      this.getStudents({ q: value }).then(() => end());
    }, 600),
    ...mapActions('school', ['getStudents', 'getDepartments', 'getDisciplines']),
  },
  components: { Modal, PersonCard },
  created() {
    this.$on('open', (course) => {
      this.course = course;
      this.query = '';
      this.selected = [];
      this.show = true;
      this.message = null;
    });
    if (!this.departments.length) this.getDepartments();
    if (!this.disciplines.length) this.getDisciplines();
    if (!this.students.length) this.getStudents();
  },
};
</script>

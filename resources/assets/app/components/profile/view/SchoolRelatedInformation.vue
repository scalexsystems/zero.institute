<template>
<div class="card-block">
  <div class="row">
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">{{ uidLabel }}</div>
        <div class="value">{{ source.uid }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4" v-if="isStudent">
      <div class="profile-field">
        <div class="label">Date of Admission</div>
        <div class="value">{{ source.date_of_admission | dateForHumans }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4" v-else="">
      <div class="profile-field">
        <div class="label">Date of Joining</div>
        <div class="value">{{ source.date_of_joining | dateForHumans }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Department</div>
        <div class="value">{{ department.name }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4" v-if="isTeacher">
      <div class="profile-field">
        <div class="label">Specialization</div>
        <div class="value">{{ discipline.specialization}}</div>
      </div>
    </div>
    <div class="col-6 col-md-4" v-if="isStudent">
      <div class="profile-field">
        <div class="label">Discipline</div>
        <div class="value">{{ discipline.name }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4" v-if="!isStudent">
      <div class="profile-field">
        <div class="label">Job Title</div>
        <div class="value">{{ discipline.job_title }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">AADHAR</div>
        <div class="value">{{ discipline.govt_id }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Passport</div>
        <div class="value">{{ discipline.passport }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import moment from 'moment'
import { mapGetters } from 'vuex'
import { isObject } from '../../../util'

export default {
  name: 'SchoolRelatedInformation',

  props: {
    source: {
      type: Object,
      required: true
    }
  },

  computed: {
    isStudent () {
      return this.source._type === 'student'
    },

    isTeacher () {
      return this.source._type === 'teacher'
    },

    isEmployee () {
      return this.source._type === 'employee'
    },

    uidLabel () {
      const s = this.isStudent
      const t = this.isTeacher

      if (s) return 'Unique ID (Roll Number)'
      if (t) return 'Unique ID (Teacher ID Number)'
      return 'Unique ID (Employee ID Number)'
    },

    department () {
      const student = this.student || {}

      return this.getDepartment(student.department_id) || {}
    },

    discipline () {
      const student = this.student || {}

      return this.getDiscipline(student.discipline_id) || {}
    },

    ...mapGetters({
      getDepartment: 'departments/departmentById',
      getDiscipline: 'disciplines/disciplineById'
    })
  },

  filters: {
    dateForHumans (value) {
      return value ? moment(value).format('D MMMM YYYY') : ''
    }
  }
}
</script>
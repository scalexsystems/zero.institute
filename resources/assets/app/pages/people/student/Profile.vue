<template>
<container title="Student Profile" subtitle="Everything & anything you need to know about a student is here."
           @back="$router.go(-1)" back>

  <div class="container my-3">
    <div class="row">
      <div class="col-12 col-lg-4 text-center">
        <div class="card mb-3" ref="sidebar" v-if="student">
          <img class="card-img-top student-photo" :src="student.photo">
          <div class="card-block">
            <h3 class="value">{{ student.name }}</h3>
            <span v-if="student.uid"><span class="text-muted">Roll Number:</span> {{ student.uid }}<br></span>
            <span v-if="student.email"><span class="text-muted">Email:</span> {{ student.email}}</span>
          </div>
          <hr class="m-0">
          <div class="card-block" v-if="student.user_id">
            <router-link class="card-link" :to="{ name: 'user.messages', params: { id: student.user_id } }">
              Send Message
            </router-link>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8" v-if="student">
        <personal-information class="mb-3" :source="student" :submit="() => {}"/>
        <school-related-information class="mb-3" :source="student" :submit="() => {}"/>
        <contact-information class="mb-3" :source="student" :submit="() => {}"/>
        <guardian-information class="mb-3" :source="student" :submit="() => {}" type="father"
                              title="Father's Information"/>
        <guardian-information class="mb-3" :source="student" :submit="() => {}" type="mother"
                              title="Mother's Information"/>
        <medical-information class="mb-3" :source="student" :submit="() => {}"/>
      </div>
      <div class="col-12 col-lg-8" v-else-if="error">
        <div class="card card-block text-center card-outline-danger text-danger">
          You cannot access this profile.
        </div>
      </div>
      <div class="col-12 col-lg-8" v-else>
        <loading/>
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import moment from 'moment'
import { mapGetters, mapActions } from 'vuex'
import {
  ContactInformation,
  GuardianInformation,
  MedicalInformation,
  PersonalInformation,
  SchoolRelatedInformation
} from '../../../components/profile'

export default {
  name: 'Student',

  props: {
    uid: {
      type: String,
      required: true
    }
  },

  data: () => ({
    student: null,
    error: false
  }),

  created () {
    this.fetch()
  },

  filters: {
    currency (value) {
      const amount = parseFloat(value)

      if (Number.isNaN(amount)) return '₹ 0'

      return `₹ ${amount}`
    },
    dateForHumans (value) {
      return value ? moment(value).format('D MMMM YYYY') : ''
    }
  },

  methods: {
    async fetch () {
      const { student } = await this.find(this.uid)

      if (student) {
        this.student = student
        this.error = false
      } else {
        this.error = true
      }
    },
    ...mapActions('students', ['find'])
  },

  components: {
    ContactInformation,
    GuardianInformation,
    MedicalInformation,
    PersonalInformation,
    SchoolRelatedInformation
  },

  watch: {
    uid (uid, oldUID) {
      if (uid === oldUID) return

      this.student = null
      this.error = false

      this.fetch()
    }
  }
}
</script>

<style lang="scss" scoped>
.card-header {
  padding: 1.25rem;
}

.student-photo {
  width: 100%;
}

.student-field {
  margin-bottom: 2rem;
  .label {
    font-size: .75rem;
    color: #b3b3b3;
  }
}

.value:empty:before {
  content: "xxx x xxxx";
  opacity: 0.1;
}
</style>

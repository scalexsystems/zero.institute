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
        <personal-information class="mb-3" :source="student" :submit="() => {}" />
        <contact-information class="mb-3" :source="student" :submit="() => {}" />

        <div class="card mb-3">
          <h5 class="card-header bg-white">
            Related to School
          </h5>
          <div class="card-block">
            <div class="row">
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Student UID (Roll Number)</div>
                  <div class="value">{{ student.uid }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Date of Admission</div>
                  <div class="value">{{ student.date_of_admission | dateForHumans }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Department</div>
                  <div class="value">{{ department.name }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Discipline</div>
                  <div class="value">{{ discipline.name }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <h5 class="card-header bg-white">
            Contact Information
          </h5>
          <div class="card-block">
            <div class="row">
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Address</div>
                  <div class="value">{{ address }}
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Landmark</div>
                  <div class="value">{{ student.address ? student.address.landmark : ''}}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">City</div>
                  <div class="value">{{ student.address && student.address.city ? student.address.city.name + ', ' +
                    student.address.city.state.name : '' }}
                  </div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">PIN Code</div>
                  <div class="value">{{ student.address ? student.address.pin_code : ''}}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Email</div>
                  <div class="value">{{ student.address ? student.address.email : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Phone</div>
                  <div class="value">{{ student.address ? student.address.phone : ''}}</div>
                </div>
              </div>
            </div>
          </div>
          <hr class="box-sep">
          <div class="card-block">
            <div class="row">
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Father's Name</div>
                  <div class="value">{{ student.father ? student.father.name : ''}}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Father's Phone</div>
                  <div class="value">{{ student.father ? student.father.phone : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Father's Profession</div>
                  <div class="value">{{ student.father ? student.father.profession : ''}}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Father's Profession</div>
                  <div class="value">{{ student.father ? student.father.profession : ''}}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Father's Currency</div>
                  <div class="value">{{ student.father ? student.father.currency : '' | currency }}</div>
                </div>
              </div>
            </div>
          </div>
          <hr class="box-sep">
          <div class="card-block">
            <div class="row">
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Mother's Name</div>
                  <div class="value">{{ student.mother ? student.mother.name : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Mother's Phone</div>
                  <div class="value">{{ student.mother ? student.mother.phone : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Mother's Profession</div>
                  <div class="value">{{ student.mother ? student.mother.profession : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Mother's Profession</div>
                  <div class="value">{{ student.mother ? student.mother.profession : '' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Mother's Currency</div>
                  <div class="value">{{ student.mother ? student.mother.currency : '' | currency }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <h5 class="card-header bg-white">
            Medical Information
          </h5>
          <div class="card-block">
            <div class="row">
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Blood Group</div>
                  <div class="value text-uppercase">{{ student.blood_group }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Disability</div>
                  <div class="value">{{ student.is_disabled ? student.disability : 'None' }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Major Disease/Illness</div>
                  <div class="value">{{ student.disease }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Allergy</div>
                  <div class="value">{{ student.allergy }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Body Marks/Identification Marks</div>
                  <div class="value">{{ student.body_marks }}</div>
                </div>
              </div>
              <div class="col-6 col-md-4">
                <div class="student-field">
                  <div class="label">Food Habit</div>
                  <div class="value">{{ student.food_habit }}</div>
                </div>
              </div>
              <div class="col-12">
                <div class="student-field">
                  <div class="label">Additional Remarks</div>
                  <div class="value">{{ student.medical_remarks }}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8" v-else-if="error">
        <div class="card card-block text-center card-outline-danger text-danger">
          You cannot access this profile.
        </div>
      </div>
      <div class="col-12 col-lg-8" v-else>
        <loading />
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import moment from 'moment'
import { mapGetters, mapActions } from 'vuex'
import ContactInformation from '../../../components/profile/ContactInformation.vue'
import PersonalInformation from '../../../components/profile/PersonalInformation.vue'

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

  computed: {
    department () {
      const student = this.student || {}

      return this.getDepartment(student.department_id) || {}
    },

    discipline () {
      const student = this.student || {}

      return this.getDiscipline(student.discipline_id) || {}
    },

    address () {
      return this.student.address.length ? (this.student.address.addressline1 + this.student.address.addressline2) : ''
    },

    ...mapGetters({
      getDepartment: 'departments/departmentById',
      getDiscipline: 'disciplines/disciplineById'
    })
  },

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

  components: { ContactInformation, PersonalInformation },

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

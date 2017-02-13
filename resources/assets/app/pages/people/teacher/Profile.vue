<template>
<container title="Teacher Profile" subtitle="Everything & anything you need to know about a teacher is here."
           @back="$router.go(-1)" back>

    <div class="container my-3">
      <div class="row">
          <div class="col-xs-12 col-lg-4 text-xs-center">
            <div class="card mb-3" ref="sidebar" v-if="teacher">
              <img class="card-img-top teacher-photo" :src="teacher.photo">
              <div class="card-block">
                <h3 class="value">{{ teacher.name }}</h3>
                <span v-if="teacher.uid"><span class="text-muted">Employee ID:</span> {{ teacher.uid }}<br></span>
                <span v-if="teacher.email"><span class="text-muted">Email:</span> {{ teacher.email}}</span>
              </div>
              <hr class="m-0">
              <div class="card-block" v-if="teacher.user_id">
                <router-link class="card-link" :to="{ name: 'hub.user', params: { user: teacher.user_id } }">
                  Send Message
                </router-link>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-lg-8" v-if="teacher">
            <personal-information class="mb-3" :source="teacher" :submit="() => {}" />
            <contact-information class="mb-3" :source="teacher" :submit="() => {}" />

            <div class="card">
              <h5 class="card-header bg-white">
                Related to School
              </h5>
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">teacher UID (Roll Number)</div>
                            <div class="value">{{ teacher.uid }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Date of Admission</div>
                            <div class="value">{{ teacher.date_of_admission | dateForHumans }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Department</div>
                            <div class="value">{{ department.name }}</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="card">
              <h5 class="card-header bg-white">
                Contact Information
              </h5>
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Address</div>
                            <div class="value">{{ address }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Landmark</div>
                            <div class="value">{{ teacher.address ? teacher.address.landmark : '' }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">City</div>
                            <div class="value">{{ teacher.address && teacher.address.city ? teacher.address.city.name + ', ' +
                                teacher.address.city.state.name : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">PIN Code</div>
                            <div class="value">{{ teacher.address ? teacher.address.pin_code : '' }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Email</div>
                            <div class="value">{{ teacher.address ? teacher.address.email : ''}}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Phone</div>
                            <div class="value">{{ teacher.address ? teacher.address.phone : '' }}</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="card">
              <h5 class="card-header bg-white">
                Medical Information
              </h5>
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Blood Group</div>
                            <div class="value text-uppercase">{{ teacher.blood_group }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Disability</div>
                            <div class="value">{{ teacher.is_disabled ? teacher.disability : 'None' }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Major Disease/Illness</div>
                            <div class="value">{{ teacher.disease }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Allergy</div>
                            <div class="value">{{ teacher.allergy }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Body Marks/Identification Marks</div>
                            <div class="value">{{ teacher.body_marks }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="teacher-field">
                            <div class="label">Food Habit</div>
                            <div class="value">{{ teacher.food_habit }}</div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="teacher-field">
                            <div class="label">Additional Remarks</div>
                            <div class="value">{{ teacher.medical_remarks }}</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-lg-8" v-if="!loading && !success">
            <div class="card card-block text-xs-center card-outline-danger text-danger">
              {{ errors }}
            </div>
          </div>
      </div>
  </div>
</container>
</template>

<script lang="babel">
import first from 'lodash/first'
import toNumber from 'lodash/toNumber'
import moment from 'moment'
import { mapGetters, mapActions } from 'vuex'

import { getters, actions } from '../../vuex/meta'
import ContactInformation from '../../../components/profile/ContactInformation.vue'
import PersonalInformation from '../../../components/profile/PersonalInformation.vue

export default {
  name: 'teacherProfile',
  data: () => ({
        student: null,
        error: false
  }),
  props: {
    uid: {
      type: String,
      required: true
    },
  },
  computed: {
    department () {
      const departments = this.departments
      const id = this.teacher.department_id

      return first(departments.filter(d => d.id === id)) || {}
    },
    address () {
      return this.teacher.address.length ? (this.teacher.address.addressline1 + this.teacher.address.addressline2) : ''
    },
    ...mapGetters({
      departments: getters.departments
    })
  },
  components: { ContactInformation, PersonalInformation },
  created () {
    this.fetch()
  },
  filters: {
    currency (value) {
      const amount = toNumber(value)

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
    ...mapActions({
      getDepartments: actions.getDepartments
    })
  },
  watch: {
    uid (uid, oldUID) {
      if (uid === oldUID) return

      this.teacher = null
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
.teacher-photo {
  width: 100%;
}
.teacher-field {
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

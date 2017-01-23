<template>
<window-box title="Student Profile" subtitle="See profile here...">
  <div class="container my-1">
      <div class="row">
          <div class="col-xs-12 col-lg-4 text-xs-center">
            <div class="card" ref="sidebar">
              <img class="card-img-top student-photo" :src="student.photo">
              <div class="card-block">
                <h3 class="value">{{ student.name }}</h3>
                <span v-if="student.uid"><span class="text-muted">Roll Number:</span> {{ student.uid }}<br></span>
                <span v-if="student.email"><span class="text-muted">Email:</span> {{ student.email}}</span>
              </div>
              <hr class="m-0">
              <div class="card-block" v-if="student.user_id">
                <router-link class="card-link" :to="{ name: 'hub.user', params: { user: student.user_id } }">
                  Send Message
                </router-link>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-lg-8" v-if="loading">
            <loading-placeholder></loading-placeholder>
          </div>
          <div class="col-xs-12 col-lg-8" v-if="success">
            <div class="card">
              <h5 class="card-header bg-white">
                Person Information
              </h5>
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Name</div>
                            <div class="value">{{ student.name }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Gender</div>
                            <div class="value text-capitalize">{{ student.gender }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Date of Birth</div>
                            <div class="value">{{ student.date_of_birth | dateForHumans }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Category</div>
                            <div class="value">{{ student.category }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">AADHAR ID</div>
                            <div class="value">{{ student.govt_id }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Passport</div>
                            <div class="value">{{ student.passport }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Religion</div>
                            <div class="value">{{ student.religion }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother Tongue</div>
                            <div class="value">{{ student.language }}</div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

            <div class="card">
              <h5 class="card-header bg-white">
                Related to School
              </h5>
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Student UID (Roll Number)</div>
                            <div class="value">{{ student.uid }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Date of Admission</div>
                            <div class="value">{{ student.date_of_admission | dateForHumans }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Department</div>
                            <div class="value">{{ department.name }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Discipline</div>
                            <div class="value">{{ discipline.name }}</div>
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
                        <div class="student-field">
                            <div class="label">Address</div>
                            <div class="value">{{ student.address ? student.address.address_line1 + ', ' +
                                student.address.address_line2 : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Landmark</div>
                            <div class="value">{{ student.address.landmark }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">City</div>
                            <div class="value">{{ student.address.city ? student.address.city.name + ', ' +
                                student.address.city.state.name : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">PIN Code</div>
                            <div class="value">{{ student.address.pin_code }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Email</div>
                            <div class="value">{{ student.address.email }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Phone</div>
                            <div class="value">{{ student.address.phone }}</div>
                        </div>
                    </div>
                </div>
              </div>
              <hr class="box-sep">
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Father's Name</div>
                            <div class="value">{{ student.father.name }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Father's Phone</div>
                            <div class="value">{{ student.father.phone }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Father's Profession</div>
                            <div class="value">{{ student.father.profession }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Father's Profession</div>
                            <div class="value">{{ student.father.profession }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Father's Currency</div>
                            <div class="value">{{ student.father.currency | currency }}</div>
                        </div>
                    </div>
                </div>
              </div>
              <hr class="box-sep">
              <div class="card-block">
                <div class="row">
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother's Name</div>
                            <div class="value">{{ student.mother.name }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother's Phone</div>
                            <div class="value">{{ student.mother.phone }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother's Profession</div>
                            <div class="value">{{ student.mother.profession }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother's Profession</div>
                            <div class="value">{{ student.mother.profession }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Mother's Currency</div>
                            <div class="value">{{ student.mother.currency | currency }}</div>
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
                        <div class="student-field">
                            <div class="label">Blood Group</div>
                            <div class="value text-uppercase">{{ student.blood_group }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Disability</div>
                            <div class="value">{{ student.is_disabled ? student.disability : 'None' }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Major Disease/Illness</div>
                            <div class="value">{{ student.disease }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Allergy</div>
                            <div class="value">{{ student.allergy }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Body Marks/Identification Marks</div>
                            <div class="value">{{ student.body_marks }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="student-field">
                            <div class="label">Food Habit</div>
                            <div class="value">{{ student.food_habit }}</div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="student-field">
                            <div class="label">Additional Remarks</div>
                            <div class="value">{{ student.medical_remarks }}</div>
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
</window-box>
</template>

<script lang="babel">
import first from 'lodash/first';
import toNumber from 'lodash/toNumber';
import isNaN from 'lodash/isNaN';
import moment from 'moment';
import { mapGetters, mapActions } from 'vuex';

import { getters, actions } from '../../vuex/meta';
import { WindowBox, LoadingPlaceholder } from '../../components';

export default {
  name: 'StudentProfile',
  data() {
    return {
      errors: null,
      remote: null,
    };
  },
  computed: {
    student() {
      const local = this.local || {};
      const remote = this.remote;

      if (remote) return remote;

      return local;
    },
    local() {
      const students = this.students;
      const uid = this.$route.params.student;

      return first(students.filter(student => student.uid === uid));
    },
    loading() {
      return this.remote === null && this.errors === null;
    },
    success() {
      return this.remote !== null;
    },
    department() {
      const departments = this.departments;
      const id = this.student.department_id;

      return first(departments.filter(d => d.id === id)) || {};
    },
    discipline() {
      const disciplines = this.disciplines;
      const id = this.student.discipline_id;

      return first(disciplines.filter(d => d.id === id)) || {};
    },
    ...mapGetters({
      students: getters.students,
      departments: getters.departments,
      disciplines: getters.disciplines,
    }),
  },
  components: { WindowBox, LoadingPlaceholder },
  created() {
    if (this.departments.length === 0) {
      this.getDepartments();
    }

    if (this.disciplines.length === 0) {
      this.getDisciplines();
    }

    this.getStudent();
  },
  filters: {
    currency(value) {
      const amount = toNumber(value);

      if (isNaN(amount)) return '₹ 0';

      return `₹ ${amount}`;
    },
    dateForHumans(value) {
      return moment(value).format('D MMMM YYYY');
    },
  },
  methods: {
    getStudent() {
      const id = this.$route.params.student;

      this.remote = this.errors = null;

      this.$http.get(`people/students/${id}`)
          .then(response => response.json())
          .then((result) => {
            this.remote = result;
          })
          .catch((response) => {
            response.json()
                .then((result) => {
                  this.errors = result.message;
                })
                .catch(() => {
                  this.errors = 'Retry. There was some error apprehending response from server.';
                });
          });
    },
    ...mapActions({
      getDepartments: actions.getDepartments,
      getDisciplines: actions.getDisciplines,
    }),
  },
  watch: {
    $route: 'getStudent',
  },
};
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

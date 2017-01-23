<template>
<window-box title="Employee Profile" subtitle="See profile here...">
  <div class="container my-1">
      <div class="row">
          <div class="col-xs-12 col-lg-4 text-xs-center">
            <div class="card" ref="sidebar">
              <img class="card-img-top employee-photo" :src="employee.photo">
              <div class="card-block">
                <h3 class="value">{{ employee.name }}</h3>
                <span v-if="employee.uid"><span class="text-muted">Employee ID:</span> {{ employee.uid }}<br></span>
                <span v-if="employee.email"><span class="text-muted">Email:</span> {{ employee.email}}</span>
              </div>
              <hr class="m-0">
              <div class="card-block" v-if="employee.user_id">
                <router-link class="card-link" :to="{ name: 'hub.user', params: { user: employee.user_id } }">
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
                        <div class="employee-field">
                            <div class="label">Name</div>
                            <div class="value">{{ employee.name }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Gender</div>
                            <div class="value text-capitalize">{{ employee.gender }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Date of Birth</div>
                            <div class="value">{{ employee.date_of_birth | dateForHumans }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Category</div>
                            <div class="value">{{ employee.category }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">AADHAR ID</div>
                            <div class="value">{{ employee.govt_id }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Passport</div>
                            <div class="value">{{ employee.passport }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Religion</div>
                            <div class="value">{{ employee.religion }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Mother Tongue</div>
                            <div class="value">{{ employee.language }}</div>
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
                        <div class="employee-field">
                            <div class="label">employee UID (Roll Number)</div>
                            <div class="value">{{ employee.uid }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Date of Admission</div>
                            <div class="value">{{ employee.date_of_admission | dateForHumans }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
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
                        <div class="employee-field">
                            <div class="label">Address</div>
                            <div class="value">{{ employee.address ? employee.address.address_line1 + ', ' +
                                employee.address.address_line2 : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Landmark</div>
                            <div class="value">{{ employee.address.landmark }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">City</div>
                            <div class="value">{{ employee.address.city ? employee.address.city.name + ', ' +
                                employee.address.city.state.name : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">PIN Code</div>
                            <div class="value">{{ employee.address.pin_code }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Email</div>
                            <div class="value">{{ employee.address.email }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Phone</div>
                            <div class="value">{{ employee.address.phone }}</div>
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
                        <div class="employee-field">
                            <div class="label">Blood Group</div>
                            <div class="value text-uppercase">{{ employee.blood_group }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Disability</div>
                            <div class="value">{{ employee.is_disabled ? employee.disability : 'None' }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Major Disease/Illness</div>
                            <div class="value">{{ employee.disease }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Allergy</div>
                            <div class="value">{{ employee.allergy }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Body Marks/Identification Marks</div>
                            <div class="value">{{ employee.body_marks }}</div>
                        </div>
                    </div>
                    <div class="col-xs-6 col-md-4">
                        <div class="employee-field">
                            <div class="label">Food Habit</div>
                            <div class="value">{{ employee.food_habit }}</div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="employee-field">
                            <div class="label">Additional Remarks</div>
                            <div class="value">{{ employee.medical_remarks }}</div>
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
  name: 'employeeProfile',
  data() {
    return {
      errors: null,
      remote: null,
    };
  },
  computed: {
    employee() {
      const local = this.local || {};
      const remote = this.remote;

      if (remote) return remote;

      return local;
    },
    local() {
      const employees = this.employees;
      const uid = this.$route.params.employee;

      return first(employees.filter(employee => employee.uid === uid));
    },
    loading() {
      return this.remote === null && this.errors === null;
    },
    success() {
      return this.remote !== null;
    },
    department() {
      const departments = this.departments;
      const id = this.employee.department_id;

      return first(departments.filter(d => d.id === id)) || {};
    },
    ...mapGetters({
      employees: getters.employees,
      departments: getters.departments,
    }),
  },
  components: { WindowBox, LoadingPlaceholder },
  created() {
    if (this.departments.length === 0) {
      this.getDepartments();
    }

    this.getEmployee();
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
    getEmployee() {
      const id = this.$route.params.employee;

      this.remote = this.errors = null;

      this.$http.get(`people/employees/${id}`)
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
    }),
  },
  watch: {
    $route: 'getEmployee',
  },
};
</script>

<style lang="scss" scoped>
.card-header {
  padding: 1.25rem;
}
.employee-photo {
  width: 100%;
}
.employee-field {
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

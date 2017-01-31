<template>
<window-box title="Student Profile" subtitle="Edit profile here...">
<template slot="header">
<div>
    <a role="button" @click.prevent="updateProfile" class="btn btn-secondary">
        <i class="fa fa-fw fa-save hidden-lg-up" v-tooltip:bottom="'Update Course'"></i> Update Profile
    </a>
</div>

</template>

<div class="container my-1">
    <div class="row">
      <div class="col-xs-12 col-lg-4 text-xs-center">
          <div class="card" ref="sidebar">
              <photo-holder class="profile-photo" style="width: 100%; padding-bottom: 100%"
                          :dest="`people/students/${id}/photo`"
                          @uploaded="profileUpdated">
                  <img class="student-photo" :src="student.photo">
              </photo-holder>
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
                        <div class="col-xs-6 col-md-6">
                            <div class="student-field">
                                <input-text title="First Name" v-model="student.first_name"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <div class="student-field">
                                <input-text title="Last Name" v-model="student.last_name"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-radio title="Gender" v-model="student.gender" :options="genders"></input-radio>
                            </div>
                        </div>
                            <div class="student-field">
                                <input-text title="Date of Birth" placeholder="DD/MM/YYYY" v-model="dob"></input-text>

                            </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Category" v-model="student.category"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="AADHAR ID" v-model="student.govt_id"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Passport" v-model="student.passport"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Religion" v-model="student.religion"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Mother Tongue" v-model="student.language"></input-text>
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
                                <input-text title="Student UID (Roll Number)" v-model="student.uid"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Date of Joining" placeholder="DD/MM/YYYY" v-model="doj"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-select title="Department" v-model.number="student.department_id" :options="departments"></input-select>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-select title="Discipline" v-model.number="student.discipline_id" :options="disciplines"></input-select>
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
                                <input-text title="Address Line 1" v-model="student.address.address_line1" ></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Address Line 2" v-model="student.address.address_line2" ></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="landmark" v-model="student.address.landmark"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                            <input-select title="City" v-model.number="student.address.city_id" :options="cities"></input-select>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="PIN Code" v-model="student.address.pin_code"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">                                <input-text title="Email" v-model="student.email"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Phone" v-model="student.address.phone"></input-text>
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
import { first, toNumber, isNaN, clone, pickBy } from 'lodash'
import moment from 'moment'
import { mapGetters, mapActions } from 'vuex'
import { getters, actions } from '../../vuex/meta'
import { WindowBox, LoadingPlaceholder, PhotoHolder } from '../../components'

export default {
  name: 'StudentProfileEdit',
  data () {
    return {
      errors: null,
      remote: null,
    };
  },
  computed: {
    genders() {
      return {
          male : 'Male',
          female: 'Female',
      };
    },
    student () {
        const local = this.local || {}
        const remote = this.remote

        if (remote) return remote

        return local
    },
    local () {
        const students = this.students
        const uid = this.$route.params.student

        return first(students.filter(student => student.uid === uid))
    },
    loading () {
        return this.remote === null && this.errors === null
    },
    success () {
        return this.remote !== null
    },
    department () {
        const departments = clone(this.departments)
        const id = this.student.department_id

        return first(departments.filter(d => d.id === id)) || {}
    },
    discipline () {
        const disciplines = this.disciplines
        const id = this.student.discipline_id

        return first(disciplines.filter(d => d.id === id)) || {}
    },
    dob: {
     get () {
      return this.student.date_of_birth ? moment(this.student.date_of_birth).format('DD/MM/YYYY') : ''
     },
     set (value) {
       const date = moment(value, 'DD/MM/YYYY', true)
       if (date.isValid()) {
          this.student.date_of_birth = date.toISOString()
        }
      }
      },
     doj: {
      get () {
        return this.student.date_of_joining ? moment(this.student.date_of_joining).format('DD/MM/YYYY') : ''
      },
      set (value) {
        const date = moment(value, 'DD/MM/YYYY', true)
        if (date.isValid()) {
          this.student.date_of_joining = date.toISOString()
        }
      }
    },
    id() {
      return this.$route.params.student;
    },
    ...mapGetters({
        students: getters.students,
        departments: getters.departments,
        disciplines: getters.disciplines,
        cities: getters.cities,
    })
},
components: { WindowBox, LoadingPlaceholder, PhotoHolder },
created () {
    if (this.departments.length === 0) {
        this.getDepartments()
    }

    if (this.disciplines.length === 0) {
        this.getDisciplines()
    }

    if(this.cities.length == 0 ) {
        this.getCities();
    }
    this.getStudent()
},
filters: {
    currency (value) {
        const amount = toNumber(value)

        if (isNaN(amount)) return '₹ 0'

        return `₹ ${amount}`
    },
    dateForHumans (value) {
        return moment(value).format('D MMMM YYYY')
    }
},
methods: {
    getStudent () {
        const id = this.$route.params.student

        this.remote = this.errors = null

        this.$http.get(`people/students/${id}`)
                .then(response => response.json())
                .then((result) => {
                    this.remote = clone(result);
                    this.remote.address = {
                        'address_line1' : '',
                        'address_line2' : '',
                        'landmark' : '',
                        'city' : '',
                        'pin_code' : '',
                        'email' : '',
                        'phone' : '',
                    };

                })
                .catch((response) => {
                    response.json()
                            .then((result) => {
                                this.errors = result.message;
                            })
                            .catch(() => {
                                this.errors = 'Retry. There was some error apprehending response from server.'
                            })
                })
    },
    updateProfile() {
      const id = this.$route.params.student;
      const student = clone(this.student);
      const payload = this.sanitizeInput(student);

        this.$http.put(`people/students/${id}`, payload )
       .then(() => {
         const name = ''.concat(this.student.first_name, ' ', this.remote.middle_name,  ' ', this.student.last_name);
          this.editUser({
          photo: this.student.photo,
          name,
      })
           if(this.remote.uid !== id) {
            this.$router.push({
                name: 'student.profile',
                params: { student: this.remote.uid }
            });
        } else {
            this.$router.go(-1);
        }
    })
       .catch(response => response);
    },
    sanitizeInput(input) {
      Object.keys(input).forEach(k =>
                    (input[k] && typeof input[k] === 'object') && this.sanitizeInput(input[k]) ||
                    (!input[k] && input[k] !== undefined) && delete input[k]
        );
      return input;
    },
    profileUpdated(src, response) {
       this.student.photo_id = response.body.id;
       this.student.photo = response.body.path;

    },
    ...mapActions({
        getDepartments: actions.getDepartments,
        getDisciplines: actions.getDisciplines,
        getCities: actions.getCities,
        editUser: actions.editUser,
    })
},
watch: {
    $route: 'getStudent'
}
}
</script>

<style lang="scss" scoped>
@import "../../styles/methods";

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

.profile-photo-uploader.overlay {
 top: rem(200px);
}

.value:empty:before {
content: "xxx x xxxx";
opacity: 0.1;
}
</style>

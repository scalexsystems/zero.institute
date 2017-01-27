<template>
<window-box title="Student Profile" subtitle="See profile here...">
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
            <img class="card-img-top student-photo" :src="student.photo">
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
                                <input-text title="Name" v-model="student.name"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-radio title="Gender" v-model="student.gender" :options="genders"></input-radio>
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
                                <div class="label">Date of Admission</div>
                                <div class="value">{{ student.date_of_admission | dateForHumans }}</div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Department" v-model="department.name"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Discipline" v-model="discipline.name"></input-text>
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
                                <div class="value">{{ }}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="landmark" v-model="student.address.landmark"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <div class="label">City</div>
                                <input-text title="city" v-model="student.address.city"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="PIN Code" v-model="student.address.pin_code"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Email" v-model="student.address.email"></input-text>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Phone" v-model="student.address.phone"></input-text>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="box-sep">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Father's Name" v-model="student.father.name"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Father's Phone" v-model="student.father.phone"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Father's Profession" v-model="student.father.profession"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Father's Currency" v-model="student.father.currency"></input-text>

                            </div>
                        </div>
                    </div>
                </div>
                <hr class="box-sep">
                <div class="card-block">
                    <div class="row">
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Mother's Name" v-model="student.mother.name"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Mother's Phone" v-model="student.mother.phone"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Mother's Profession" v-model="student.mother.profession"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Mother's Currency" v-model="student.mother.currency"></input-text>

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
                                <input-text title="Blood Group" v-model="student.blood_group"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Disability" v-model="student.disability"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Major Disease" v-model="student.disease"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Allergy" v-model="student.allergy"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Body Marks / Identification Marks" v-model="student.body_marks"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-4">
                            <div class="student-field">
                                <input-text title="Food Habit" v-model="student.food_habit"></input-text>

                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="student-field">
                                <div class="label">Additional Remarks</div>
                                <textarea title="Phone" v-model="student.address.phone"></textarea>

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
import first from 'lodash/first'
import toNumber from 'lodash/toNumber'
import isNaN from 'lodash/isNaN'
import clone from 'lodash/clone'
import moment from 'moment'
import { mapGetters, mapActions } from 'vuex'

import { getters, actions } from '../../vuex/meta'
import { WindowBox, LoadingPlaceholder,  } from '../../components'

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
        const departments = this.departments
        const id = this.student.department_id

        return first(departments.filter(d => d.id === id)) || {}
    },
    discipline () {
        const disciplines = this.disciplines
        const id = this.student.discipline_id

        return first(disciplines.filter(d => d.id === id)) || {}
    },

    ...mapGetters({
        students: getters.students,
        departments: getters.departments,
        disciplines: getters.disciplines
    })
},
components: { WindowBox, LoadingPlaceholder },
created () {
    if (this.departments.length === 0) {
        this.getDepartments()
    }

    if (this.disciplines.length === 0) {
        this.getDisciplines()
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
                    this.remote = result
                })
                .catch((response) => {
                    response.json()
                            .then((result) => {
                                this.errors = result.message
                            })
                            .catch(() => {
                                this.errors = 'Retry. There was some error apprehending response from server.'
                            })
                })
    },
    updateProfile() {
      const id = this.$route.params.student;
      const { uid, ...student} = clone(this.student);
      this.$http.put(`people/students/${id}`, student )
       .then(response => response.json())
       .then(() =>{
             this.$router.go(-1);
               })
             .catch(response => response);
    },
    ...mapActions({
        getDepartments: actions.getDepartments,
        getDisciplines: actions.getDisciplines
    })
},
watch: {
    $route: 'getStudent'
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

<template>
<container title="Dashboard" subtitle="Brief overview">
  <div class="p-people-dashboard">
    <div class="container py-3">
      <div class="row">
        <div class="col-12 col-lg-8">
          <div class="row">
            <div class="col-12 col-lg-4 mb-3">
              <router-link tag="div" :to="{name: 'student.dashboard'}" class="card card-block ow-student" role="button">
                <div class="title">Students</div>
                <div class="count">{{ statistics.student.count }}</div>
                <div class="subtitle">
                </div>
              </router-link>
            </div>
            <div class="col-12 col-lg-4 mb-3">
              <router-link tag="div" :to="{name: 'teacher.dashboard'}" class="card card-block ow-teacher" role="button">
                <div class="title">Teachers</div>
                <div class="count">{{ statistics.teacher.count }}</div>
                <div class="subtitle">
                </div>
              </router-link>
            </div>
            <div class="col-12 col-lg-4 mb-3">
              <router-link tag="div" :to="{name: 'employee.dashboard'}" class="card card-block ow-employee" role="button">
                <div class="title">Employees</div>
                <div class="count">{{ statistics.employee.count }}</div>
                <div class="subtitle">
                </div>
              </router-link>
            </div>
          </div>
          <div class="card">
            <div class="card-block">
              <div class="row">
                <div class="col-12 col-lg-6">
                  <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/Q0FRHSRaLE8?rel=0&autohide=1&color=white&modestbranding=1&showinfo=0&theme=light"
                            frameborder="0"
                            allowfullscreen></iframe>
                  </div>
                </div>
                <div class="col-12 col-lg-6">
                  <small class="text-primary">What's coming next</small>
                  <br>
                  <h4>Introducing the Hub!</h4>

                  <p>
                    <small>Once you create digital profiles, students and teachers can access the Zero Hub.</small>
                  </p>

                  <p>
                    <small>Hub is a collaborative platform for students and teachers. It is integrated
                      with administrative activities like academics, attendance, events etc.
                    </small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12 col-lg-4">
          <div class="card">
            <h4 class="card-header p-3 bg-white">Zero: Release Schedule</h4>
            <div class="card-block">
              <div class="d-flex flex-row mb-1" v-for="stage of stages" :key="stage">
                <div class="px-1">
                  <i v-if="stage.completed" class="fa fa-check text-success"></i>
                  <i v-else class="fa fa-clock-o text-muted"></i>
                </div>
                <div class="fl-auto">
                  {{ stage.name }} <br>
                  <small class="text-muted">{{ stage.desc }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'

export default {
  computed: {
    stages: () => [
      {
        name: 'Digital Profiles',
        desc: 'Create Profiles for Students and Employees.',
        completed: true
      },
      {
        name: 'Academia',
        desc: 'Courses and discussion hub.',
        completed: true
      },
      {
        name: 'Attendance',
        desc: 'Student attendance via mobile app.'
      },
      {
        name: 'Institute Events',
        desc: 'Add and share institute events.'
      },
      {
        name: 'Registrations and Finances',
        desc: 'Semester Registration and fees.'
      }
    ],
    ...mapGetters('people', ['statistics'])
  },
  methods: mapActions('people', { fetch: 'statistics' }),
  created () {
    if ('$fetch' in this.statistics) {
      this.fetch()
    }
  }
}

</script>

<style lang="scss">
.p-people-dashboard {
  background: #f7f7f7;
}

.ow-student, .ow-teacher, .ow-employee {
  background-position: bottom left;
  background-repeat: no-repeat;
  background-size: auto;

  height: 100%;

  display: flex;
  flex-direction: column;
  text-align: center;

  .title {
    text-transform: uppercase;
    font-weight: bolder;
    letter-spacing: .0625rem;
  }
  .count {
    padding-top: 2rem;
    font-weight: bolder;
    font-size: 3.75rem;
  }
  .subtitle {
    font-size: .875rem;
  }
}

.ow-student {
  background-image: url(../../assets/people/student.svg);
}

.ow-teacher {
  background-image: url(../../assets/people/teacher.svg);
}

.ow-employee {
  background-image: url(../../assets/people/employee.svg);
}
</style>

<template>
  <window-box title="Dashboard" subtitle="Brief overview">
    <div class="container py-2">
      <div class="row">

        <div class="col-xs-12 col-lg-8">
          <div class="row">
            <div class="col-xs-12 col-lg-4 mb-1">
              <div class="card card-block ow-student" role="button" @click="$router.push({name: 'student'})">
                <div class="title">Students</div>
                <div class="count">{{ stats.student }}</div>
                <div class="subtitle">
                  <span :class="{'text-muted': studentRequests.count == 0, 'text-danger': studentRequests.count > 0}">
                    {{ studentRequests.count_text }}
                  </span>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-lg-4 mb-1">
              <div class="card card-block ow-teacher" role="button" @click="$router.push({name: 'teacher'})">
                <div class="title">Teachers</div>
                <div class="count">{{ stats.teacher }}</div>
                <div class="subtitle">
                  <span :class="{'text-muted': teacherRequests.count == 0, 'text-danger': teacherRequests.count > 0}">
                    {{ teacherRequests.count_text }}
                  </span>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-lg-4 mb-1">
              <div class="card card-block ow-employee" role="button" @click="$router.push({name: 'employee'})">
                <div class="title">Employees</div>
                <div class="count">{{ stats.employee }}</div>
                <div class="subtitle">
                  <span :class="{'text-muted': employeeRequests.count == 0, 'text-danger': employeeRequests.count > 0}">
                    {{ employeeRequests.count_text }}
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-block">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <div class="embed-responsive embed-responsive-16by9">
                      <iframe class="embed-responsive-item"
                              src="https://www.youtube.com/embed/MA7pMfnP-r4?rel=0&autohide=1&color=white&modestbranding=1&showinfo=0&theme=light" frameborder="0"
                              allowfullscreen></iframe>
                  </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                  <small class="text-primary">On-boarding</small>
                  <br>
                  <h4>Setup Zero in 5 Minutes</h4>

                  <p>
                      <small>Welcome to Scalex Zero. Watch this video to setup your institute on Zero.</small>
                  </p>

                  <p>
                      <small>Add Disciplines (e.g. B.Tech,M.Tech) <br>
                          Add Departments (e.g. Mechanical Engineering) <br>
                          Approve profiles of students, teachers and employees.</small>
                  </p>
                </div>
              </div>
            </div>
            <div class="card-block py-0">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/Q0FRHSRaLE8?rel=0&autohide=1&color=white&modestbranding=1&showinfo=0&theme=light" frameborder="0"
                                allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-6">
                    <small class="text-primary">What's coming next</small>
                    <br>
                    <h4>Introducing the Hub!</h4>

                    <p>
                        <small>Once you create digital profiles, students and teachers can access the Zero Hub.</small>
                    </p>

                    <p>
                        <small>Hub is a collaborative platform for students and teachers. It is integrated
                            with administrative activities like academics, attendance, events etc.</small>
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-lg-4">
          <div class="card">
            <h4 class="card-header py-1 px-2 bg-white">Zero: Release Schedule</h4>
            <div class="card-block">
              <div class="fl mb-1" v-for="stage of stages">
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
  </window-box>
</template>

<script lang="babel">
import { WindowBox } from '../components';

export default {
  components: { WindowBox },
  computed: {
    stats: () => ({
      student: 0,
      teacher: 0,
      employee: 0,
    }),
    studentRequests: () => ({ count: 0, count_text: '0 requests pending' }),
    teacherRequests: () => ({ count: 0, count_text: '0 requests pending' }),
    employeeRequests: () => ({ count: 0, count_text: '0 requests pending' }),
    stages: () => [
      {
        name: 'Digital Profiles',
        desc: 'Create Profiles for Students and Employees.',
        completed: true,
      },
      {
        name: 'Academia',
        desc: 'Courses and discussion hub.',
        completed: true,
      },
      {
        name: 'Attendance',
        desc: 'Student attendance via mobile app.',
      },
      {
        name: 'Institute Events',
        desc: 'Add and share institute events.',
      },
      {
        name: 'Registrations and Finances',
        desc: 'Semester Registration and fees.',
      },
    ],
  },
};
</script>

<style lang="scss">
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
    background-image: url(../assets/people/student.svg);
}
.ow-teacher {
    background-image: url(../assets/people/teacher.svg);
}
.ow-employee {
    background-image: url(../assets/people/employee.svg);
}
</style>

<template>
<container title="Students Directory" subtitle="Explore students' information" @back="$router.go(-1)" back>
  <div class="container py-3 student-list">
    <div class="row">
      <div class="col-12 col-lg-3">
        <div class="card card-block">
          <div class="row">
            <div class="col-6 col-md-12 mb-1">
              <checkbox-wrapper title="Dicipline">
                <input-box v-for="item of disciplines" :checkbox="item.id" v-model="discipline" :title="item.name"
                           :custom="false"/>
              </checkbox-wrapper>
            </div>
            <div class="col-6 col-md-12">
              <checkbox-wrapper title="Department">
                <input-box v-for="item of departments" :checkbox="item.id" v-model="department" :title="item.name"
                           :custom="false"/>
              </checkbox-wrapper>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-9">
        <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>

        <div class="card">
          <div class="card-header bg-white">
            <div class="title">{{ searchText }}</div>

            <div class="text-muted">
              {{ countText }}
            </div>
          </div>
          <div class="card-block">
            <infinite-loader class="row" @infinite="onInfinite">
              <router-link tag="div" class="col-12 col-lg-6 student-card" role="button"
                           v-for="student of students" :key="student"
                           :to="{ name: 'student.show', params: { uid: student.uid } }">
                <student-card :student="student"/>
              </router-link>
            </infinite-loader>
          </div>
        </div>
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapGetters, mapActions } from 'vuex'
import { notLastPage, nextPage, toArray, toInt } from '../../../util'
import StudentCard from '../../../components/student/Card.vue'

export default {
  name: 'StudentDirectory',

  data: () => ({
    discipline: [],
    department: [],
    students: [],
    query: '',
    ignoreChanges: false,
    page: 1
  }),

  computed: {
    countText () {
      const students = this.students

      return students.length === 1 ? '1 student' : `${students.length} students`
    },
    searchText () {
      return 'All Students'
    },
    ...mapGetters({
      departments: 'departments/academic',
      disciplines: 'disciplines/disciplines'
    })
  },

  methods: {
    onInput: throttle(function onInput() {
      this.page = 1
      this.fetch()
    }, 400),
    async onInfinite ({ loaded, complete }) {
      notLastPage(await this.fetch()) ? loaded() : complete()
    },
    async fetch () {
      const { students, meta } = await this.getStudents(
          { page: this.page, q: this.query, department: this.department, discipline: this.discipline }
      )

      if (students) {
        if (this.page === 1) {
          this.students = students
        } else {
          this.students.push(...students.filter(s => this.students.findIndex(o => o.id === s.id) < 0))
        }
      } else {
        this.students = []
      }

      this.page = nextPage(meta)

      return meta
    },
    go () {
      const query = {}

      if (this.ignoreChanges) return

      if (this.query.trim().length) {
        query.q = this.query
      }

      if (this.discipline.length) {
        query.discipline = this.discipline.slice()
      }

      if (this.department.length) {
        query.department = this.department.slice()
      }

      this.$router.replace({ name: 'student.index', query })
    },

    getRouteParams () {
      this.ignoreChanges = true
      this.page = 1
      this.query = this.$route.query.q || ''
      this.discipline = toArray(this.$route.query.discipline || []).map(toInt)
      this.department = toArray(this.$route.query.department || []).map(toInt)
      this.$nextTick(() => {
        this.ignoreChanges = false
      })
      this.fetch()
    },
    ...mapActions('students', { getStudents: 'index' })
  },

  created () {
    this.getRouteParams()
  },

  components: { StudentCard },

  watch: {
    discipline: 'go',
    department: 'go',
    $route: 'getRouteParams'
  }
}
</script>

<style lang="scss" scoped>
@import '../../../styles/variables';
@import '../../../styles/mixins';

.card-header {
  @include media-breakpoint-up(lg) {
    display: flex;
    flex-direction: row;

    > * {
      align-self: baseline;
    }
  }
}

.title {
  font-size: 1.5rem;
  flex: 1;
}

.search-box {
  padding: 1.25rem;
}
</style>

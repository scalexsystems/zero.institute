<template>
<container title="Teachers Directory" subtitle="Explore teachers' information" @back="$router.go(-1)" back>
    <div class="container py-3 teacher-list">
      <div class="row">
        <div class="col-xs-12 col-lg-3">
          <div class="card card-block">
            <div class=row">
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
                      <router-link tag="div" class="col-12 col-lg-6 teacher-card"
                                   v-for="teacher of teachers" :key="teacher"
                                   :to="{ name: 'teacher.show', params: { uid: teacher.uid } }">
                          <teacher-card :teacher="teacher"/>
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
import TeacherCard from '../../../components/teacher/Card.vue'

export default {
  name: 'teacherSearchResults',
  data: () => ({
    department: [],
    students: [],
    query: '',
    ignoreChanges: false,
    page: 1
  }),
  components: { WindowBox, PersonCard, InfiniteLoader },
  computed: {
    countText () {
      const teachers = this.teachers

      return teachers.length === 1 ? '1 teacher' : `${teachers.length} teachers`
    },
    searchText () {
      return 'All teachers'
    },
    ...mapGetters({
      source: getters.teachers,
      departments: getters.departments
    })
  },
  created () {
      this.getRouteParams();
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
          const { teachers, meta } = await this.getTeachers(
                  { page: this.page, q: this.query, department: this.department }
          )

          if (teachers) {
              if (this.page === 1) {
                  this.teachers = teachers
              } else {
                  this.teachers.push(...teachers)
              }
          } else {
              this.teachers = []
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

      if (this.department.length) {
        query.department = this.department
      }

      this.$router.replace({ name: 'teacher.index', query })
    },
    getRouteParams () {
      this.ignoreChanges = true
      this.page = 1
      this.query = this.$route.query.q || ''
      this.department = toArray(this.$route.query.department || []).map(toInt)
      this.$nextTick(() => {
        this.ignoreChanges = false
      })
    },
    ...mapActions({
      getTeachers: actions.getTeachers,
      getDepartments: actions.getDepartments
    })
  },
  watch: {
    department: 'go',
    query: 'go',
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

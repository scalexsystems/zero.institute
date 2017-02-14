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
        <div class="col-xs-12 col-lg-9">
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
                        <router-link tag="div" class="col-12 col-lg-6 employee-card"
                                     v-for="employee of employees" :key="employee"
                                     :to="{ name: 'employee.show', params: { uid: employee.uid } }">
                            <employee-card :employee="employee"/>
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
import EmployeeCard from '../../../components/employee/Card.vue'

export default {
  name: 'employeeSearchResults',
  components: { WindowBox, PersonCard, InfiniteLoader },
  computed: {
    countText () {
      const employees = this.employees

      return employees.length === 1 ? '1 employee' : `${employees.length} employees`
    },
    searchText () {
      return 'All employees'
    },
    filteredSource () {
      const departments = this.department
      const source = this.source

      if (!departments.length) {
        return source
      }

      return source.filter((item) => {
        if (departments.length && departments.indexOf(item.department_id) < 0) {
          return false
        }

        return true
      })
    },
    searchable () {
      const source = this.filteredSource

      return new Sifter(source)
    },
    employees () {
      const searchable = this.searchable
      const query = this.query
      const results = searchable.search(query, {
        fields: ['name', 'uid'],
        sort: [{ field: 'name', direction: 'asc' }],
        sort_empty: [{ field: 'name', direction: 'asc' }]
      })

      return results.items.map(({ id }) => this.source[id])
    },
    ...mapGetters({
      source: getters.employees,
      departments: getters.departments
    })
  },
  data () {
    return {
      reviewingRequests: false,
      department: [],
      query: '',
      ignoreChanges: false,
      page: 0
    }
  },
  created () {
    if (this.departments.length === 0) {
      this.getDepartments()
    }

    this.getRouteParams()
  },
  methods: {
    onLoad ({ done }) {
      this.getEmployees({ page: this.page + 1 })
          .then((result) => {
            done()

            if (!('data' in result)) return

            this.page = get(result, '_meta.pagination.current_page', 0)
          })
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

      this.$debug('UpdateRoute', query)

      this.$router.replace({ name: 'employee.find', query })
    },
    getRouteParams () {
      this.$debug('LoadRoute', this.$route.query)
      this.ignoreChanges = true
      this.page = 0
      this.query = this.$route.query.q || ''
      this.department = toArray(this.$route.query.department).map(toInt)
      this.$nextTick(() => {
        this.ignoreChanges = false
      })
    },
    ...mapActions({
      getEmployees: actions.getEmployees,
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
@import '../../styles/variables';
@import '../../styles/mixins';

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

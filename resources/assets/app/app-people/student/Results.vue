<template>
  <window-box title="Find Students" subtitle="View students and new student requests">
    <div class="container py-1 student-list">
      <div class="row">
        <div class="col-xs-12 col-lg-3">
          <div class="card card-block">
            <label class="custom-control custom-checkbox text-danger mb-0">
              <input name="discipline" class="custom-control-input" type="checkbox"
                     v-model="reviewingRequests">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">New Requests</span>
            </label>
          </div>
          <div class="card card-block" :class="{'hidden-sm-down': reviewingRequests}">
            <div class="row">
                <div class="col-xs-6 col-md-12 mb-1">
                    <h6 class="text-muted">Discipline</h6>
                    <fieldset :disabled="reviewingRequests">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-checkbox" v-for="item of disciplines">
                                <input name="discipline" class="custom-control-input" type="checkbox"
                                       :value="item.id" v-model="discipline">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{ item.name }}</span>
                            </label>
                        </div>
                    </fieldset>
                </div>
                <div class="col-xs-6 col-md-12">
                    <h6 class="text-muted">Department</h6>
                    <fieldset :disabled="reviewingRequests">
                        <div class="custom-controls-stacked">
                            <label class="custom-control custom-checkbox" v-for="item of departments.filter(i => i.academic)">
                                <input name="department" class="custom-control-input" type="checkbox"
                                       :value="item.id" v-model="department">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">{{ item.name }}</span>
                            </label>
                        </div>
                    </fieldset>
                </div>
              </div>
          </div>
        </div>
        <div class="col-xs-12 col-lg-9">
          <div class="form-group">
            <div class="input-group">
              <span class="input-group-addon search-box">
                <i class="fa fa-fw fa-search"></i>
              </span>
              <input type="text" v-model="query" class="form-control form-control-lg search-box" placeholder="Start typing...">
            </div>
          </div>
          <div class="card">
            <div class="card-header bg-white">
              <div class="title">{{ searchText }}</div>

              <div class="text-muted">
                {{ countText }}
              </div>
            </div>
            <div class="card-block">
              <div class="row">
                <div v-for="student of students" :key="student.id" class="col-xs-12 col-lg-6 student-card">
                  <person-card @open="$router.push({ name: 'student.profile', params: { student: student.uid }})" :item="student"></person-card>
                </div>
                <div class="col-xs-12">
                  <infinite-loader @load="onLoad"></infinite-loader>
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
import Sifter from 'sifter';
import get from 'lodash/get';
import toArray from 'lodash/toArray';
import toInt from 'lodash/toInteger';
import { mapGetters, mapActions } from 'vuex';

import { WindowBox, PersonCard, InfiniteLoader } from '../../components';
import { getters, actions } from '../../vuex/meta';

export default {
  name: 'StudentSearchResults',
  components: { WindowBox, PersonCard, InfiniteLoader },
  computed: {
    countText() {
      const students = this.students;

      return students.length === 1 ? '1 student' : `${students.length} students`;
    },
    searchText() {
      return 'All Students';
    },
    filteredSource() {
      const departments = this.department;
      const disciplines = this.discipline;
      const source = this.source;

      if (!departments.length && !disciplines.length) {
        return source;
      }

      return source.filter((item) => {
        if (departments.length && departments.indexOf(item.department_id) < 0) {
          return false;
        }

        if (disciplines.length && disciplines.indexOf(item.discipline_id) < 0) {
          return false;
        }

        return true;
      });
    },
    searchable() {
      const source = this.filteredSource;

      return new Sifter(source);
    },
    students() {
      const searchable = this.searchable;
      const query = this.query;
      const results = searchable.search(query, {
        fields: ['name', 'uid'],
        sort: [{ field: 'name', direction: 'asc' }],
        sort_empty: [{ field: 'name', direction: 'asc' }],
      });

      return results.items.map(({ id }) => this.source[id]);
    },
    ...mapGetters({
      source: getters.students,
      departments: getters.departments,
      disciplines: getters.disciplines,
    }),
  },
  data() {
    return {
      reviewingRequests: false,
      discipline: [],
      department: [],
      query: '',
      ignoreChanges: false,
      page: 0,
    };
  },
  created() {
    if (this.departments.length === 0) {
      this.getDepartments();
    }

    if (this.disciplines.length === 0) {
      this.getDisciplines();
    }

    this.getRouteParams();
  },
  methods: {
    onLoad({ done }) {
      this.getStudents({ page: this.page + 1 })
          .then((result) => {
            done();

            if (!('data' in result)) return;

            this.page = get(result, '_meta.pagination.current_page', 0);
          });
    },
    go() {
      const query = {};

      if (this.ignoreChanges) return;

      if (this.query.trim().length) {
        query.q = this.query;
      }

      if (this.discipline.length) {
        query.discipline = this.discipline;
      }

      if (this.department.length) {
        query.department = this.department;
      }

      this.$debug('UpdateRoute', query);

      this.$router.replace({ name: 'student.find', query });
    },
    getRouteParams() {
      this.$debug('LoadRoute', this.$route.query);
      this.ignoreChanges = true;
      this.page = 0;
      this.query = this.$route.query.q || '';
      this.discipline = toArray(this.$route.query.discipline).map(toInt);
      this.department = toArray(this.$route.query.department).map(toInt);
      this.$nextTick(() => {
        this.ignoreChanges = false;
      });
    },
    ...mapActions({
      getStudents: actions.getStudents,
      getDepartments: actions.getDepartments,
      getDisciplines: actions.getDisciplines,
    }),
  },
  watch: {
    discipline: 'go',
    department: 'go',
    query: 'go',
    $route: 'getRouteParams',
  },
};
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

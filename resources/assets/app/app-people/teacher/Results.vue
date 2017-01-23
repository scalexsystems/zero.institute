<template>
  <window-box title="Find teachers" subtitle="View teachers and new teacher requests">
    <div class="container py-1 teacher-list">
      <div class="row">
        <div class="col-xs-12 col-lg-3">
          <div class="card card-block">
            <label class="custom-control custom-checkbox text-danger mb-0">
              <input class="custom-control-input" type="checkbox" v-model="reviewingRequests">
              <span class="custom-control-indicator"></span>
              <span class="custom-control-description">New Requests</span>
            </label>
          </div>
          <div class="card card-block" :class="{'hidden-sm-down': reviewingRequests}">
            <div class="row">
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
                <div v-for="teacher of teachers" :key="teacher.id" class="col-xs-12 col-lg-6 teacher-card">
                  <person-card @open="$router.push({ name: 'teacher.profile', params: { teacher: teacher.uid }})" :item="teacher"></person-card>
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
  name: 'teacherSearchResults',
  components: { WindowBox, PersonCard, InfiniteLoader },
  computed: {
    countText() {
      const teachers = this.teachers;

      return teachers.length === 1 ? '1 teacher' : `${teachers.length} teachers`;
    },
    searchText() {
      return 'All teachers';
    },
    filteredSource() {
      const departments = this.department;
      const source = this.source;

      if (!departments.length) {
        return source;
      }

      return source.filter((item) => {
        if (departments.length && departments.indexOf(item.department_id) < 0) {
          return false;
        }

        return true;
      });
    },
    searchable() {
      const source = this.filteredSource;

      return new Sifter(source);
    },
    teachers() {
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
      source: getters.teachers,
      departments: getters.departments,
    }),
  },
  data() {
    return {
      reviewingRequests: false,
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

    this.getRouteParams();
  },
  methods: {
    onLoad({ done }) {
      this.getTeachers({ page: this.page + 1 })
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

      if (this.department.length) {
        query.department = this.department;
      }

      this.$debug('UpdateRoute', query);

      this.$router.replace({ name: 'teacher.find', query });
    },
    getRouteParams() {
      this.$debug('LoadRoute', this.$route.query);
      this.ignoreChanges = true;
      this.page = 0;
      this.query = this.$route.query.q || '';
      this.department = toArray(this.$route.query.department).map(toInt);
      this.$nextTick(() => {
        this.ignoreChanges = false;
      });
    },
    ...mapActions({
      getTeachers: actions.getTeachers,
      getDepartments: actions.getDepartments,
    }),
  },
  watch: {
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

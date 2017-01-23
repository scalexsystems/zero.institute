<template>
  <window-box title="Employees" subtitle="Search employees">
    <div slot="header">
      <a role="button" class="btn btn-secondary" @click.prevent="$router.go(-1)">
        <i class="fa fa-fw fa-arrow-left"></i> Back
      </a>
    </div>

    <div class="employee-search-container">
        <div class="container">
            <h3 class="text-xs-center">Employees</h3>
            <div class="row">
                <div class="col-xs-12 col-md-6 offset-md-3 m-t-1">
                    <input-search v-model="query" v-bind="{ suggestions }" component="search-option-person"
                        @suggest="onSearchInput" @search="onSearch" @select="onSelect"></input-search>
                </div>
            </div>
            <p class="text-xs-center">
                Find employees by their employee ID or name.
            </p>
        </div>
    </div>

    <div class="container people-d-links">
        <div class="card text-xs-center">
            <div class="card-block">
                <h5>Departments</h5>

                <div class="item" v-for="department of departments">
                    <router-link :to="{name: 'employee.find', query: {department: [department.id]}}" class="btn btn-secondary">
                        {{ department.name }}
                    </router-link>
                </div>
            </div>
        </div>
    </div>
  </window-box>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex';
import throttle from 'lodash/throttle';

import { getters, actions } from '../../vuex/meta';
import { WindowBox } from '../../components';

export default {
  name: 'employeeSearch',
  components: { WindowBox },
  computed: {
    ...mapGetters({
      suggestions: getters.employees,
      departments: getters.departments,
    }),
  },
  data() {
    return {
      query: '',
    };
  },
  created() {
    if (this.departments.length === 0) {
      this.getDepartments();
    }
  },
  methods: {
    onSearchInput: throttle(function onSearchInput({ start, end, value }) {
      start();
      this.getemployees({ q: value }).then(() => end());
    }),
    onSearch() {
      this.$router.push({ name: 'employee.find', query: { q: this.query } });
    },
    onSelect(employee) {
      this.$debug(employee);
    },
    ...mapActions({
      getemployees: actions.getemployees,
      getDepartments: actions.getDepartments,
    }),
  },
};
</script>

<style lang="scss" scoped>
@import '../../styles/variables';
@import '../../styles/mixins';

.employee-search-container {
  background-size: cover;
  padding-top: 8rem;
  padding-bottom: 11rem;
  margin-bottom: -5rem;
  color: white;

  h3 {
      text-transform: uppercase;
      letter-spacing: rem(2px);
  }

  background-image: linear-gradient(to right, rgba(0, 0, 0, .35), rgba(0, 0, 0, .35)), url(./assets/m-cover.jpg);

  @include media-breakpoint-up(md) {
      background-image: linear-gradient(to right, rgba(0, 0, 0, .35), rgba(0, 0, 0, .35)), url(./assets/cover.jpg);
  }
}
</style>

<style lang="scss">
@import '../../styles/variables';
@import '../../styles/mixins';

.people-d-links {
    h5 {
        text-transform: uppercase;
        letter-spacing: rem(1px);
    }
    .item {
        margin: 1rem;
        display: inline-block;
    }
}
</style>

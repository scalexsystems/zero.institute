<template>
<container title="Employees" subtitle="Search employees" @back="$router.go(-1)" back>
  <div class="employee-search-container">
    <div class="container">
      <h3 class="text-center">Employees</h3>
      <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
          <typeahead v-model="query" input-class="form-control-lg" @select="onSelect" @enter="onSearch"
                     @search="onInput" component="SelectOptionUser" v-bind="{ suggestions }"/>
        </div>
      </div>
      <p class="text-center">
        Find employees by their roll number or name.
      </p>
    </div>
  </div>

  <div class="container people-d-links">
    <div class="card text-center">
      <div class="card-block">
        <h5>Departments</h5>

        <div class="item" v-for="department of departments">
          <router-link :to="{name: 'employee.index', query: {department: [department.id]}}" class="btn btn-secondary">
            {{ department.name }}
          </router-link>
        </div>
      </div>
    </div>
  </div>
</container>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import mixin from '../search'

export default {
  name: 'EmployeeDashboard',

  data: () => ({
    type: 'employee'
  }),

  computed: mapGetters({ departments: 'departments/departments' }),

  methods: {
    async callAPI (q) {
      const { employees } = await
      this.index({ q })

      return { items: employees }
    },
    ...mapActions('employees', ['index'])
  },

  mixins: [mixin]
}
</script>

<style lang="scss" scoped>
@import '../../../styles/variables';
@import '../../../styles/mixins';

.employee-search-container {
  background-size: cover;
  padding-top: 8rem;
  padding-bottom: 11rem;
  margin-bottom: -5rem;
  color: white;

  h3 {
    text-transform: uppercase;
    letter-spacing: to-rem(2px);
  }

  background-image: linear-gradient(to right, rgba(0, 0, 0, .35), rgba(0, 0, 0, .35)), url(./assets/m-cover.jpg);

  @include media-breakpoint-up(md) {
    background-image: linear-gradient(to right, rgba(0, 0, 0, .35), rgba(0, 0, 0, .35)), url(./assets/cover.jpg);
  }
}
</style>

<style lang="scss">
@import '../../../styles/variables';
@import '../../../styles/mixins';

.people-d-links {
  h5 {
    text-transform: uppercase;
    letter-spacing: to-rem(1px);
  }
  .item {
    margin: 1rem;
    display: inline-block;
  }
}
</style>

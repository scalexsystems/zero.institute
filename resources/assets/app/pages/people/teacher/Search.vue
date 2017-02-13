<template>
<container title="Teachers" subtitle="Search teachers" @back="$router.go(-1)" back>

  <div class="teacher-search-container">
    <div class="container">
      <h3 class="text-center">Teachers</h3>
      <div class="row">
        <div class="col-12 col-md-6 offset-md-3 m-t-1">
          <typeahead v-model="query" input-class="form-control-lg" @select="onSelect" @search="onSearch"
                     @input="onSearchInput" component="SelectOptionUser" v-bind="{ suggestions }"/>
        </div>
      </div>
      <p class="text-center">
        Find teachers by their teacher ID or name.
      </p>
    </div>
  </div>

  <div class="container people-d-links">
    <div class="card text-center">
      <div class="card-block">
        <h5>Departments</h5>

        <div class="item" v-for="department of departments">
          <router-link :to="{name: 'teacher.index', query: {department: [department.id]}}" class="btn btn-secondary">
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
import throttle from 'lodash/throttle'

export default {
  name: 'TeacherDashboard',
  data: () => ({
    query: '',
    suggestions: []
  }),
  computed: mapGetters({ departments: 'departments/academic' }),

  methods: {
    onSearchInput: throttle(function onSearchInput() {
      this.fetch()
    }, 400),
    async fetch () {
      const { teachers } = await this.getTeachers({ q: this.query })

      if (teachers) {
        this.suggestions = teachers
      }
    },
    onSearch () {
      this.$router.push({ name: 'teacher.index', query: { q: this.query }})
    },
    onSelect (teacher) {
      this.$debug(teacher)
    },
    ...mapActions('teachers', { getTeachers: 'index' })
  },

  created () {
    this.fetch()
  }
}
</script>

<style lang="scss" scoped>
@import '../../../styles/variables';
@import '../../../styles/mixins';

.teacher-search-container {
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

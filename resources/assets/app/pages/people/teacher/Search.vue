<template>
<container title="Teachers" subtitle="Search teachers" @back="$router.go(-1)" back>
  <div class="teacher-search-container">
    <div class="container">
      <h3 class="text-center">Teachers</h3>
      <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
          <typeahead v-model="query" input-class="form-control-lg" @select="onSelect" @enter="onSearch"
                     @search="onInput" component="SelectOptionUser" v-bind="{ suggestions }"/>
        </div>
      </div>
      <p class="text-center">
        Find teachers by their roll number or name.
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
import mixin from '../search'

export default {
  name: 'TeacherDashboard',

  data: () => ({
    type: 'teacher'
  }),

  computed: mapGetters({ departments: 'departments/academic' }),

  methods: {
    async callAPI (q) {
      const { teachers } = await this.index({ q })

      return { items: teachers }
    },
    ...mapActions('teachers', ['index'])
  },

  mixins: [mixin]
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

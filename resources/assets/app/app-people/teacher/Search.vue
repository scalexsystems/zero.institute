<template>
  <window-box title="Teachers" subtitle="Search teachers">
    <div slot="header">
      <a role="button" class="btn btn-secondary" @click.prevent="$router.go(-1)">
        <i class="fa fa-fw fa-arrow-left"></i> Back
      </a>
    </div>

    <div class="teacher-search-container">
        <div class="container">
            <h3 class="text-xs-center">Teachers</h3>
            <div class="row">
                <div class="col-xs-12 col-md-6 offset-md-3 m-t-1">
                    <input-search v-model="query" v-bind="{ suggestions }" component="search-option-person"
                        @suggest="onSearchInput" @search="onSearch" @select="onSelect"></input-search>
                </div>
            </div>
            <p class="text-xs-center">
                Find teachers by their teacher ID or name.
            </p>
        </div>
    </div>

    <div class="container people-d-links">
        <div class="card text-xs-center">
            <div class="card-block">
                <h5>Departments</h5>

                <div class="item" v-for="department of departments.filter(i => i.academic)">
                    <router-link :to="{name: 'teacher.find', query: {department: [department.id]}}" class="btn btn-secondary">
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
  name: 'teacherSearch',
  components: { WindowBox },
  computed: {
    ...mapGetters({
      suggestions: getters.teachers,
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
      this.getteachers({ q: value }).then(() => end());
    }),
    onSearch() {
      this.$router.push({ name: 'teacher.find', query: { q: this.query } });
    },
    onSelect(teacher) {
      this.$debug(teacher);
    },
    ...mapActions({
      getteachers: actions.getteachers,
      getDepartments: actions.getDepartments,
    }),
  },
};
</script>

<style lang="scss" scoped>
@import '../../styles/variables';
@import '../../styles/mixins';

.teacher-search-container {
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

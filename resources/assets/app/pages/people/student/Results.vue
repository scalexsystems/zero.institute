<template>
<container title="Students Directory" subtitle="Explore students' information" @back="$router.go(-1)" back>
  <div class="container py-3 student-list">
    <div class="row">
      <div class="col-12 col-lg-3">
        <div class="card card-block">
          <div class="row">
            <div class="col-6 col-md-12 mb-1">
              <checkbox-wrapper title="Dicipline">
                <input-box v-for="item of disciplines" :key="item" :checkbox="item.id" v-model="discipline" :title="item.name"
                           :custom="false"/>
              </checkbox-wrapper>
            </div>
            <div class="col-6 col-md-12">
              <checkbox-wrapper title="Department">
                <input-box v-for="item of departments" :key="item" :checkbox="item.id" v-model="department" :title="item.name"
                           :custom="false"/>
              </checkbox-wrapper>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-9">
        <input-search v-model="query" input-class="form-control-lg" @input="onInput"></input-search>

        <div class="card">
          <div class="card-header bg-white d-flex flex-row">
            <h5 class="mb-0">{{ searchText }}</h5>

            <div class="text-muted ml-auto">
              {{ countText }}
            </div>
          </div>
          <div class="card-block">
            <infinite-loader class="row" @infinite="onInfinite">
              <router-link tag="div" class="col-12 col-lg-6 student-card mb-3" role="button"
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
import { mapGetters, mapActions } from 'vuex'
import mixin from '../results'

export default {
  name: 'StudentDirectory',

  data: () => ({
    discipline: []
  }),

  computed: {
    type: () => 'student',
    students () {
      return this.items
    },
    ...mapGetters({
      departments: 'departments/academic',
      disciplines: 'disciplines/disciplines'
    })
  },

  methods: {
    async callAPI () {
      const { students, meta } = await this.index(
          { page: this.page, q: this.query, department: this.department, discipline: this.discipline }
      )

      return { items: students, meta }
    },
    ...mapActions('students', ['index'])
  },

  mixins: [mixin]
}
</script>

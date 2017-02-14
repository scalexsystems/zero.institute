<template>
<container title="Teachers Directory" subtitle="Explore teachers' information" @back="$router.go(-1)" back>
  <div class="container py-3 teacher-list">
    <div class="row">
      <div class="col-12 col-lg-3">
        <div class="card card-block">
          <div class="row">
            <div class="col-12">
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
          <div class="card-header bg-white d-flex flex-row">
            <h5 class="mb-0">{{ searchText }}</h5>

            <div class="text-muted ml-auto">
              {{ countText }}
            </div>
          </div>
          <div class="card-block">
            <infinite-loader class="row" @infinite="onInfinite">
              <router-link tag="div" class="col-12 col-lg-6 teacher-card mb-3" role="button"
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
import { mapGetters, mapActions } from 'vuex'
import mixin from '../results'

export default {
  name: 'TeacherDirectory',

  computed: {
    type: () => 'teacher',
    teachers () {
      return this.items
    },
    ...mapGetters({
      departments: 'departments/academic'
    })
  },

  methods: {
    async callAPI () {
      const { teachers, meta } = await this.index({ page: this.page, q: this.query, department: this.department })

      return { items: teachers, meta }
    },
    ...mapActions('teachers', ['index'])
  },

  mixins: [mixin]
}
</script>

<template>
<container-window title="Courses" subtitle="Join or create courses" back @back="$router.go(-1)">
  <template slot="buttons">
  <router-link :to="{ name: 'course.create' }" class="btn btn-primary">Create Course</router-link>
  </template>

  <searchable-list v-model="query" placeholder="Start typing..." ref="list"
                   @infinite="({ complete }) => complete()" class="my-3">
    <div class="row">
      <router-link class="col-12 col-lg-6 mt-3 no-link" v-for="course in items" :key="course"
                   :to="{ name: 'course.show', params: { id: course.id } }">
        <course-card :course="course"/>
      </router-link>
    </div>
  </searchable-list>
</container-window>
</template>

<script lang="babel">
import Sifter from 'sifter'
import { mapGetters, mapActions } from 'vuex'

import CourseCard from '../../components/course/Card.vue'

export default {
  name: 'CourseDirectory',

  data: () => ({
    query: ''
  }),

  computed: {
    items () {
      const query = this.query
      const index = new Sifter(this.courses || [])

      const result = index.search(query, { fields: ['name', 'code'] })

      return result.items.map(({ id }) => this.courses[id])
    },
    ...mapGetters('courses', ['courses'])
  },

  methods: {
    ...mapActions('courses', ['index'])
  },

  created () {
    this.index()
  },

  components: { CourseCard }
}
</script>

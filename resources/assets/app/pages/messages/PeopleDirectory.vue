<template>
<container-window title="People" subtitle="Send direct messages" :back="true" @back="$router.go(-1)">
  <searchable-list v-model="query" placeholder="Start typing..." ref="list"
                   @search="onSearch" @infinite="onLoad">
    <div class="row">
      <div class="col-12 col-lg-6 mt-3" v-for="person in persons" :key="person">
        <user-card :user="person" role="button" @click.native="goToUser(person)"></user-card>
      </div>
    </div>
  </searchable-list>
</container-window>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions } from 'vuex'

import UserCard from '../../components/user/Card.vue'

export default {
  name: 'PeopleDirectory',

  data () {
    return {
      page: 1,
      query: '',
      persons: []
    }
  },

  methods: {
    onSearch: throttle(function onSearch () {
      this.$refs.list.$emit('reset')
      this.page = 1
      this.onLoad()
    }, 800),
    async onLoad ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta, items } = await this.index({ page: this.page, query: this.query })

      if (meta) {
        if (this.page === 1) {
          this.persons = []
        }

        if (items) this.persons.splice(this.persons.length, 0, ...items)

        this.page = meta.pagination.current_page + 1

        if (meta.pagination.current_page < meta.pagination.total_pages) {
          loaded()

          return true
        }
      }
      complete()
    },
    goToUser (user) {
      this.$router.push({ name: 'user.messages', params: { id: user.user_id }})
    },
    ...mapActions('people', ['index'])
  },

  created () {
    if (this.persons.length === 0) this.index()
  },

  components: { UserCard }
}
</script>


<style lang="scss">
</style>

<template>
<container-window title="Groups" subtitle="Join or create groups" :back="true" @back="$router.go(-1)">
  <template slot="buttons">
  <router-link :to="{ name: 'group.create' }" class="btn btn-primary"
               role="button">Create Group
  </router-link>
  </template>


  <searchable-list v-model="query" placeholder="Start typing..." ref="list"
                   @search="onSearch" @load="onLoad">
    <div class="row my-3">
      <div class="col-12 col-lg-6" v-for="group in groups" :key="group">
        <group-card :group="group" role="button"
                    @click="$router.push({ name: 'group.show', params: { id: group.id } })"
        ></group-card>
      </div>
    </div>
  </searchable-list>
</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'

import GroupCard from '../../components/group/Card.vue'

export default {
  name: 'GroupDirectory',

  data () {
    return {
      page: 1,
      query: ''
    }
  },

  computed: {
    ...mapGetters('groups', ['groups'])
  },

  methods: {
    onSearch () {
      this.page = 1
      this.$refs.list.$emit('reset')

      this.index({ page: this.page, query: this.query })
    },
    onLoad ({ loaded, complete }) {
      const result = this.index({ page: this.page, query: this.query })

      if (!result) {
        complete()
        return
      }

      this.page = result.meta.pagination.next_page

      if (result.meta.pagination.current_page === result.meta.pagination.total_pages) {
        complete()
      } else {
        loaded()
      }
    },
    ...mapActions('groups', ['index'])
  },

  created () {
    if (this.groups.length === 0) this.index()
  },

  components: { GroupCard }
}
</script>


<style lang="scss">
</style>

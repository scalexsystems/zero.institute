<template>
<container-window title="Groups" subtitle="Join or create groups" :back="true" @back="$router.go(-1)">
  <template slot="buttons">
  <router-link :to="{ name: 'group.create' }" class="btn btn-primary"
               role="button">Create Group
  </router-link>
  </template>


  <searchable-list v-model="query" placeholder="Start typing..." ref="list"
                   @search="onSearch" @infinite="onLoad">
    <div class="row">
      <div class="col-12 col-lg-6 mt-3" v-for="group in groups" :key="group">
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
    async onLoad ({ loaded, complete }) {
      const { meta } = await this.index({ page: this.page, query: this.query })


      if (meta) {
        this.page = meta.pagination.next_page

        if (meta.pagination.current_page === meta.pagination.total_pages) {
          complete()
        }

        return true
      }

      loaded()
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

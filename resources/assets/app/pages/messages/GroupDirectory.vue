<template>
<container-window title="Groups" subtitle="Join or create groups" :back="true">
  <searchable-list v-model="query" @search="onSearch" @load="onLoad" ref="list">
    <div class="row">
      <div class="col-12 col-lg-6" v-for="group in groups" :key="group">
        <group-card :group="group"></group-card>
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

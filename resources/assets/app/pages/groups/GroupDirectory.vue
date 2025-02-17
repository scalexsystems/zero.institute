<template>
<container-window title="Groups" subtitle="Join or create groups" :photo="photo">
  <template slot="buttons">
  <router-link :to="{ name: 'group.create' }" class="btn btn-primary"
               role="button">Create Group
  </router-link>
  </template>


  <searchable-list v-model="query" placeholder="Start typing..." ref="list" class="mt-3"
                   @search="onSearch" @infinite="onLoad">
    <div class="row">
      <div class="col-12 col-lg-6 mt-3" v-for="group in groups" :key="group">
        <group-card :group="group" role="button" @click.native="goToGroup(group)"></group-card>
      </div>
    </div>
  </searchable-list>

</container-window>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'
import { mapActions } from 'vuex'
import { notLastPage } from '../../util'
import GroupCard from '../../components/group/Card.vue'
import photo from '../../assets/group-icon.svg'

export default {
  name: 'GroupDirectory',

  data () {
    return {
      page: 1,
      query: '',
      groups: []
    }
  },

  computed: {
    photo: () => photo
  },

  methods: {
    onSearch: throttle(function onSearch() {
      this.$refs.list.$emit('reset')
      this.page = 1
      this.onLoad()
    }, 800),
    async onLoad ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta, groups } = await this.index({ page: this.page, query: this.query })

      if (meta) {
        if (this.page === 1) {
          this.groups = []
        }

        if (groups) this.groups.splice(this.groups.length, 0, ...groups)

        this.page = meta.pagination.current_page + 1

        if (notLastPage(meta)) {
          loaded()

          return true
        }
      }
      complete()
    },
    goToGroup (group) {
      this.$router.push({ name: group.is_member ? 'group.messages' : 'group.show', params: { id: group.id } })
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

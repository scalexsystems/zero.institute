<template>
<container-window v-bind="{ title, subtitle, photo }" @action="onAction">
  <message-browser v-if="group" ref="mb"
                   v-bind="{ messages: group.$messages, dest: `group/${group.id}/attachment` }"
                   v-model="message" @infinite="fetchMessage"></message-browser>
</container-window>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import MessageBrowser from '../../components/hub/MessageBrowser.vue'
import GroupRoute from './mixins/route'

export default {
  name: 'GroupMessages',

  data () {
    return { notFound: false, message: '' }
  },

  computed: {
    title () {
      return this.group ? this.group.name : '...'
    },
    subtitle () {
      return this.group ? this.group.description || 'Click to add purpose of the group.' : '...'
    },
    photo () {
      return this.group ? this.group.photo : ''
    },
    ...mapGetters('groups', {groupById: 'myGroupById', groups: 'myGroups'})
  },

  methods: {
    onAction (type) {
      const params = { id: this.group.id }

      if (type === 'subtitle' && !this.group.description) {
        this.$router.push({ name: 'group.edit', params })

        return //
      }

      this.$router.push({ name: 'group.show', params })
    },
    async fetchMessage ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta } = await this.fetchMessagesAPI({ group: this.group })

      if (meta && meta.pagination.current_page === meta.pagination.total_pages ) {
        complete()

        return true
      }

      loaded()
    },
    ...mapActions('groups', ['send']),
    ...mapActions('groups', { fetchMessagesAPI: 'messages', find: 'myFind' })
  },

  watch: {
    group (group) {
      this.$nextTick(() => this.$refs && this.$refs.mb && this.$refs.mb.$emit('reset'))

      if (!group.$messages_loaded) {
        this.fetchMessage()
      }
    }
  },

  components: { MessageBrowser },
  mixins: [GroupRoute]
}
</script>

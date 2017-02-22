<template>
<container-window v-bind="{ title, subtitle, photo, scroll: false }" @action="onAction">
  <message-browser v-if="group" ref="mb" @send="onSend" @read="onRead"
                   v-bind="{ messages, dest: `groups/${group.id}/attachment`, unread: group.$unread_count }"
                   v-model="message" @infinite="fetchMessage"></message-browser>
</container-window>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import MessageBrowser from '../../components/hub/MessageBrowser.vue'
import GroupRoute from './mixins/route'
import backup from '../../components/hub/backup-message'

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
    messages () {
      return this.group ? this.messagesByGroupId(this.group.id) : []
    },
    ...mapGetters('groups', { groupById: 'myGroupById', groups: 'myGroups', messagesByGroupId: 'messagesByGroupId' })
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

    onSend (payload) {
      const { content, attachments = [], errors = [] } = typeof payload === 'string' ? { content: payload } : payload
      const request = { id: this.group.id, content, extras: { attachments }, errors }

      this.send(request)

      this.clearMessage()
    },

    onRead (messages) {
      this.readAll({ id: this.id, messages })
    },

    async fetchMessage ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta } = await this.fetchMessagesAPI({ group: this.group })

      if (meta && meta.pagination.current_page < meta.pagination.total_pages) {
        loaded()

        return true
      }

      complete()
    },
    ...mapActions('groups', ['send', 'readAll']),
    ...mapActions('groups', { fetchMessagesAPI: 'messages', find: 'myFind' })
  },

  watch: {
    group () {
      this.$nextTick(() => this.$refs && this.$refs.mb && this.$refs.mb.$emit('reset'))
    }
  },

  components: { MessageBrowser },

  mixins: [GroupRoute, backup]
}
</script>

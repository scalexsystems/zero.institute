<template>
<container-window v-bind="{ title, subtitle, photo, scroll: false }" @action="onAction">
  <message-browser v-if="user" ref="mb" @send="onSend" :unread="user.$unread_count" @read="onRead"
                   v-bind="{ messages, dest: `messages/direct/${user.id}/attachment` }"
                   v-model="message" @infinite="fetchMessage"></message-browser>
</container-window>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import MessageBrowser from '../../components/hub/MessageBrowser.vue'
import UserRoute from './mixins/route'
import backup from '../../components/hub/backup-message'

export default {
  name: 'UserMessages',

  data () {
    return { notFound: false, message: '' }
  },

  computed: {
    title () {
      return this.user ? this.user.name : '...'
    },
    subtitle () {
      return this.user ? this.user.description || 'Click to view user profile.' : '...'
    },
    photo () {
      return this.user ? this.user.photo : ''
    },
    messages () {
      return this.user ? this.messagesByUserId(this.user.id) : []
    },
    ...mapGetters('messages', { userById: 'userById', users: 'users', messagesByUserId: 'messagesByUserId' })
  },

  methods: {

    onAction () {
      const params = { id: this.user.id }

      this.$router.push({ name: 'user.show', params })
    },

    onSend (payload) {
      const { content, attachments = [], errors = [] } = typeof payload === 'string' ? { content: payload } : payload
      const request = { id: this.user.id, content, extras: { attachments }, errors }

      this.send(request)

      this.clearMessage()
    },

    onRead (messages) {
      this.readAll({ id: this.id, messages })
    },

    async fetchMessage ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta } = await this.fetchMessagesAPI({ user: this.user })

      if (meta && meta.pagination.current_page < meta.pagination.total_pages) {
        loaded()

        return true
      }

      complete()
    },
    ...mapActions('messages', ['send', 'readAll']),
    ...mapActions('messages', { fetchMessagesAPI: 'fetchMessages', find: 'find' })
  },

  watch: {
    user () {
      this.$nextTick(() => this.$refs && this.$refs.mb && this.$refs.mb.$emit('reset'))
    }
  },

  components: { MessageBrowser },

  mixins: [UserRoute, backup]
}
</script>

<template>
<container-window v-bind="{ title, subtitle, photo, scroll: false }" @action="onAction">
  <message-browser v-if="group.id" ref="mb" @send="onSend" @read="onRead" :unread="group.$unread_count"
                   v-bind="{ messages, dest: `groups/${group.id}/attachment` }"
                   v-model="message" @infinite="fetchMessage"></message-browser>
  <div class="container py-3" v-else-if="notFound">
    <alert type="danger">There is no such course session.</alert>
  </div>
</container-window>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import MessageBrowser from '../../components/hub/MessageBrowser.vue'
import { notLastPage } from '../../util'

export default {
  name: 'CourseSessionMessages',

  props: {
    id: {
      type: Number,
      required: true
    }
  },

  data () {
    return {
      notFound: false,
      message: ''
    }
  },

  computed: {
    title () {
      return this.group.name || '...'
    },
    subtitle () {
      return this.group.id ? this.group.description || 'Click to add purpose of the group.' : '...'
    },
    photo () {
      return this.group.photo
    },
    session () {
      return this.sessionById(this.id)
    },
    group () {
      return this.session ? this.groupById(this.session.group_id) || {} : {}
    },
    messages () {
      return this.group.id ? this.messagesByGroupId(this.group.id) : []
    },
    ...mapGetters('courses', ['sessionById']),
    ...mapGetters('groups', ['messagesByGroupId']),
    ...mapGetters({ groupById: 'groups/myGroupById' })
  },

  methods: {

    onAction (type) {
      if (type === 'subtitle' && !this.group.description) {
        this.$router.push({ name: 'group.edit', params: { id: this.group.id }})

        return //
      }

      this.$router.push({
        name: 'course.session.show',
        params: { course: this.session.course_id, session: this.id }
      })
    },

    onSend (payload) {
      const { content, attachments = [], errors = [] } = typeof payload === 'string' ? { content: payload } : payload
      const request = { id: this.group.id, content, extras: { attachments }, errors }

      this.send(request)

      this.message = ''
    },

    onRead (messages) {
      this.readAll({ id: this.group.id, messages })
    },

    async fetchMessage ({ loaded = () => 0, complete = () => 0 } = {}) {
      const { meta } = await this.fetchMessagesAPI({ group: this.group })

      if (notLastPage(meta)) {
        loaded()

        return true
      }

      complete()
    },

    async getGroup (id) {
      this.notFound = false
      if (!this.groupById(id)) {
        const group = await this.find(id)

        if (!group) {
          this.notFound = true
        }
      }
    },

    ...mapActions('groups', ['send', 'readAll']),
    ...mapActions('groups', { fetchMessagesAPI: 'messages', find: 'myFind' })
  },

  created () {
    this.session && this.getGroup(this.session.group_id)
  },

  watch: {
    session (session) {
      session && this.getGroup(session.group_id)
    },

    group () {
      this.$nextTick(() => this.$refs && this.$refs.mb && this.$refs.mb.$emit('reset'))
    }
  },

  components: { MessageBrowser }
}
</script>

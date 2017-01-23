<template>
<div class="group-messages-wrapper">
  <message-box v-if="context"
               :title="context.name"
               subtitle="Click here to open group information"
               :photo="context.photo"
               type="group"
               @openSubtitle="openTitle"
               @openPhoto="openTitle"
               @openTitle="openTitle">
    <message-list :messages="context.messages"
                  @load-more="getOlderMessages"
                  @seen="markMessagesSeen" ref="messages"></message-list>

    <message-editor slot="footer" ref="input" v-model="message" :dest="`groups/${context.id}/attachment`"
      @send="send" @focused="markMessagesSeen">
    </message-editor>
  </message-box>

  <loading-placeholder v-else></loading-placeholder>
</div>
</template>

<script lang="babel">
import int from 'lodash/toInteger'
import groupHelper from './mixins/group'

export default {
  name: 'Group',
  methods: {
    openTitle () {
      this.$router.push({ name: 'hub.group-preview' })
    }
  },
  mixins: [groupHelper],
  computed: {
    groupId () {
      return int(this.$route.params.group)
    }
  },
  watch: {
    $route (to, from) {
      if (this.message.trim().length) {
        const key = `group.${from.params.group}.message`

        window.localStorage.setItem(key, this.message)
      }

      const key = `group.${to.params.group}.message`

      this.message = window.localStorage.getItem(key) || ''

      return this.findGroup()
    }
  },
  beforeRouteEnter (to, from, next) {
    const key = `group.${to.params.group}.message`

    if (key in window.localStorage) {
      next(vm => vm.$set(vm, 'message', window.localStorage.getItem(key)))
    } else {
      next(vm => vm.$set(vm, 'message', ''))
    }
  },
  beforeRouteLeave (to, from, next) {
    if (this.message.trim().length) {
      const key = `group.${this.context.id}.message`

      window.localStorage.setItem(key, this.message)
    }

    next()
  }
}
</script>

<template>
<container-window v-bind="{ title, subtitle, photo }">
  <message-browser v-if="group" v-bind="{ messages }"></message-browser>
</container-window>
</template>

<script lang="babel">
import { mapActions, mapGetters } from 'vuex'
import MessageBrowser from '../../components/hub/MessageBrowser.vue'

export default {
  name: 'GroupMessages',

  props: {
    id: {
      type: Object,
      required: true
    }
  },

  data () {
    return { notFound: false }
  },

  computed: {
    group () {
      return this.findGroup(this.id)
    },
    title () {
      return this.group.name
    },
    subtitle () {
      return this.group.description
    },
    photo () {
      return this.group.photo
    },
    messages () {
      return this.group.$messages
    },
    ...mapGetters('messages/groups', ['findGroup'])
  },

  methods: {
    ...mapActions('messages/groups', ['fetchMessages', 'send', 'find'])
  },

  watch: {
    id (id) {
      const group = this.findGroup(id)

      if (!group) this.find(id)
    },
    group (group) {
      if (!group.$messages_loaded) this.fetchMessages({ group })
    }
  }
}
</script>

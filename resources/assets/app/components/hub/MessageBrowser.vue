<template>
<div class="c-hub-message-browser d-flex flex-column">
  <message-list v-bind="{ messages }" class="flex-auto p-2" ref="ml" @infinite="any => $emit('infinite', any)"/>
  <message-composer v-bind="{ value, dest }"
                    @input="v => $emit('input', v)"
                    @focus="sendReadReceipts"
                    @send="sendMessage"/>
</div>
</template>

<script lang="babel">
import MessageList from './MessageList.vue'
import MessageComposer from './MessageComposer.vue'

export default {
  name: 'MessageBrowser',

  props: {
    unread: {
      type: Number,
      required: true
    },
    ...MessageComposer.props,
    ...MessageList.props
  },

  components: {
    MessageComposer,
    MessageList
  },

  methods: {
    sendReadReceipts () {
      if (this.unread > 0) {
        this.$emit('read', this.messages.filter(message => message.unread))
      }
    },

    sendMessage (message) {
      this.$emit('send', message)
    }
  },

  created () {
    this.$on('reset', e => this.$refs && this.$refs.ml.$emit('reset', e))
    this.sendReadReceipts()
  },

  watch: {
    messages: 'sendReadReceipts',
    unread: 'sendReadReceipts'
  }
}
</script>

<style lang="scss">
.c-hub-message-browser {
  height: 100%;
  width: 100%;
  position: absolute;
  overflow-x: hidden;
  overflow-y: auto;
}
</style>

<template>
<div class="c-hub-message-browser d-flex flex-column">
  <message-list v-bind="{ messages }" class="flex-auto" ref="ml" @infinite="any => $emit('infinite', any)"/>
  <message-composer v-bind="{ value, dest }" @input="v => $emit('input', v)"/>
</div>
</template>

<script lang="babel">
import MessageList from './MessageList.vue'
import MessageComposer from './MessageComposer.vue'

export default {
  name: 'MessageBrowser',

  props: {
    ...MessageComposer.props,
    ...MessageList.props
  },

  components: {
    MessageComposer,
    MessageList
  },

  created() {
    this.$on('reset', e => this.$refs && this.$refs.ml.$emit('reset', e))
  }
}
</script>

<style lang="scss">
.c-hub-message-browser {
  height: 100%;
}
</style>

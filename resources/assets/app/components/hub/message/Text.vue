<template>
  <div class="c-hub-message-text d-flex flex-row mt-2">
    <sender-photo :sender="message.sender"></sender-photo>

    <div class="text-message d-flex flex-column flex-auto">
      <message-header v-bind="{ message }"></message-header>
      <div class="content" v-html="content"></div>
    </div>
  </div>
</template>

<script lang="babel">
import MessageHeader from './MessageHeader.vue'
import SenderPhoto from './UserIcon.vue'
import mixin from './mixin'

export default {
  name: 'TextMessage',

  components: { MessageHeader, SenderPhoto },
  mixins: [mixin]
}
</script>

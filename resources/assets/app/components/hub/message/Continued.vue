<template>
  <div class="c-hub-message-continued d-flex flex-row">
    <div class="sender-placeholder"></div>

    <div class="text-message d-flex flex-column flex-auto">
      <message-header v-bind="{ message, continued: true }"></message-header>
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

<style lang="scss">
@import '../../../styles/methods';

.c-hub-message-continued {
  .sender-placeholder {
      width: to-rem(36px);
      height: 1px;
      margin: 0 1rem + to-rem(3px) 0 to-rem(3px);
  }
}
</style>

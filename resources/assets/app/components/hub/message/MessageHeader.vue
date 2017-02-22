<template>
<div class="c-hub-message-header" :class="{failed, continued}">
  <a v-show="!continued" class="sender" role="button" @click.stop.prevent="openSenderProfile">{{ sender.name }}</a>
  <span v-show="!continued" class="px-1">&centerdot;</span>
  <span v-if="sending" v-tooltip="'sending'" :class="{ 'float-right': continued }">
    Sending <icon type="circle-o-notch" class="fa-spin"></icon>
  </span>
  <span v-else-if="failed" v-tooltip="failedMessage" :class="{ 'float-right': continued }">Failed <icon type="warning"></icon></span>
  <time v-show="!continued" v-else class="received">{{ receivedAt }}</time>
</div>
</template>

<script>
import moment from 'moment'

export default {
  name: 'MessageMetaHeader',

  props: {
    message: {
      type: Object,
      required: true
    },
    continued: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    sender () {
      return this.message.sender || {}
    },

    receivedAt () {
      const message = this.message

      return moment(message.received_at).format('LT')
    },

    sending () {
      const message = this.message

      return ('$status' in message) && message.$status.sending === true
    },

    failed () {
      const message = this.message

      return ('$status' in message) && message.$status.failed === true
    },

    failedMessage () {
      const message = this.message

      return ('$status' in message) && message.$status.message
    }
  },

  methods: {
    openSenderProfile () {
      this.$router.push({ name: 'user.show', params: { id: this.sender.id }})
    }
  }
}
</script>

<style lang="scss">
@import '../../../styles/variables';

.c-hub-message-header {
  font-size: .71428rem;
  color: $gray-light;

  &.continued {
    height: 0;
    span {
      background: white;
      margin-top: -.5rem;
    }
  }

  // If message sending failed.
  &.failed {
    color: $brand-danger;
  }

  .sender {
    color: $gray-light;
  }
}
</style>

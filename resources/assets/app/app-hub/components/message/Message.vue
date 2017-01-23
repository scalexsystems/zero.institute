<template>
<div class="message-container fl">
  <slot name="sender-photo">
    <img class="message-sender-photo" :class="[message.sender._type]"
         src="assets/people.jpg" :src="message.sender.photo" @click.stop.prevent="onSenderProfile(message.sender)">
  </slot>

  <slot name="message">
    <div class="message-box fl-auto">
      <div class="message-meta" :class="{'text-danger': message.failed === true}">
        <slot name="message-meta">
          <a @click.stop.prevent="onSenderProfile(message.sender)"
             class="message-sender-name" role="button">{{ message.sender.name }}</a>
          &centerdot;
          <time class="message-received-at">{{ message.received_at | time }}</time>

          <i v-if="message.sending" class="fa fa-fw fa-circle-o-notch fa-spin bg-faded text-muted"></i>
          <i v-if="message.failed" class="fa fa-fw fa- fa-spin text-danger"></i>
        </slot>
      </div>

      <div class="message-content">
          <span v-html="content"></span>
          <message-attachment :message="message" v-if="message.attachments"></message-attachment>
          <slot></slot>
      </div>
    </div>
  </slot>
</div>
</template>

<script lang="babel">
import moment from 'moment';
import marked from 'marked';
import { escapeHtml as e, nl2br } from '../../../util';
import MessageAttachment from './MessageAttachment.vue';

export default {
  name: 'Message',
  props: {
    message: {
      required: true,
    },
  },
  components: { MessageAttachment },
  filters: {
    time(date) {
      return moment(date).format('LT');
    },
  },
  computed: {
    content() {
      const message = this.message;

      if (message.type === 'markdown') {
        return marked(message.content, {
          gfm: true,
          tables: true,
          breaks: true,
          pedantic: false,
          sanitize: true,
          smartLists: true,
          smartypants: true,
        });
      }

      return nl2br(e(message.content.trim()));
    },
  },
  methods: {
    onSenderProfile() {
      this.$emit('open-sender', this.message);
    },
  },
};
</script>


<style lang="scss">
@import '../../../styles/variables';
@import '../../../styles/methods';

$border-radius-sm: .2rem !default;

.message-container {
  margin-top: 1rem;
  overflow-x: hidden;
}

.message-sender-photo {
  width: rem(36px);
  height: rem(36px);
  margin: 0 1rem + rem(3px) 0 rem(3px);
  cursor: pointer;

  &.user {
    border-radius: $border-radius-sm;
  }

  &.bot {
    border-radius: 100%;
  }
}

.message-meta {
  font-size: .71428rem;
  color: $gray-light;
}

.message-sender-name {
  color: inherit;
}

.message-content {

}
</style>

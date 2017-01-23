<template>
<div class="message-list-container">
  <infinite-loading :on-infinite="loadMore" ref="infinite"
                    :distance="0" spinner="waveDots"></infinite-loading>

  <div v-if="messages.length" v-for="(message, index) of messages" key="id" class="message-list-item"
       :id="`message-${message.id}`">
    <date-separator v-if="isDateChangingAt(message, index)" :date="message.received_at"
                    :unread="message.id === unread.id" :count="unread.count"></date-separator>
    <template v-else>
    <new-separator v-if="message.id === unread.id" :count="unread.count"></new-separator>
    </template>
    <div :is="decorator(message, index)" :message="message" @focus="$emit('seen', message)"></div>
  </div>
</div>
</template>

<script lang="babel">
import moment from 'moment';
import last from 'lodash/last';
import first from 'lodash/first';

import Message from './message/Message.vue';
import InfiniteLoading from '../../components/PullToRefresh.vue';
import ContinuedMessage from './message/ContinuedMessage.vue';
import DateSeparator from './separator/DateSeparator.vue';
import NewSeparator from './separator/NewSeparator.vue';

function getScrollParent(elm) {
  if (elm.tagName === 'BODY') {
    return window;
  } else if (['scroll', 'auto'].indexOf(window.getComputedStyle(elm).overflowY) > -1) {
    return elm;
  }
  return getScrollParent(elm.parentNode);
}

export default {
  props: {
    messages: {
      required: true,
    },
  },
  components: { Message, ContinuedMessage, DateSeparator, NewSeparator, InfiniteLoading },
  computed: {
    unread() {
      const messages = this.messages;
      const unread = messages.filter(message => message.unread);
      const firstUnread = first(unread);

      if (firstUnread) {
        return { id: firstUnread.id, count: unread.length };
      }

      return { id: undefined, count: 0 };
    },
  },
  created() {
    this.$on('scrollToLast', () => this.scrollInView(last(this.messages)));
    this.$on('scrollToFirst', () => this.scrollInView(first(this.messages)));
    this.$on('reset', () => this.$refs.infinite.$emit('$InfiniteLoading:complete'));
  },
  mounted() {
    this.scrollParent = getScrollParent(this.$el);
    this.$nextTick(() => this.$emit('scrollToLast'));
  },
  data() {
    return {
      scrollParent: null,
      loading: false,
      skipScroll: false,
      hideLoadButton: false,
    };
  },
  methods: {
    scrollInView(message) {
      this.skipScroll = false;
      if (!message) return;

      const element = document.getElementById(`message-${message.id}`);
      if (element) {
        element.scrollIntoView(true);
      }
    },
    decorator(message, index) {
      let type = 'message';

      if (message._type === 'image') {
        type = message._type;
      }

      if (index < 1 || this.isDateChangingAt(message, index) ||
        message.id === this.unread.id ||
        (message.attachments && message.attachments.data.length > 0)
      ) {
        return type;
      }

      const prevMessage = this.messages[index - 1];

      if (prevMessage.sender && message.sender.id === prevMessage.sender.id
              && moment(message.received_at).diff(moment(prevMessage.received_at), 'minutes') < 2) {
        return `continued-${type}`;
      }

      return type;
    },
    isDateChangingAt(message, index) {
      if (index === 0) return true;

      const prevMessage = this.messages[index - 1];

      return !moment(message.received_at).isSame(moment(prevMessage.received_at), 'day');
    },
    loadMore() {
      this.loading = true;
      const toEnd = this.messages.length === 0;

      const done = () => {
        this.loading = false;
        if (toEnd) this.$nextTick(() => this.$emit('scrollToLast'));
        if (this.$refs.infinite) {
          this.$refs.infinite.$emit('$InfiniteLoading:loaded');
        }

        this.$nextTick(() => {
          const sh = this.scrollParent.getBoundingClientRect().height;
          if (sh >= this.$el.getBoundingClientRect().height) {
            this.loadMore();
          }
        });
      };
      const end = () => {
        this.hideLoadButton = true;
        if (toEnd) this.$nextTick(() => this.$emit('scrollToLast'));

        if (this.$refs.infinite) {
          this.$refs.infinite.$emit('$InfiniteLoading:complete');
        }
      };

      this.$emit('load-more', { done, end, error: end });
    },
  },
  watch: {
    messages(n, o) {
      if (this.skipScroll) return;

      this.skipScroll = true;
      const el = this.$el.getBoundingClientRect();

      const ty = this.scrollParent.scrollTop;
      const by = el.height - ty;
      const pre = first(n) === first(o);

      this.$nextTick(() => {
        const height = this.$el.getBoundingClientRect().height;
        const sh = height - by;
        this.skipScroll = false;
        if (pre) {
          this.scrollInView(last(this.messages));
        } else {
          this.scrollParent.scrollTop = sh;
        }
      });
    },
  },
};
</script>


<style lang="scss" scoped>
@import '../../styles/variables';
@import '../../styles/mixins';

.message-list-container {
  padding: 1rem;
  @include media-breakpoint-up(lg) {
    padding: 1rem 1.714rem;
  }

  flex: 1;
  min-height: 100%;

  justify-content: flex-end;
  display: flex;
  flex-direction: column;
  flex-wrap: wrap-reverse;
}
</style>

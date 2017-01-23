<template>
<div class="message-date-separator">
  <hr>
  <div class="message-date-content" :class="{'new-messages': unread}">{{ date | day }} <span v-if="unread">&centerdot;
    {{ text }}</span></div>
  <hr>
</div>
</template>

<script lang="babel">
import moment from 'moment';

export default {
  props: {
    date: {
      require: true,
    },
    unread: {
      default: false,
    },
    count: {
      type: Number,
    },
  },
  filters: {
    day(date) {
      return moment(date).format('D MMMM YYYY');
    },
  },
  computed: {
    text() {
      const count = this.count;

      return count === 1 ? '1 New Message' : `${count} New Messages`;
    },
  },
};
</script>

<style lang="scss">
@import '../../../styles/variables';

$border-radius-sm: .2rem !default;

.message-date-separator {
  display: flex;
  flex-direction: row;
  align-items: center;
  margin: 2rem -1.714rem;
  > hr {
    flex: 1;
  }
}

.message-date-content {
  font-size: .714rem;
  padding: 0.4rem;
  color: $gray-light;

  &.new-messages {
    color: $brand-info;
  }
}
</style>

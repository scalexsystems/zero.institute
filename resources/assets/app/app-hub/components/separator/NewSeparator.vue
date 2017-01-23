<template>
<div class="new-message-separator">
  <hr>
  <div class="new-message-content">{{ text }}</div>
  <hr>
</div>
</template>

<script lang="babel">
export default {
  props: {
    count: {
      type: Number,
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

.new-message-separator {
  display: flex;
  flex-direction: row;
  align-items: center;
  margin: 2rem -1.714rem;
  > hr {
    flex: 1;
  }
}

.new-message-content {
  font-size: .714rem;
  padding: 0.4rem;
  color: $brand-info;
}
</style>

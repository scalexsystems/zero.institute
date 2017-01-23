<template>
<message :message="message" class="continued" @open-sender="$emit('open-sender', message)">
  <div slot="sender-photo" class="message-sender-photo-placeholder"></div>
  <template slot="message-meta"></template>
</message>
</template>

<script lang="babel">
import Message from './Message.vue';

export default {
  name: 'ContinuedMessage',
  props: {
    ...Message.props,
  },
  components: { Message },
};
</script>


<style lang="scss">
@import '../../../styles/variables';
@import '../../../styles/methods';

$border-radius-sm: .2rem !default;

.message-container.continued {
  margin: 0;
}

.message-sender-photo-placeholder {
  width: rem(36px);
  height: 1px;
  margin: 0 1rem + rem(3px) 0 rem(3px);
  flex: 0 0 rem(36px);
}
</style>

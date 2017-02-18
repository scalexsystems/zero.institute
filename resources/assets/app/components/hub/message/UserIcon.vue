<template>
<img class="c-hub-message-user-icon user fit-cover" :src="photo" @click="onSender">
</template>

<script lang="babel">
export default {
  name: 'MessageSenderAvatar',

  props: {
    sender: {
      type: [Object],
      required: true
    }
  },

  computed: {
    photo () {
      return this.sender.photo
    }
  },

  methods: {
    onSender () {
      this.$router.push({ name: 'user.show', params: { id: this.sender.id }})
    }
  }
}
</script>


<style lang="scss">
@import '../../../styles/methods';

.c-hub-message-user-icon {
  width: to-rem(36px);
  height: to-rem(36px);
  margin: 0 1rem + to-rem(3px) 0 to-rem(3px);
  cursor: pointer;

  &.user {
    border-radius: $border-radius-sm;
  }
}
</style>

<template>
<div class="c-user-card card">
  <div class="c-user-card-block">
    <div class="d-flex flex-row align-items-center">
      <img :src="user.photo" class="rounded-circle c-user-card-photo">
      <div>
        <div class="c-user-card-title">{{ user.name }}</div>
        <div class="c-user-card-subtitle">
          <span class="text-primary text-uppercase" v-if="user.is_member">Joined <span class="text-muted">&centerdot;</span></span>
          <span class="text-muted">{{ user.member_count_text }}</span>
        </div>
      </div>
    </div>

    <slot></slot>
  </div>
</div>
</template>

<script lang="babel">
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-user-card {
  &-photo {
    width: to-rem(48px);
    height: to-rem(48px);
    margin-right: to-rem(10px);
  }

  &-title {
    font-size: 1.14285rem;
  }

  &-subtitle {
    font-size: .75rem;
  }

  &-block {
    padding: .64286rem .71429rem;
  }
}
</style>

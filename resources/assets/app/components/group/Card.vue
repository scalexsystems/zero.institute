<template>
<div class="c-group-card card">
  <div class="c-group-card-block">
    <div class="d-flex flex-row align-items-center">
      <img :src="group.photo" class="rounded-circle c-group-card-photo">
      <div>
        <div class="c-group-card-title">{{ group.name }}</div>
        <div class="c-group-card-subtitle">
          <span class="text-primary text-uppercase" v-if="group.is_member">Joined <span class="text-muted">&centerdot;</span></span>
          <span class="text-muted">{{ group.member_count_text }}</span>
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
    group: {
      type: Object,
      required: true
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-group-card {
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

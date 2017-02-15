<template>
<div class="c-shared-card card">
  <a v-if="remove" role="button" class="c-shared-card-remove" @click.prevent="$emit('remove')">&times;</a>
  <div class="c-shared-card-block">
    <slot></slot>
  </div>
</div>
</template>

<script lang="babel">
export default {
  props: {
    remove: {
      type: Boolean,
      default: false
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-shared-card {
  position: relative;
  &-remove {
    position: absolute;
    top: 0;
    right: 0;

    margin: -6px -6px 0 0;
    width: 28px;
    height: 28px;
    text-align: center;
    font-size: 1.25rem;

    border-radius: 100%;

    transition: all .3s;

    color: $card-border-color !important;

    &:hover {
      background: $gray-light;
      color: white !important;
    }
  }

  &-block {
    padding: .64286rem .71429rem;
  }
}
</style>

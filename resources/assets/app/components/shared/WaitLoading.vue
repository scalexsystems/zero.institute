<template lang="html">

<div class="c-shared-wait-loading" :class="{ 'd-flex align-items-center justify-content-center': active }">
  <div class="spinner" v-if="active" :style="{ height: sizePx, width: sizePx }"></div>
  <slot v-else></slot>
</div>

</template>

<script lang="babel">
export default {
  name: 'WaitLoading',

  props: {
    active: {
      type: Boolean,
      default: true,
    },

    size: {
      type: Number,
      default: 48
    }
  },

  computed: {
    sizePx () {
      return `${this.size}px`
    }
  }
}
</script>


<style lang="scss">
@import '../../styles/variables';

$wait-loading-spinner-dot-size: 6px !default;
$wait-loading-spinner-color: $gray-light !default;

.c-shared-wait-loading .spinner {
  position: relative;
  border: 1px solid $wait-loading-spinner-color;
  animation: ease spinner-wait-loading-rotating 1.5s infinite;
  border-radius: 100%;

  &:before {
    content: '';
    position: absolute;
    display: block;
    top: 0;
    left: 50%;
    margin-top: - $wait-loading-spinner-dot-size / 2;
    margin-left: - $wait-loading-spinner-dot-size / 2;
    height: $wait-loading-spinner-dot-size;
    width: $wait-loading-spinner-dot-size;
    background-color: $wait-loading-spinner-color;
    border-radius: 100%;
  }
}

@keyframes spinner-wait-loading-rotating {
  0% {
    transform: rotate(0);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>

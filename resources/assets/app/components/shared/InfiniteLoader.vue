<template>
<div>
  <slot></slot>

  <infinite-scroll class="col-12 text-center" ref="is" v-bind="{ onInfinite, direction, distance, spinner }">
    <div slot="no-results"></div>
    <div slot="no-more"></div>
  </infinite-scroll>
</div>
</template>

<script lang="babel">
import InfiniteScroll from 'vue-infinite-loading'

export default {
  name: 'InfiniteLoader',

  props: {
    distance: {
      type: Number,
      default: 100
    },
    spinner: {
      type: String,
      default: 'waveDots'
    },
    direction: {
      type: String,
      default: 'bottom'
    }
  },

  methods: {
    onInfinite () {
      setTimeout(() => this.$emit('infinite', {
        loaded: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:loaded'),
        complete: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:complete'),
        reset: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:reset')
      }), 0)
    }
  },

  created () {
    this.$on('reset', () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:reset'))
  },

  components: { InfiniteScroll }
}
</script>

<style lang="scss">
.infinite-status-prompt {
  display: none;
}
</style>

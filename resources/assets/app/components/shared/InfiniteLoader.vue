<template>
<div>
  <slot></slot>
  <div class="text-center col-12">
    <infinite-scroll :on-infinite="onInfinite" ref="is" spinner="waveDots">
      <div slot="no-results"></div>
      <div slot="no-more"></div>
    </infinite-scroll>
  </div>
</div>
</template>

<script lang="babel">
import InfiniteScroll from 'vue-infinite-loading'

export default {
  name: 'InfiniteLoader',

  methods: {
    onInfinite () {
      this.$emit('infinite', {
        loaded: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:loaded'),
        complete: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:complete'),
        reset: () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:reset')
      })
    }
  },

  created () {
    this.$on('reset', () => this.$refs && this.$refs.is.$emit('$InfiniteLoading:reset'))
  },

  components: { InfiniteScroll }
}
</script>

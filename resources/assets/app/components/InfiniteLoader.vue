<template>
<infinite-scroll class="col-xs-12" :on-infinite="onInfinite" spinner="waveDots" ref="infinite"></infinite-scroll>
</template>

<script lang="babel">
import InfiniteScroll from 'vue-infinite-loading';

export default {
  components: { InfiniteScroll },
  events: {
    '$InfiniteLoading:reset': function reset() {
      this.emit('$InfiniteLoading:reset');
    },
    '$InfiniteLoading:complete': function complete() {
      this.emit('$InfiniteLoading:loaded');
    },
    '$InfiniteLoading:loaded': function loaded() {
      this.emit('$InfiniteLoading:loaded');
    },
  },
  methods: {
    onInfinite() {
      const reset = () => this.emit('$InfiniteLoading:reset');
      const end = () => this.emit('$InfiniteLoading:complete');
      const done = () => this.emit('$InfiniteLoading:loaded');

      this.$emit('load', { reset, end, done });
    },
    emit(e) {
      if (this.$refs && this.$refs.infinite) {
        this.$refs.infinite.$emit(e);
      }
    },
  },
};
</script>

<template>
<div></div>
</template>

<script lang="babel">
import InfiniteScroll from 'vue-infinite-loading'

export default {
  name: 'InfiniteLoader',

  methods: {
    onInfinite () {
      this.$emit({
        loaded () {},
        complete () {}
      })
    }
  },

  created () {
    this.$on('reset', () => this.$refs.is.$emit(''))
  },

  component: { InfiniteScroll }
};
</script>
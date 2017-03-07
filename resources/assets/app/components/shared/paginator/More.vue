<template lang="html">
<div class="c-shared-paginator-more">
  <div class="text-center" v-if="top">
    <wait-loading :active="waiting" :size="24">
      <input-button variant="secondary" class="btn-sm" value="load more" @click.native="onPrev"/>
    </wait-loading>
  </div>

  <slot></slot>

  <div class="text-center" v-if="bottom">
    <wait-loading :active="waiting" :size="24">
      <input-button variant="secondary" class="btn-sm" value="load more" @click.native="onNext"/>
    </wait-loading>
  </div>
</div>
</template>

<script lang="babel">
import paginator from './paginator'

export default {
  name: 'MorePaginator',

  mixins: [paginator],
}
</script>

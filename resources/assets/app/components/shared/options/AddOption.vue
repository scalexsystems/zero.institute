<template lang="html">
<div class="c-shared-options-add-option">
  <icon type="plus-circle" class="text-muted" v-if="item.id === -1"/>
  {{ item.name }}
</div>
</template>

<script lang="babel">
export default {
  name: 'AddOption',

  props: {
    item: {
      type: Object,
      required: true,
    }
  }
}
</script>


<style lang="scss">
.c-shared-options-add-option {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
</style>

<template>
<div class="c-shared-options-user-option d-flex flex-row align-items-center" :class="{ active, selected }">
  <img :src="item.photo" class="rounded-circle">

  <div>{{ item.name }}</div>
</div>
</template>

<script lang="babel">
export default {
  props: {
    item: {
      type: Object
    },
    active: {
      type: Boolean
    },
    selected: {
      type: Boolean
    }
  }
}
</script>

<style lang="scss">
@import '../../../styles/variables';

.c-shared-options-user-option {
  cursor: pointer;

  .active {
    background: lighten($brand-info, 75%);
  }

  .selected {
    background: lighten($brand-success, 75%);
  }

  > img {
    width: 2rem;
    height: 2rem;
    margin: .5rem 1rem .5rem 0;
  }
}
</style>
<template>
<div class="c-shared-options-user-option d-flex flex-row align-items-center" :class="{ active, selected }">
  <img :src="item.photo" class="rounded-circle fit-cover">

  <div class="d-flex flex-column">
    <span>{{ item.name }}</span>
    <small class="text-muted text-uppercase">{{ item._type }}</small>
  </div>
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

  &.active {
    background: lighten($brand-info, 5%);
  }

  &.selected {
    font-weight: bold;

    &:before {
      content: "\F00C";
      font: normal normal normal 14px/1 FontAwesome;
      display: inline-block;
      margin-left: -17.5px;
      margin-right: 3.5px;
    }
  }

  > img {
    width: 2rem;
    height: 2rem;
    margin: .5rem 1rem .5rem 0;
  }
}
</style>

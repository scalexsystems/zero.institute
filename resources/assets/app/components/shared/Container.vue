<template>
  <div class="d-flex flex-column" :class="[ $style.container ]">
    <div :class="[ $style.header ]">
      <slot name="header">
        <container-header-default
          @action="any => $emit('action', any)"
          @back="any => $emit('back', any)"
          v-bind="{ title, subtitle, back, photo }"
        ><slot name="header-extras">
          <container-header-buttons><slot name="buttons"></slot></container-header-buttons>
        </slot></container-header-default>
      </slot>
    </div>

    <div :class="[ $style.body ]" class="body">
      <slot></slot>
    </div>

    <div v-if="hasFooter" :class="[ $style.footer ]">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script lang="babel">
import scrollbar from '../mixins/scrollbar'
import ContainerHeaderButtons from './container/HeaderButtons.vue'
import ContainerHeaderDefault from './container/HeaderDefault.vue'

export default {
  name: 'Container',

  props: {
    // Props for Default Header.
    title: String,
    subtitle: String,
    back: Boolean,
    photo: String,

    // Footer
    hasFooter: Boolean,

    // Scrollable
    scroll: {
      type: Boolean,
      default: true
    },
    scrollSelector: {
      type: String,
      default: '.body'
    }
  },

  components: { ContainerHeaderButtons, ContainerHeaderDefault },
  mixins: [scrollbar]
}
</script>

<style lang="scss" module>
@import '../../styles/variables';
@import '../../styles/mixins';

$layout-box-bg: white !default;
$zindex-layout-box: 100 !default;

.container {
  background: white;
  border: 1px solid $border-color;

  @include match-parent();
}

.header {
  border-bottom: 2px solid $border-color;
  z-index: $zindex-layout-box;
}

.body {
  position: relative;
  flex: 1;
  overflow-x: hidden;
  overflow-y: auto;
}

.footer {
  border-top: 1px solid $border-color;
}
</style>

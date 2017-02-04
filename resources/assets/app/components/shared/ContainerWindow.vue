<template>
<div class="container c-shared-container-window">
  <div class="row window">
    <div class="col-12 col-lg-2">
      <sidebar></sidebar>
    </div>

    <div class="col-12 col-lg-10">
      <container v-bind="{ title, subtitle, back, photo, hasFooter }"
                 @action="any => $emit('action', any)"
                 @back="any => $emit('back', any)">
        <template slot="buttons"><slot name="buttons"></slot></template>
        <slot></slot>
        <template slot="footer"><slot name="footer"></slot></template>
      </container>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import Vue from 'vue'
import Sidebar from '../sidebar/Sidebar.vue'

export default {
  name: 'ContainerWindow',

  props: {
    title: String,
    subtitle: String,
    back: Boolean,
    photo: String,

    // Footer
    hasFooter: Boolean
  },

  components: { Sidebar }
}
</script>

<style lang="scss">
@import '../../styles/variables';
@import '../../styles/mixins';

.c-shared-container-window {
  .window {
    @include match-parent();
  }
}
</style>

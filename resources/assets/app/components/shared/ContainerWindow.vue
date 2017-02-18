<template>
<div class="container c-shared-container-window">
  <div class="row window">
    <sidebar class="col-12 col-lg-2">
      <slot name="sidebar">
        <course-list class="my-3"/>
        <user-group-list class="mt-3" />
      </slot>
    </sidebar>

    <div class="col-12 col-lg-10">
      <container v-bind="{ title, subtitle, back, photo, hasFooter, scroll, scrollSelector }"
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
import UserGroupList from '../sidebar/UserGroupList.vue'
import CourseList from '../sidebar/CourseList.vue'

export default {
  name: 'ContainerWindow',

  props: {
    title: String,
    subtitle: String,
    back: Boolean,
    photo: String,

    // Scrollable
    scroll: {
      type: Boolean,
      default: true
    },
    scrollSelector: {
      type: String,
      default: '.body'
    },

    // Footer
    hasFooter: Boolean
  },

  components: { UserGroupList, CourseList, Sidebar }
}
</script>

<style lang="scss">
@import '../../styles/variables';
@import '../../styles/mixins';

.c-shared-container-window {
  padding: 0 !important;
  .window {
    @include match-parent();
  }
}
</style>

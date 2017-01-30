<template>
  <router-link tag="div" :to="route" class="c-sidebar-button card d-flex flex-row" role="button">
    <img v-if="photo" class="mr-2" :class="[$style.photo, type]" :src="photo">
    <div :class="[$style.main]" class="d-flex align-items-center flex-auto">
      <slot></slot>
    </div>
    <div v-if="hasExtra" :class="[$style.extra]" class="d-flex align-items-center">
      <slot name="extra"></slot>
    </div>
  </router-link>
</template>

<script>
export default {
  name: 'SidebarButton',

  props: {
    photo: String,
    type: String,
    hasExtra: Boolean,
    route: {
      type: [Object, String],
      required: true
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-sidebar-button {
  padding: to-rem(6px);
  overflow: hidden;
}
</style>

<style lang="scss" module>
@import '../../styles/methods';

.photo {
  width: to-rem(28px);
  height: to-rem(28px);
  object-fit: cover;
  overflow: hidden;
}

.main {
  height: to-rem(28px);

  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
</style>

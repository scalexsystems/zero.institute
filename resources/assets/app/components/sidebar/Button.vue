<template>
  <router-link :to="route" class="c-sidebar-button card d-flex flex-row" role="button">
    <img v-if="photo" class="mr-2 photo" :class="[type]" :src="photo">
    <div class="d-flex align-items-center flex-auto main">
      <slot></slot>
    </div>
    <div v-if="hasExtra" class="d-flex align-items-center extra">
      <slot name="extra">
        <span class="badge badge-default">{{ extra }}</span>
      </slot>
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
    extra: [Number, String],
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
  color: inherit;

  &:active, &:hover, &:focus {
    color: inherit;
    text-decoration: none;
  }

  .notification {
    color: $brand-primary;
  }

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
}
</style>

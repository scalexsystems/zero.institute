<template>
  <router-link :to="route" class="c-sidebar-button card d-flex flex-row" role="button">
    <img v-if="photo" class="mr-2 photo fit-cover" :class="[type]" :src="photo">
    <div class="flex-auto main" v-bind="{ title }">
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
    },
    title: String,
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-sidebar-button {
  padding: to-rem(6px);
  overflow: hidden;
  color: inherit;

  &.router-link-active {
    background: white !important;
    border: 1px solid $card-border-color !important;
  }

  &:active, &:hover, &:focus {
    color: inherit !important;
    text-decoration: none;

    background: white !important;
  }

  .notification {
    color: $brand-primary;
  }

  .photo {
    width: to-rem(28px);
    height: to-rem(28px);
    overflow: hidden;
  }

  .main {
    height: to-rem(28px);
    line-height: to-rem(28px);

    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }
}
</style>

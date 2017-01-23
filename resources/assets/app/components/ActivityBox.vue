<template>
  <layout-box v-bind="{ disableFooter }">
    <template slot="context">
      <slot name="icon">
        <a class="activity-box-dismiss" role="button" @click.prevent.stop="$emit('close')">
          <img src="../assets/back.svg">
        </a>
      </slot>
      <div class="activity-box-title-container">
        <div class="activity-box-title" @click="$emit('openTitle')">
          <slot name="title">{{ title }}</slot>
        </div>
        <div class="activity-box-subtitle" @click="$emit('openSubtitle')">
          <slot name="subtitle">{{ subtitle }}</slot>
        </div>
      </div>
    </template>

    <template slot="actions"><slot name="actions"></slot></template>
    <template slot="footer"><slot name="footer"></slot></template>

    <slot></slot>
  </layout-box>
</template>

<script lang="babel">
import LayoutBox from './LayoutBox.vue';

export default {
  props: {
    title: String,
    subtitle: String,
    ...LayoutBox.props,
  },
  components: { LayoutBox },
};
</script>

<style lang="scss">
@import '../styles/methods';

$border-radius-sm: 0.2rem !default;
$activity-box-subtitle-color: #9b9b9b !default;

.activity-box-dismiss {
  width: rem(42px);
  height: rem(42px);
  &:hover, &:focus {
    text-decoration: none;
  }

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: $border-radius-sm;

  &:hover, &:focus {
    background: darken(#fff, 5%);
  }
}

.activity-box-title-container {
  margin: -1px 1rem; // Top and bottom margin -1px to make height 70px.
  overflow-x: hidden;
}

.activity-box-title {
  font-size: 1.28571rem;
  overflow-x: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.activity-box-subtitle {
  overflow-x: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  color: $activity-box-subtitle-color;
  font-size: 0.85714rem;
  min-height: rem(17px);
}
</style>

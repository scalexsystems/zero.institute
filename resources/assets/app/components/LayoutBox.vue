<template>
<div class="layout-box">
  <div class="layout-box-header">
    <slot name="header">
      <slot name="context"></slot>
      <div class="layout-box-actions-container">
        <slot name="actions">

        </slot>
      </div>
    </slot>
  </div>
  <div class="layout-box-body">
    <slot></slot>
  </div>
  <div v-if="!isFooterDisabled" class="layout-box-footer">
    <slot name="footer"></slot>
  </div>
</div>
</template>

<script lang="babel">
import { bool } from '../util';

export default {
  props: {
    disableFooter: {
      default: false,
    },
  },
  computed: {
    isFooterDisabled() {
      const disableFooter = this.disableFooter;

      return bool(disableFooter);
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/methods';
@import '../styles/mixins';

$layout-box-bg: white !default;
$layout-box-actions-color: #9b9b9b !default;

.layout-box {
  display: flex;
  flex-direction: column;
  background: white;
  z-index: 100;

  @include match-parent();

  border: 1px solid $border-color;
}

.layout-box-header {
  display: flex;
  flex-direction: row;
  padding: .714rem 1rem;
  @include media-breakpoint-up(lg) {
    padding: .714rem 1.714rem;
  }
  border-bottom: 1px solid $border-color;
  z-index: 100;
  box-shadow: 0 2px rgba(0, 0, 0, 0.1);
}

.layout-box-body {
  flex: 1;
  overflow-x: hidden;
  overflow-y: auto;
}

.layout-box-footer {
  border-top: 1px solid $border-color;
}

.layout-box-actions-container {
  flex: 1;
  display: flex;
  flex-direction: row;
  justify-content: flex-end;
  align-self: center;
  color: $layout-box-actions-color;

  .action-menu-action {
    color: inherit;
  }
}
</style>

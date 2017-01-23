<template>
    <div class="window">
      <div class="window-header">
        <div class="container">
          <div class="window-context">
            <h2 class="window-title">
              {{ title }}
            </h2>

            <div class="window-subtitle text-muted">{{ subtitle }}</div>
          </div>
          <slot name="header">
            <div>
              <a role="button" @click.prevent="$router.go(-1)" class="btn btn-secondary">
                <i class="fa fa-fw fa-arrow-left"></i> Back
              </a>
            </div>
          </slot>
        </div>
      </div>

      <div class="window-body">
        <slot></slot>
      </div>
    </div>
</template>

<script lang="babel">
export default {
  props: {
    title: {
      type: String,
    },
    subtitle: {
      type: String,
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/variables';
@import '../styles/mixins';

.window {
  &-header {
    > .container {
        display: flex;
        flex-direction: row;
    }

    background: #fff;
    padding: 1rem;
    border-top: 1px solid #e7e7e7;
    border-bottom: 1px solid #e7e7e7;
    transition: border 200ms;
  }
  &-context {
    flex: 1;
  }
  &-title {
    font-size: 1.2rem;
    margin-bottom: 0.1rem;

    // Small only!
    padding: .47rem 0;
    @include media-breakpoint-up(md) {
        padding: 0;
    }
  }
  &-subtitle {
    font-size: 0.7rem;
  }
}
</style>

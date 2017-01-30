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

    <div :class="[ $style.body ]">
      <slot></slot>
    </div>

    <div v-if="hasFooter" :class="[ $style.footer ]">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
import scrollbar from 'perfect-scrollbar'
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
      default: true,
    },
    scrollSelector: {
      type: String,
      default: '.body'
    }
  },

  data () {
    return {
      bars: false
    }
  },

  methods: {
    /**
     * Add scrollbars if requried.
     */
    addBars () {
      if (!this.scroll || this.bars) return

      const el = this.$el.querySelector(this.scrollSelector)

      if (el) {
        scrollbar.initialize(el, { suppressScrollX: true })
        this.bars = true
      } else {
        setTimeout(() => this.addBars(), 200)
      }
    },
    /**
     * Remove scrollbars if exists.
     *
     * @return void
     */
    removeBars () {
      if (! this.scroll) return

      const el = this.$el.querySelector(this.scrollSelector)

      if (el) {
        scrollbar.destroy(el)
        this.bars = false
      }
    }
  },

  mounted () {
    this.addBars()
  },

  beforeDestroy () {
    this.removeBars()
  },

  components: { ContainerHeaderButtons, ContainerHeaderDefault }
}
</script>

<style lang="scss" module>
@import '../../styles/variables';
@import '../../styles/mixins';

$layout-box-bg: white !default;
$zindex-layout-box: 100 !default;

.container {
  border: 1px solid $border-color;

  @include match-parent();
}

.header {
  border-bottom: 1px solid $border-color;
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

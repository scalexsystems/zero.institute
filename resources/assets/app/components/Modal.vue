<template>
<div class="custom-modal" v-if="showing">
  <div class="backdrop"></div>

  <div class="wrapper" :class="[wrapper]" ref="wrapper" @click.stop="onWrapper">
    <slot></slot>
  </div>

  <a v-if="dismissable" role="button" class="dissmiss" @click.prevent="$emit('hide')">&times;</a>
</div>
</template>

<script>
export default {
  props: {
    name: String,
    show: {
      default: undefined,
      type: Boolean,
    },
    dissmissOnBackdrop: {
      default: true,
      type: Boolean,
    },
    wrapper: {
      type: String,
      default: 'wrapper-default',
    },
    dismissable: {
      type: Boolean,
      default: true,
    },
  },
  computed: {
    showing() {
      const show = this.show;
      const state = this.state;

      if (show === undefined) {
        return state;
      }

      return show;
    },
  },
  data() {
    return {
      state: false,
    };
  },
  created() {
    this.$on('show', () => {
      this.state = true;
    });
    this.$on('hide', () => {
      this.state = false;
    });
  },
  methods: {
    onWrapper(event) {
      if (!this.dismissable) return;

      if (this.dissmissOnBackdrop && this.$refs.wrapper === event.target) {
        this.$emit('hide');
      }
    },
  },
  watch: {
    showing(state) {
      if (state) {
        document.body.classList.add('modal-open');
      } else {
        document.body.classList.remove('modal-open');
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/variables';
.custom-modal {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: $zindex-modal;

  .dissmiss {
    color: white !important;
    &:hover {
      color: $gray-dark !important;
      background: $gray-lighter;
    }
  }

  .backdrop {
      background-color: rgba(0, 0, 0, .85);
  }

  &.inverse {
    .dissmiss {
      color: $gray-dark !important;
      &:hover {
        color: white !important;
        background: $gray-dark;
      }
    }

    .backdrop {
        background-color: white;
    }
  }
}

.backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: -1;
}

.wrapper {
  position: relative;
  height: 100%;
  overflow: auto;
  z-index: 1;
}

.dissmiss {
  margin: 1rem;
  width: 28px;
  height: 28px;
  text-align: center;
  font-size: 1.25rem;

  border-radius: 100%;

  position: fixed;
  top: 0;
  right: 0;
  z-index: $zindex-modal + 10;
  transition: all .3s;
}

.wrapper-default {
  display: flex;
  flex-direction: column;
  padding: 1rem;


  &:before, &:after {
    content: '';
    display: block;
    flex: 1;
  }

  > * {
    margin-left: auto;
    margin-right: auto;
    width: 100%;
    max-width: 600px;
  }
}
</style>

<template>
<div class="action-menu" v-if="!isEmpty">
  <div v-if="isSpaceAvailable" class="action-menu-actions">
    <template v-for="(action, index) of collapsedActions">
    <slot :name="'action-menu-'+index">
      <a href="#" class="action-menu-action" @click.prevent="click($event, action.action, index)" :class="[action.action.class]">
        <i class="fa fa-fw" :class="[`fa-${action.action.icon}`]"></i>
        <span v-if="action.action.showFull">{{ action.action.name }}</span>
      </a>
    </slot>
    </template>
  </div>
  <div class="dropdown" ref="dropdown" v-if="otherActions.length">
    <button class="action-menu-toggler"
            data-toggle="dropdown"
            type="button" :id="id"
            aria-haspopup="true"
            aria-expanded="false"><i class="fa fa-fw fa-ellipsis-v"></i></button>
    <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="id">
      <template v-for="(action, index) of otherActions">
      <slot :name="'action-menu-'+index">
        <a href="#" class="dropdown-item" @click.prevent="click($event, action.action, index)">
          <i class="fa fa-fw" :class="[`fa-${action.action.icon}`]"></i> {{ action.action.name }}
        </a>
      </slot>
      </template>
    </div>
  </div>
</div>
</template>

<script lang="babel">
/* eslint-disable no-underscore-dangle */
import $ from 'jquery';
import debounce from 'lodash/debounce';
import each from 'lodash/each';

export default {
  props: {
    actions: {
      type: Array,
      default: () => [],
    },
  },
  computed: {
    id() {
      return `message-box-${this._uid}`;
    },
    isEmpty() {
      const actions = this.actions;

      return actions.length === 0;
    },
    isSpaceAvailable() {
      const canFit = this.canFit;

      return canFit > 0;
    },
    maxIndex() {
      const actions = this.actions;

      let index;
      each(actions, (action, id) => {
        if (index === undefined && action.collapseIfRoom === false) {
          index = id;
        }
      });

      return index === undefined ? actions.length : index;
    },
    otherActions() {
      const actions = this.actions;
      const canFit = Math.min(this.canFit, this.maxIndex);

      if (canFit >= actions.length) {
        return [];
      }

      return actions.slice(canFit)
              .map((action, index) => ({ action, index }));
    },
    collapsedActions() {
      const actions = this.actions;
      const canFit = Math.min(this.canFit, this.maxIndex);

      if (canFit < 1) {
        return [];
      }

      return actions.slice(0, canFit)
              .map((action, index) => ({ action, index }));
    },
  },
  data() {
    return {
      canFit: 0,
    };
  },
  methods: {
    checkWidth() {
      const selector = $(this.$refs.dropdown);
      const container = $(this.$el).parent();

      const num = (container.width() - selector.outerWidth()) / selector.outerWidth();

      this.canFit = parseInt(num, 10);
    },
    click(event, action, index) {
      this.$emit('option-click', event, action, index);
    },
  },
  mounted() {
    $(window).on('resize.action-menu', debounce(() => {
      this.checkWidth();
    }, 500));
    this.$nextTick(() => {
      this.checkWidth();
    });
  },
  beforeDestroy() {
    $(window).off('resize.action-menu');
  },
};
</script>

<style lang="scss">
@import '../styles/variables';

$border-radius-sm: 0.2rem !default;

.action-menu {
  display: flex;
  flex-direction: row;
}

.action-menu-toggler {
  background: transparent;
  border: none;
  font-size: 1.142857rem;
  padding: 0.125rem .25rem;
  cursor: pointer;

  border-radius: $border-radius-sm;
  &:hover, &:focus {
    background: darken(#fff, 5%);
    outline: none;
  }
}

.action-menu-actions {
  display: flex;
  flex-direction: row;
  align-self: center;
}

.action-menu-action {
  font-size: 1.142857rem;
  padding: 0.125rem .25rem;

  border-radius: $border-radius-sm;
  &:hover, &:focus {
    background: darken(#fff, 5%);
  }
}
</style>

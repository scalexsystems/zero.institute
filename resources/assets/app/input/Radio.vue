<template>
<div class="form-group" :class="[feedbackState]">
  <label class="form-control-label" :for="id" v-if="is(title)">{{ title }}
      <span class="text-danger" v-if="required"> * </span>
  </label>

  <div class="input-group" :id="id" :described-by="helpId" role="form">
    <div :class="{'c-inputs-stacked': stacked}">
      <label class="c-input input-radio" v-for="(option, key) of options" :key="key">
        <input :name="identifier" :type="type" :value="key" @click.prevent.stop="onInput($event, key)">
        <div class="c-indicator" :class="{checked: localValue.indexOf(key) > -1}">{{ option }}</div>
      </label>
    </div>
  </div>

  <div class="form-control-feedback" v-if="is(feedback)">{{ feedback }}</div>
  <small :id="helpId" class="form-text text-muted" v-if="is(subtitle)">{{ subtitle }}</small>
</div>
</template>

<script lang="babel">
import isArray from 'lodash/isArray';
import isString from 'lodash/isString';

import input from './mixins/input';

export default {
  props: {
    type: {
      default: 'radio',
      validator(value) {
        return ['radio', 'checkbox'].indexOf(value) > -1;
      },
    },
    stacked: Boolean,
    options: {
      type: Object,
      required: true,
    },
  },
  mixins: [input],
  computed: {
    helpId() {
      return `${this.id}-help-text`;
    },
    localValue() {
      const value = this.value;

      if (isArray(value)) {
        return value;
      }

      if (isString(value) && value.length > 0) {
        return [value];
      }

      return [];
    },
  },
  methods: {
    onInput(event, option) {
      if (this.type === 'radio') {
        return this.$emit('input', option);
      }

      const value = this.value;
      if (!isArray(value)) {
        return this.$emit('input', [option]);
      }

      const index = value.indexOf(option);
      if (index > -1) {
        value.splice(index, 1);
      } else {
        value.push(option);
      }

      return this.$emit('input', value);
    },
  },
};
</script>

<style lang="scss">
@import '../styles/variables';

.input-radio {
  margin-right: 1rem;
  cursor: pointer;
  & > input[type=radio], & > input[type=checkbox] {
    position: absolute;
    clip: rect(0, 0, 0, 0);
    pointer-events: none;
  }
  .c-indicator {
    border: 1px solid $input-border-color;
    border-radius: 1000px;
    padding: $input-padding-y $input-padding-x + 1rem;
    &.checked {
      border-color: $btn-primary-border;
      color: $btn-primary-bg;
    }
  }
}

.radio-button > .btn {
  & > input[type=radio], & > input[type=checkbox] {
    position: absolute;
    clip: rect(0, 0, 0, 0);
    pointer-events: none;
  }
}
</style>

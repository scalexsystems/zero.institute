<template>
<div class="form-group" :class="[feedbackState]">
  <label class="form-control-label" :for="id" v-if="is(title)">{{ title }}
      <span class="text-danger" v-if="required"> * </span>
  </label>

  <select :type="type" :id="id" class="form-control custom-select" :class="[formControlState]"
         :described-by="helpId" :name="identifier" :value="value"
         @input="$emit('input', $event.target.value)">
         <option :selected="!value" disabled>{{ title }}</option>
         <option v-for="option in options" :value="option[optionKey]" :selected="option[optionKey] === value">{{ option[optionDisplayKey] }}</option>
   </select>

  <div class="form-control-feedback" v-if="is(feedback)">{{ feedback }}</div>
  <small :id="helpId" class="form-text text-muted" v-if="is(subtitle)">{{ subtitle }}</small>
</div>
</template>

<script lang="babel">
import input from './mixins/input';

export default {
  props: {
    type: {
      type: String,
      default: 'text',
    },
    options: {
      type: Array,
      required: true,
    },
    optionKey: {
      type: String,
      default: 'id',
    },
    optionDisplayKey: {
      type: String,
      default: 'name',
    },
  },
  mixins: [input],
  computed: {
    helpId() {
      return `${this.id}-help-text`;
    },
  },
};
</script>


<style lang="scss">

</style>

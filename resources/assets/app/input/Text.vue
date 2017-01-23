<template>
<div class="form-group" :class="[feedbackState]">
  <label class="form-control-label" :for="id" v-if="is(title)">{{ title }}
       <span class="text-danger" v-if="required"> * </span>
  </label>

  <input :type="type" :id="id" class="form-control" :class="[formControlState]"
         :described-by="helpId" :name="identifier" :value="value" :placeholder="placeholder"
         @input="$emit('input', $event.target.value)">

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
    placeholder: {
      type: String,
      default: '',
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

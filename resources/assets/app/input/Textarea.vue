<template>
<div class="form-group"  :class="[feedbackState]">
  <label class="form-control-label" :for="id" v-if="is(title)">{{ title }}
      <span class="text-danger" v-if="required"> * </span>
  </label>

  <textarea :type="type" :id="id" class="form-control" :class="[type, formControlState]" rows="5"
         :described-by="helpId" :name="identifier" :value="value"
         @input="$emit('input', $event.target.value)"></textarea>

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
      default: 'noresize',
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
textarea.noresize {
  resize: none;
}
</style>

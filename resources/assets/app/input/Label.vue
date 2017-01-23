<template>
<div class="form-group">
  <slot name="title">
    <label :for="id" v-if="typeof title === 'string'">{{ title }}</label>
  </slot>
  <slot ref="input"></slot>
  <slot name="subtitle">
    <p :id="id" class="form-text text-muted"
       v-if="typeof subtitle === 'string'">{{ subtitle }}</p>
  </slot>
</div>
</template>

<script lang="babel">
import id from './mixins/input';

export default {
  props: ['title', 'subtitle'],
  mixins: [id],
};
</script>


<style lang="scss">

</style>

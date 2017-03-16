<template lang="html">
<form @submit.prevent="onFormSubmit">
  <input type="submit" hidden>

  <alert :class="alertClass" type="danger" v-if="form && form.status" v-html="form.status"/>

  <slot></slot>
</form>
</template>

<script lang="babel">
export default {
  name: 'FormComponent',

  inject: ['onFormSubmit', 'form'],

  props: {
    alertClass: {
      type: String,
      default: 'mb-3'
    }
  }

}
</script>

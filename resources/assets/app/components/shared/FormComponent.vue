<template lang="html">
<form @submit.prevent="submit">
  <input type="submit" hidden>

  <alert :class="alertClass" type="danger" v-if="status" v-html="status"/>

  <slot></slot>
</form>
</template>

<script lang="babel">
export default {
  name: 'FormComponent',

  inject: ['formState'],

  props: {
    alertClass: {
      type: String,
      default: 'mb-3'
    }
  },

  computed: {
    status () {
      return this.formState.formStatus
    }
  },

  methods: {
    submit () {
      return this.formState.onFormSubmit()
    }
  }

}
</script>

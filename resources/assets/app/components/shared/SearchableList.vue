<template>
<div class="container c-shared-searchable-list">
  <div class="row">
    <div class="col-12 col-lg-8 offset-lg-2 mt-3">
      <slot name="header"></slot>
      <search class="form-control-lg" @input="onInput" v-bind="{ value, placeholder }"></search>
    </div>

    <div class="col-12 col-lg-8 offset-lg-2">
      <slot></slot>

      <infinite-loader @infinite="any => $emit('infinite', any)"></infinite-loader>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import throttle from 'lodash.throttle'

export default {
  name: 'SearchableList',

  props: {
    placeholder: String,
    value: {
      type: String,
      required: true
    }
  },

  methods: {
    onSearch: throttle(function onSearch (value) {
      this.$emit('search', value)
    }, 400),

    onInput (value) {
      this.$emit('input', value)
      this.onSearch(value)
    }
  }
}
</script>

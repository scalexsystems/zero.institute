<template>
<div class="c-navbar-search mx-2 align-self-center">
  <typeahead :suggestions="suggestions" v-model="query" placeholder="Search everywhere..."></typeahead>
</div>
</template>

<script lang="babel">
export default {
  data () {
    return { query: [] }
  },

  computed: {
    suggestions: () => []
  }
}
</script>


<style lang="scss">
@import '../../styles/variables';

.c-navbar-search {
  max-width: 500px;
  .form-control {
    background: darken($brand-accent, 10%);
    border-color: lighten($brand-accent, 0.5%);
    color: white;

    * {
      color: white;
    }
  }
}
</style>

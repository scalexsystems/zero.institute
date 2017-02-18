<template>
<abstract-card v-bind="{ remove, footer }">

  <h6 class="card-title">{{ semester.name }} </h6>

</abstract-card>
</template>

<script lang="babel">
export default {
  props: {
    semester: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    },

    footer: {
      type: Boolean,
      default: false
    }
  }
}
</script>
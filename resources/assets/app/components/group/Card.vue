<template>
<div class="card card-block">
  <h4 class="card-title">{{ group.name }}</h4>
</div>
</template>

<script lang="babel">
export default {
  props: {
    group: {
      type: Object,
      required: true
    }
  }
}
</script>

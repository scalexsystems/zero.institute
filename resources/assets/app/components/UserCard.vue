<template>
<person-card v-bind="{ item }">

</person-card>
</template>

<script lang="babel">
import PersonCard from './PersonCard.vue';

export default {
  props: PersonCard.props,
  components: { PersonCard },
};
</script>


<style lang="scss">

</style>

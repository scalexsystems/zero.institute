<template>
   <div>
    <label class="toggle">
        <input class="toggle-input" @change="$emit('toggle', currentValue)" type="checkbox" v-model="currentValue">
        <span class="toggle-core"></span>
        <div class="toggle-label">
            <slot></slot>
        </div>
    </label>
   </div>
</template>

<script>

export default {
  name: 'Toggle',
  props: {
    value: Boolean
  },
  computed: {
    currentValue() {
      return this.value;
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../../styles/variables';

</style>
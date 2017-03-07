<template>
   <div>
    <label class="toggle">
        <input class="toggle-input" @change="$emit('toggle', currentValue)" type="checkbox" v-model="currentValue">
        <span class="toggle-core"></span>
        <div class="toggle-label">
            <slot></slot><
            /div>
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
    currentValue {
      get() {
        return this.value;
      },
      set(val) {
        this.$emit('input', val);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../../styles/variables';

</style>
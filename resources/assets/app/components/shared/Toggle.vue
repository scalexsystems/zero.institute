<template>
   <div>
    <label class="toggle">
        <input class="toggle-input" @change="$emit('change', currentValue)" type="checkbox" v-model="currentValue">
        <span class="toggle-core"></span>
        <div class="toggle-label"><slot></slot></div>
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
    currentValue: {
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

    .toggle {
    display: flex;
    align-items: center;
    position: relative;
    * {
        pointer-events: none;
    }
    &-label {
        margin-left: 10px;
        display: inline-block;
    &:empty {
         margin-left: 0;
     }
    }
    &-core {
        display: inline-block;
        position: relative;
        size: 52px 32px;
        border: 1px solid #b3b3b3;
        border-radius: 16px;
        box-sizing: border-box;
        background: #b3b3b3;
    &::after, &::before {
                   content: " ";
                   position: absolute;
                   transition:transform .3s;
                   border-radius: 15px;
               }
    &::after {
         size: 30px;
         background-color: white;
         box-shadow: 0 1px 3px rgba(0, 0, 0, .4);
     }
    &::before {
         size: 50px 30px;
         background-color: #fdfdfd;
     }
    }
    &-input {
        display: none;
    &:checked {
    + .toggle-core {
          border-color: $brand-primary;
          background-color: $brand-primary;
      &::before {
         transform: scale(0);
      }
      &::after {
         transform: translateX(20px);
     }
    }
   }
  }
}
</style>
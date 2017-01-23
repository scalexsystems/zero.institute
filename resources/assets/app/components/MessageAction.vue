<template>
  <div class='message-action-wrapper'>
    <slot name='messageActions'>
        <template v-for="(action, index) of actions">
          <a href="#" class="message-box-action" data-toggle="tooltip" data-placement="left"
             @click.prevent="click($event, action, index)" >
             <img :src="action.asset" v-tooltip:left="action.name">
            <!--<i class="fa fa-fw" :class="[`fa-${action.icon}`]"></i>-->
          </a>
        </template>
    </slot>
  </div>
</template>

<script lang="babel">
export default{
  data() {
    return {
    };
  },
  props: {
    actions: {
      type: Array,
    },
  },
  methods: {
    click(event, action, index) {
      this.$emit('message-option-click', event, action, index);
    },
  },
};
</script>

<style>
.message-action-wrapper {
  display: flex;
  align-items: center;
}


</style>

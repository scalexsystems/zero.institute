<template>
 <div><!--Wrapper as whole code base is pushing classes to this component. -->
    <div class="card settings-card" role="button" @click='$emit("cardClicked", index, context)'>
        <div class="card-block">
            <div class="settings-card-title">
                <slot name="title">
                    <span class="card-title"> {{ title }} </span>
                </slot>
            </div>
            <div class="settings-card-text" v-if="text">
                <slot name="text">
                    <small class="card-text text-muted">{{ text }} </small>
                </slot>
            </div>
        </div>

        <div class="settings-card-additional-text" v-if="additional">
            <slot name="additional-text" />
        </div>
    </div>
  </div>
</template>
<script lang="babel">
export default{
  data() {
    return {
    };
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    text: {
      type: String,
    },
    index: {
      default: 0,
    },
    additional: {
      default: false,
    },
    context: {
      type: String,
      default: '',
    },
  },
  methods: {
    settingClicked() {
    },
  },
  components: {},
};
</script>
<style lang="scss" scoped>
@import '../styles/methods';
@import "../styles/variables";

.settings-card {
  // min-height: rem(70px);
  // height: 100%;
  margin: rem(10px) 0;


  &-title {

  }

    &-text {
      text-align: left;
  }

    &-additional-text {
      border-top: 1px solid $gray-lightest;
      padding: rem(10px) rem(15px);
    }


}


</style>

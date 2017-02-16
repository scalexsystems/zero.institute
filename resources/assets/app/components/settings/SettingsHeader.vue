<template>
    <div class="settings-header">
        <div class="text-xs-center">
            <img :src="image">
        </div>
        <div class="settings-header-name">
            {{ title }}
        </div>
        <div class="settings-header-description">
            <slot name="description">
                {{ description }}
            </slot>
        </div>
        <div class="container py-2">
            <div class="row">
                <div class="col-xs-12 col-lg-8 offset-lg-2">
                    <div class="row my-2">
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script lang="babel">

export default{
  data () {
    return {}
  },

  props: {
    title: {
      type: String,
      required: true
    },
    description: {
      type: String,
      default: '  '
    },
    image: {
        type: String,
    },
    withHeader: {
      type: Boolean,
      default: true
    }
  },
  components: { ActivityBox }
}
</script>
<style lang="scss" scoped>
@import '../../styles/methods';

.settings-header-name {
  font-size: 1.5rem;
}

.settings-header-image {
  padding: rem(20px);
}

.settings-header-description {
  font-size: 1em;
  color: $gray;
}

</style>

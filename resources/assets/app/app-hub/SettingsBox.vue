<template>
    <activity-box class="settings-box"
                  v-bind="{ title, subtitle, show: true, disableFooter: true }">

        <template slot="icon">
            <slot name="icon">
              <a class="activity-box-dismiss" role="button" @click.prevent.stop="$router.go(-1)">
                  <img src="../assets/settings/back.svg">
              </a>
            </slot>
        </template>

        <template slot="actions">
            <slot name="actions" />
        </template>

        <div class="settings-pane">

            <div class="text-xs-center">
                <div class="settings-header-image" v-if="withHeader">
                    <slot name="header-image" />
                 </div>
                 <div class="settings-header-name">
                    <slot name="name" />
                 </div>
                 <div class="settings-header-description">
                   <slot name="description" />
                </div>
            </div>
            <div class="container py-2">
                <div class="row">
                    <div class="col-xs-12 col-lg-8 offset-lg-2">
                        <div class="row my-2">
                            <slot name="settings-body" />
                        </div>
                    </div>
                </div>
            </div>

    </activity-box>
</template>
<script lang="babel">
import ActivityBox from '../components/ActivityBox.vue';

export default{
  data() {
    return {};
  },

  props: {
    title: {
      type: String,
      required: true,
    },
    subtitle: {
      type: String,
      default: '  ',
    },
    withHeader: {
      type: Boolean,
      default: true,
    },
  },
  components: { ActivityBox },
};
</script>
<style lang="scss" scoped>
@import '../styles/methods';

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

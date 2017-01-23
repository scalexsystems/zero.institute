<template>
<layout-box v-bind="{ disableFooter }">
  <template slot="context">
  <img class="message-box-photo" src="../assets/person.jpg" :src="photo" :class="[typeClass]"
       @click="$emit('openPhoto')">
  <div class="message-box-title-container">
    <div class="message-box-title" @click="$emit('openTitle')">
      <slot name="title">{{ title }}</slot>
    </div>
    <div class="message-box-subtitle" @click="$emit('openSubtitle')">
      <slot name="subtitle">{{ subtitle }}</slot>
    </div>
  </div>
  </template>

  <template slot="footer">
  <slot name="footer"></slot>
  </template>

  <template slot="actions">
  <slot name="actions"></slot>
  </template>

  <slot></slot>
</layout-box>
</template>

<script lang="babel">
import LayoutBox from './LayoutBox.vue';

export default {
  props: {
    type: {
      type: String,
      default: 'user',
    },
    title: String,
    subtitle: String,
    photo: String,
    ...LayoutBox.props,
  },
  components: { LayoutBox },
  computed: {
    typeClass() {
      const type = this.type;

      switch (type) {
        case 'user':
          return 'photo-square';
        default:
          return 'photo-round';
      }
    },
  },
};
</script>

<style lang="scss">
@import '../styles/methods';
@import '../styles/mixins';

$message-box-subtitle-color: #9b9b9b !default;
$border-radius-sm: .2rem;

.message-box-photo {
  width: rem(42px);
  height: rem(42px);

  cursor: pointer;

  &.photo-square {
    border-radius: $border-radius-sm;
  }

  &.photo-round {
    border-radius: 100%;
  }
}

.message-box-title-container {
  align-self: center;
  margin: -1px 1rem; // Top and bottom margin -1px to make height 70px.
  overflow-x: hidden;
}

.message-box-title {
  cursor: pointer;
  font-size: 1.28571rem;
  user-select: none;
  overflow-x: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.message-box-subtitle {
  overflow-x: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  cursor: pointer;
  color: $message-box-subtitle-color;
  font-size: 0.85714rem;
}
</style>

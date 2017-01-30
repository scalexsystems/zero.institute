<template>
  <div class="d-flex flex-row" :class="[ $style.header ]">
    <a v-if="back" class="d-flex align-items-center justify-content-center"
      :class="[ $style.back ]" @click.prevent="$emit('back')">
      <img src="../../../assets/back.svg" alt="Back">
    </a>
    <div v-else-if="photo" :class="[ $style.photo ]" @click="$emit('action', 'photo')">
      <img :src="photo">
    </div>
    <div :class="[ $style.titleGroup ]" @click="$emit('action', 'header')">
      <div :class="[ $style.title ]"    @click.stop="$emit('action', 'title')">{{ title }}</div>
      <div :class="[ $style.subtitle ]" @click.stop="$emit('action', 'subtitle')">{{ subtitle }}</div>
    </div>
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'ContainerHeader',

  props: {
    title: String,
    subtitle: String,
    back: Boolean,
    photo: String
  }
}
</script>

<style lang="scss" module>
@import '../../../styles/methods';

$border-radius-sm: 0.2rem !default;
$container-header-subtitle-color: #9b9b9b !default;

.header {
  padding: .714rem;
}

.photo, .back {
  margin-right: .714rem;
}

a.back {
  height: to-rem(42px);
  width: to-rem(42px);
  transition: all 200ms;
  border-radius: $border-radius-sm;

  &:hover, &:focus {
    text-decoration: none;
    background: darken(white, 5%);
  }
}

.photo img {
  border-radius: $border-radius-sm;
  height: to-rem(42px);
  width: to-rem(42px);
  object-fit: cover;
}

.title-group {
  margin: -1px 1rem -1px 0;
  overflow-x: hidden;
}

.title, .subtitle {
  overflow-x: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.title {
  font-size: 1.28571rem;
}

.subtitle {
  color: $container-header-subtitle-color;
  font-size: 0.85714rem;
  min-height: to-rem(17px);
}

.photo, .back, .title, .subtitle {
  cursor: pointer;
}
</style>

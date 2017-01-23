<template>
<div class="card person-card" @click.prevent="$emit('open')">
  <div class="card-block person-card-block">
    <img src="../assets/person.jpg" :src="item.photo" class="person-card-img" :class="[item._type]">
    <div class="person-card-info-container">
      <div class="person-card-name">{{ item.name }}</div>
      <div class="person-card-meta-container fl">
        <slot>
          <div class="person-card-bio text-capitalize"> {{ item.type }} &centerdot; {{ item.department }}  </div>
        </slot>
      </div>
    </div>
    <div class="person-card-actions">
      <slot name="actions"></slot>
    </div>
  </div>
</div>
</template>

<script lang="babel">
export default {
  props: {
    item: {
      required: true,
    },
  },
  computed: {
  },
};
</script>

<style lang="scss">
@import '../styles/variables';
@import '../styles/methods';

.person-card {
  cursor: pointer;
  margin-bottom: 20px;
}

.person-card-block {
  display: flex;
  flex-direction: row;
  padding: rem(9px) rem(10px);
}

.person-card-img {
  width: rem(48px);
  height: rem(48px);
  margin-right: rem(10px);

  &.user {
    border-radius: $border-radius-sm;
  }

  &.group {
    border-radius: 100%;
  }
}

.person-card-info-container {
  flex: 1;
}

.person-card-name {
  font-size: 1.14285rem;
}

.person-card-meta-container {
  display: flex;
  flex-direction: row;
}

.person-card-bio {
  flex: 1;
  font-size: 0.85714rem;
  color: $gray;
}

.person-card-joined {
    max-width: rem(55px);
    flex: 1;
    font-size: 0.85714rem;
    color: $brand-primary;
}
</style>

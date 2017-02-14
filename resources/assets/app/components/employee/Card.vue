<template>
<div class="c-employee-card card">
  <div class="c-employee-card-block">
    <div class="d-flex flex-row align-items-center">
      <img :src="employee.photo" class="rounded-circle c-employee-card-photo">
      <div>
        <div class="c-employee-card-title">{{ employee.name }}</div>
        <div class="c-employee-card-subtitle">
          <span class="text-primary text-uppercase" v-if="employee.is_member">Joined <span
                  class="text-muted">&centerdot;</span></span>
          <span class="text-muted">{{ employee.member_count_text }}</span>
        </div>
      </div>
    </div>

    <slot></slot>
  </div>
</div>
</template>

<script lang="babel">
export default {
  props: {
    employee: {
      type: Object,
      required: true
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-employee-card {
  &-photo {
    width: to-rem(48px);
    height: to-rem(48px);
    margin-right: to-rem(10px);
  }

  &-title {
    font-size: 1.14285rem;
  }

  &-subtitle {
    font-size: .75rem;
  }

  &-block {
    padding: .64286rem .71429rem;
  }
}
</style>

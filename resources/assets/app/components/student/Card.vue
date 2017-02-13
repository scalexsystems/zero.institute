<template>
<div class="c-student-card card">
  <div class="c-student-card-block">
    <div class="d-flex flex-row align-items-center">
      <img :src="student.photo" class="rounded-circle c-student-card-photo">
      <div>
        <div class="c-student-card-title">{{ student.name }}</div>
        <div class="c-student-card-subtitle">
          <span class="text-primary text-uppercase" v-if="student.is_member">Joined <span
                  class="text-muted">&centerdot;</span></span>
          <span class="text-muted">{{ student.member_count_text }}</span>
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
    student: {
      type: Object,
      required: true
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-student-card {
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

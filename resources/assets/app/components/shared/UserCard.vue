<template>
<abstract-card v-bind="{ remove }" class="c-user-card" @remove="$emit('remove', user)">
  <div class="d-flex flex-row align-items-center">
    <img :src="user.photo" class="rounded-circle c-user-card-photo fit-cover">
    <div>
      <div class="c-user-card-title" :class="{ 'text-muted': !user.name.trim() }">{{ user.name.trim() || 'Name not set' }}
      </div>
      <div class="c-user-card-subtitle">
        <span class="text-muted">Type:</span> {{ userType }}
      </div>
    </div>
  </div>

  <slot></slot>
</abstract-card>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
export default {
  props: {
    user: {
      type: Object,
      required: true
    },

    remove: {
      type: Boolean,
      default: false
    }
  },

  computed: {
    userType () {
      const user = this.user

      if ('type' in user) return user.type

      return user._type
    }
  }
}
</script>

<style lang="scss">
@import '../../styles/methods';

.c-user-card {
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
    text-transform: capitalize;
  }

  &-block {
    padding: .64286rem .71429rem;
  }
}
</style>

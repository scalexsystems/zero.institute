<template>
<div class="user-list">
  <router-link :to="{ name: 'hub.users' }"
               class="btn text-muted" style="padding-left: 0.25rem"
  ><i class="fa fa-plus-square-o fa-fw"></i> New Conversation
  </router-link>
  <div class="user-list-container">
    <div class="user-list-item" v-for="(user, index) of sortedUsers"
         :class="{ active: activeId === user.id }"
         @click="onUserSelected(user, index, $event)">
      <img class="user-list-photo" :src="user.photo">
      <div class="user-list-name" :class="{ unread: user.has_unread }">
        {{ user.name }}
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import sort from 'lodash/sortBy';
import first from 'lodash/first';
import int from 'lodash/toInteger';
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';

import { httpThen } from '../../../util';
import { getters, actions } from '../../vuex/meta';

export default {
  created() {
    if (!this.users.length) {
      this.getRecentUsers();
    }
  },
  computed: {
    sortedUsers() {
      const users = this.users;

      return sort(users, (user) => {
        const message = first(user.messages);
        if (!message) return 0;

        return -moment(message.received_at).valueOf();
      });
    },
    activeId() {
      const route = this.$route;

      if (route.name === 'hub.user') {
        return int(route.params.user);
      }

      return -1;
    },
    ...mapGetters({
      users: getters.users,
    }),
  },
  methods: {
    onUserSelected(user) {
      this.$router.push({
        name: 'hub.user',
        params: { user: user.id },
      });
    },
    getRecentUsers() {
      this.getUsers()
              .then(httpThen)
              .then((result) => {
                const paginator = result._meta.pagination;

                if (paginator.current_page < Math.min(2, paginator.total_pages)) {
                  setTimeout(() => this.getRecentUsers());
                }
              })
              .catch(response => response);
    },
    ...mapActions({
      getUsers: actions.getMessagedUsers,
    }),
  },
};
</script>

<style lang="scss" scoped>
@import "../../../styles/variables";
@import "../../../styles/methods";

$user-list-item-padding: rem(6px) !default;
$user-list-item-border-radius: rem(2px) !default;

$user-list-photo-size: rem(28px) !default;
$user-list-photo-border-radius: rem(2px) !default;

.user-list {
  &-container {

  }

  &-item {
    display: flex;
    flex-direction: row;
    border: 1px solid transparent;

    padding: $user-list-item-padding;
    cursor: pointer;
    user-select: none;
    line-height: $user-list-photo-size;

    border-radius: $user-list-item-border-radius;

    &:hover {
      background: white;
    }

    &.active {
      background: white;
      border: 1px solid $border-color;
    }

  }

  &-photo {
    width: $user-list-photo-size;
    height: $user-list-photo-size;
    border-radius: $user-list-photo-border-radius;

    margin-right: .5rem;
  }

  &-name {
    flex: 1;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;

    &.unread {
      color: $brand-info;
    }
  }

  &-unread-count {
    padding: 0 $user-list-item-padding;
  }
}
</style>

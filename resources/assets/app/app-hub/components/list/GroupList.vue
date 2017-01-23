<template>
<div class="group-list">
  <router-link :to="{ name: 'hub.groups' }"
               class="btn text-muted"
  ><i class="fa fa-plus-square-o fa-fw"></i> Join a Group
  </router-link>
  <div class="group-list-container">
    <div class="group-list-item" v-for="(group, index) of sortedGroups"
         :class="{ active: activeId === group.id }" :key="index"
         @click="onGroupSelected(group, index, $event)">
      <img class="group-list-photo" :src="group.photo">
      <div class="group-list-name" :class="{ unread: group.has_unread }">
        {{ group.name }}
      </div>
      <div class="group-list-unread-count" v-if="group.unread_count > 0">
        <span class="tag tag-default">
          {{ group.unread_count }}
        </span>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import each from 'lodash/each';
import sort from 'lodash/sortBy';
import first from 'lodash/first';
import int from 'lodash/toInteger';
import { mapActions, mapGetters } from 'vuex';
import moment from 'moment';

import { httpThen } from '../../../util';
import { actions, getters } from '../../vuex/meta';

export default {
  created() {
    if (!this.loaded) {
      this.getAllGroups();
      this.loaded = true;
    }
  },
  computed: {
    sortedGroups() {
      const groups = this.groups.filter(group => group.type === 'group');

      return sort(groups, (group) => {
        const message = first(group.messages);
        if (!message) return 0;

        return -moment(message.received_at).valueOf();
      });
    },
    activeId() {
      const route = this.$route;

      if ('group' in route.params) {
        return int(route.params.group);
      }

      return -1;
    },
    ...mapGetters({
      groups: getters.groups,
    }),
  },
  data() {
    return {
      joined: {},
      loaded: false,
    };
  },
  methods: {
    onGroupSelected(group) {
      this.$router.push({
        name: 'hub.group',
        params: { group: group.id },
      });
    },
    joinGroupChannels() {
      each(this.groups, (group) => {
        if (this.joined[group.id] !== true && group.channel) {
          this.$echo.join(group.channel).listen('NewMessage', (message) => {
            this.$debug('New Message', message);
            this.onMessage({ groupId: group.id, message });
          });

          this.joined[group.id] = true;
        }
      });
    },
    getAllGroups() {
      return this.getGroups()
              .then(httpThen)
              .then((result) => {
                const paginator = result._meta.pagination;

                if (paginator.current_page < paginator.total_pages) {
                  setTimeout(() => this.getAllGroups(), 0);
                }
              })
              .catch(response => response);
    },
    ...mapActions({
      getGroups: actions.getGroups,
      sendMessage: actions.sendMessageToGroup,
      onMessage: actions.onNewMessageToGroup,
    }),
  },
  watch: {
    groups() {
      this.joinGroupChannels();
    },
  },
};
</script>

<style lang="scss" scoped>
@import "../../../styles/variables";
@import "../../../styles/methods";

$group-list-item-padding: rem(6px) !default;
$group-list-item-border-radius: rem(2px) !default;

$group-list-photo-size: rem(28px) !default;
$group-list-photo-border-radius: rem(28px) !default;

.group-list {
  &-container {

  }

  &-item {
    display: flex;
    flex-direction: row;
    border: 1px solid transparent;

    padding: $group-list-item-padding;
    cursor: pointer;
    group-select: none;
    line-height: $group-list-photo-size;

    border-radius: $group-list-item-border-radius;

    &:hover {
      background: white;
    }

    &.active {
      background: white;
      border: 1px solid $border-color;
    }

  }

  &-photo {
    width: $group-list-photo-size;
    height: $group-list-photo-size;
    border-radius: $group-list-photo-border-radius;

    margin-right: .5rem;
  }

  &-name {
    flex: 1;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
  }

  &-unread-count {
    margin-top: -2px;
    font-size: 1.1rem;
  }
}
</style>

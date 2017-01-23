<template>
<div class="course-list my-1" v-if="courses.length">
  <div class="course-list-container">
    <div class="course-list-item" v-for="(course, index) of courses"
         :class="{ active: activeId === course.id }" :key="course.id"
         @click="onGroupSelected(course, index, $event)">
      <img class="course-list-photo" :src="course.session.group.photo">
      <div class="course-list-name" :class="{ unread: course.session.group.has_unread }">
        <span v-tooltip:right="course.name">{{ course.code }}</span>
      </div>
      <div class="course-list-unread-count" v-if="course.session.group.unread_count > 0">
        <span class="tag tag-default">
          {{ course.session.group.unread_count }}
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

export default {
  created() {
    this.getCourses();
  },
  computed: {
    groups() {
      return this.courses.map(course => course.session.group);
    },
    sortedGroups() {
      const groups = this.groups;

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
    ...mapGetters('hub', ['courses']),
  },
  data() {
    return {
      joined: {},
      loaded: false,
    };
  },
  methods: {
    onGroupSelected({ id }) {
      this.$router.push({
        name: 'acad.course',
        params: { course: id },
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
    ...mapActions('hub', {
      sendMessage: 'sendMessageToGroup',
      onMessage: 'onNewMessageToGroup',
    }),
    ...mapActions('hub', ['getCourses']),
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

.course-list {
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

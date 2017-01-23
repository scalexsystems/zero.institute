<template>
<div class="container hub-container">
  <div class="row hub-body">
    <div class="col-xs-12 col-lg-2 hub-sidebar-left fl fl-ver py-1" ref="sidebarLeft" @click="closeSidebar">
      <router-link v-if="user.permissions && user.permissions.courses" class="btn btn-text text-xs-left" :to="{ name: 'acad' }">
        <i class="fa fa-fw fa-book" /> Manage Courses
      </router-link>

      <course-list />

      <div class="btn-group my-1 d-block tab-buttons">
        <a class="btn btn-outline-secondary" :class="{active: !browseUsers}" role="button" @click.stop.prevent="browseUsers = false">
          Groups <span v-if="countGroupMessages > 0" class="tag tag-default">{{ countGroupMessages }}</span>
        </a>
        <a class="btn btn-outline-secondary" :class="{active: browseUsers}" role="button" @click.stop.prevent="browseUsers = true">
          Private <span v-if="countUserMessages > 0" class="tag tag-default">{{ countUserMessages }}</span>
        </a>
      </div>

      <group-list v-show="!browseUsers" />
      <user-list v-show="browseUsers" />
    </div>
    <div class="col-xs-12 col-lg-10 hub-content">
      <router-view />
    </div>
  </div>
</div>
</template>

<script lang="babel">
import scrollbar from 'perfect-scrollbar';
import { mapActions, mapGetters } from 'vuex';

import * as components from './components';

export default {
  name: 'Hub',
  components: { ...components },
  beforeDestroy() {
    scrollbar.destroy(this.$refs.sidebarLeft);
  },
  computed: {
    countUserMessages() {
      return this.users.reduce((total, user) => total + user.unread_count, 0);
    },
    countGroupMessages() {
      return this.groups.reduce((total, group) => total + group.unread_count, 0);
    },
    ...mapGetters('hub', ['groups', 'users']),
    ...mapGetters(['user']),
  },
  data() {
    return {
      browseUsers: false,
    };
  },
  methods: {
    closeSidebar() {
      this.$el.classList.remove('open-sidebar');
    },
    openSidebar() {
      this.$el.classList.add('open-sidebar');
    },
    toggleSidebar() {
      if (this.$el.classList.contains('open-sidebar')) {
        this.closeSidebar();
      } else {
        this.openSidebar();
      }
    },
    redirect() {
      if (this.$route.name === 'hub') {
        const group = this.$el.querySelector('.group-list-item');
        const user = this.$el.querySelector('.group-list-item');
        const link = this.$el.querySelector('a[href]');

        if (group) group.click();
        else if (user) user.click();
        else if (link) link.click();
      }
    },
    ...mapActions('hub', ['onNewMessageToUser']),
  },
  watch: {
    $route: 'redirect',
  },
  mounted() {
    this.$nextTick(() => {
      scrollbar.initialize(this.$refs.sidebarLeft, {
        suppressScrollX: true,
      });
      this.redirect();
    });
  },
  created() {
    if (this.user.channel) {
      this.$echo.private(this.user.channel)
        .listen('NewMessage', message => this.onNewMessageToUser({ message }));
    }
    this.$root.$on('sidebar', () => this.toggleSidebar());
  },
  beforeRouteEnter(to, from, next) {
    document.body.classList.add('has-sidebar');
    next();
  },
  beforeRouteLeave(to, from, next) {
    document.body.classList.remove('has-sidebar');
    next();
  },
};
</script>


<style lang="scss" scoped>
@import '../styles/variables';
@import '../styles/mixins';

.btn-text {
  color: inherit;
}

.tab-buttons {
  > a {
    width: 50%;
    padding-left: 0;
    padding-right: 0;
  }
}
.hub-container {
  @include match-parent();
  overflow: hidden;

  .btn-outline-secondary.active {
    background: white;
    color: inherit;
    border-color: $btn-secondary-border;
  }
}

.hub-body, .hub-content {
  height: 100%;
}

.hub-content {
  @include media-breakpoint-down(sm) {
    padding-left: 0;
    padding-right: 0;
  }
}

.hub-sidebar-left {
  height: 100%;
  overflow-y: auto;
  overflow-x: visible;

  @include media-breakpoint-up(lg) {
    margin-right: -15px;
    margin-left: 15/2px;
  }
}

@include media-breakpoint-down(md) {
  .hub-container {
    .hub-sidebar-left {
      z-index: $zindex-navbar;
      position: fixed;
      width: 70%;
      left: -70%;
      transition: left .3s;
    }
    .hub-content {
      transition: transform .3s;
    }

    &.open-sidebar {
      .sidebar-toggler {
        right: 0;
      }
      .hub-sidebar-left {
        left: 0;
      }
      .hub-content {
        transform: translateX(70%);
      }
    }
  }
}
</style>

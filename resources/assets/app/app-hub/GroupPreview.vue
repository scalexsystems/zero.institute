<template>
<activity-box v-if="group" class="hub-group-preview"
              v-bind="{ title, subtitle, show: true, actions: [], disableFooter: true }"
              @close="$router.go(-1)" >
  <template slot="actions">
    <router-link v-if="group.is_admin" :to="{ name: 'hub.group-edit', params: { group: group.id } }"
                 class="btn btn-primary">Edit</router-link>
    <action-menu v-if='group.is_member && !group.is_admin' :actions="[{ icon: 'sign-out', name: 'Leave Group', collapseIfRoom: false }]"
                 @option-click='actionClicks'>
    </action-menu>
  </template>

  <div class="container py-2">
    <div class="row">
      <div class="col-xs-12 col-lg-8 offset-lg-2 text-xs-center">
        <div class="my-2">
          <photo-holder v-if="group.is_admin"
                        class="group-preview-photo round"
                        :dest="`groups/${group.id}/photo`"
                        @uploaded="profileUpdated">
              <img :src="group.photo" class="group-preview-photo">
          </photo-holder>
          <img v-else :src="group.photo" class="group-preview-photo">
        </div>

        <div class="my-2">
          <span class="alert alert-info group-preview-tag" v-if="!group.private">Public Group</span>
          <span class="alert alert-danger group-preview-tag" v-else>Private Group</span>
        </div>

        <h2>{{ group.name }}</h2>

        <p>
          <small class="group-preview-description">{{ group.description }}</small>
        </p>

        <div class="my-2">
          <a href='#' @click.prevent="joinGroup" class="btn btn-primary" v-if="!group.is_member"> Join Group </a>
        </div>
      </div>

      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <div class="input-group input-group-lg">
          <span class="input-group-addon"><i class="fa fa-search"></i></span>
          <input class="form-control" type="search" v-model="q" @keyup="search">
        </div>
      </div>

      <div class="col-xs-12 col-lg-8 offset-lg-2">
          <div class="text-xs-center group-preview-member-count">
            <small> {{ group.member_count_text }} </small>
          </div>

          <div class="row">
            <div class="col-xs-12 col-lg-6" v-for="(member, index) of members">
              <item-card :item="member"
                         @open="openMemberProfile(member, index)"></item-card>
            </div>

            <infinite-scroll class="col-xs-12" :on-infinite="onInfinite" no-results:="" ref="infinite"></infinite-scroll>
        </div>
      </div>
    </div>
  </div>
</activity-box>

<loading-placeholder v-else></loading-placeholder>
</template>

<script lang="babel">
import int from 'lodash/toInteger';
import { mapGetters, mapActions } from 'vuex';
import throttle from 'lodash/throttle';
import InfiniteScroll from 'vue-infinite-loading';

import { pushIf } from '../util';
import { actions } from './vuex/meta';
import { getters as rootGetters, actions as rootActions } from '../vuex/meta';
import { LoadingPlaceholder, ActivityBox, PersonCard as ItemCard, ActionMenu, PhotoHolder } from '../components';

/* eslint-disable max-len */
export default {
  name: 'GroupPreview',
  components: { LoadingPlaceholder, ActivityBox, ItemCard, InfiniteScroll, ActionMenu, PhotoHolder },
  computed: {
    title() {
      const group = this.group;

      return group ? group.name : '';
    },
    subtitle() {
      return 'Group Information';
    },
    group() {
      const route = this.$route;
      const groupMap = this.groupMap;
      const groups = this.groups;

      const id = int(route.params.group);
      const index = groupMap[id];
      const group = groups[index];

      return group;
    },
    ...mapGetters({ groups: rootGetters.groups, groupMap: rootGetters.groupMap }),
  },
  created() {
    this.findGroup();
  },
  data() {
    return {
      ids: {},
      members: [],
      q: '',
      page: 0,
      uploadHover: false,
    };
  },
  methods: {
    search: throttle(function search() {
      this.page = 0;
      this.onInfinite();
    }),
    onInfinite() {
      this.$http.get(`groups/${this.group.id}/members`, { params: { q: this.q, page: this.page + 1 } })
              .then(response => response.json())
              .then((result) => {
                pushIf(this.members, result.data, this.ids);
                this.page = result._meta.pagination.current_page;
                this.$refs.infinite.$emit('$InfiniteLoading:loaded');
              })
              .catch(() => this.$refs.infinite.$emit('$InfiniteLoading:loaded'));
    },
    findGroup() {
      const id = int(this.$route.params.group);

      if (!(id in this.groupMap)) {
        this.getGroup({ id });
      }
    },
    ...mapActions({
      getGroup: rootActions.getGroups,
      joinGroupAction: actions.joinGroup,
      leaveGroupAction: actions.leaveGroup,
      updatePhoto: actions.updateGroupPhoto,
    }),

    joinGroup() {
      this.$http.post(`groups/${this.group.id}/join`)
      .then(() => {
        this.joinGroupAction({ groupId: this.group.id });
        this.$router.push({ name: 'hub.group' });
      });
    },

    leaveGroup() {
      this.$http.delete(`groups/${this.group.id}/leave`)
      .then(() => {
        this.leaveGroupAction({ groupId: this.group.id });
        this.$router.push({ name: 'hub.groups' });
      });
    },

    actionClicks(event, action, index) {
      const clickActions = [this.leaveGroup];
      return clickActions[index] ? clickActions[index]() : () => {};
    },

    openFile() {
      return this.$refs.inputFile.click();
    },

    profileUpdated(src) {
      this.updatePhoto({ groupId: this.group.id, photo: src });
    },
  },
  watch: {
    $route() {
      this.findGroup();
    },
  },
};
</script>

<style lang="scss">
@import "../styles/variables";
@import "../styles/methods";

.group-preview {
  &-photo {
    width: rem(160px);
    height: rem(160px);
    border-radius: 100%;
  }

  &-tag {
    padding: $spacer / 2;
    font-size: 0.875rem;
    padding: 0.3rem;
  }

  &-description {
    font-size: 1em;
    color: $gray;
  }

  &-member-count {
      padding: 1.4rem;

  }

  &-overlay-container {
      position: absolute;
      top: 20%;
      left: 0;
      width: 100%;
      height: 80%;
      color: $gray
  }

  &-upload-icon {
      font-size: 2.75em;
      width: 100%;
      margin-bottom: rem(20px);
  }
}


</style>

<template>
<activity-box v-if="values" subtitle="Update group details."
              v-bind="{ title, disableFooter: true }"
              @close="$router.push({ name: 'hub.group-preview', params: { group: group.id } })">
  <template slot="actions">
  <a class="btn btn-primary" role="button" tabindex @click.prevent.stop="updateGroup" ref="action">
    <i class="fa fa-fw fa-cloud-upload hidden-lg-up" v-tooltip:bottom="'Update Group'"></i> <span class="hidden-md-down">Update Group</span>
  </a>
  </template>

  <div class="container py-1">
    <div class="my-2 text-xs-center">
    </div>
    <div class="row">
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-text title="Name of the group" required v-model="values.name" :feedback="errors.name"></input-text>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-radio title="Group Type" required v-model="values.type" :options="groupTypes"
                     :feedback="errors.type"></input-radio>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-textarea title="Description" v-model="values.description" :feedback="errors.description"></input-textarea>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-search title="Add Members" v-model="query" v-bind="{suggestions}" @suggest="onSuggest"
                      @select="onSelect"></input-search>

        <div class="row">
          <div class="col-xs-12 col-lg-6" v-for="(member, key) in members" :key="key">
            <person-card :item="member">
              <a slot="actions" class="text-muted" href="#" v-tooltip="'Remove'" v-if="!isAdmin(member)"
                 @click.stop.prevent="removeMember(member)"
              ><i class="fa fa-fw fa-trash-o"></i></a>
            </person-card>
          </div>

          <infinite-scroll class="col-xs-12" :on-infinite="onInfinite" ref="infinite"></infinite-scroll>
        </div>
      </div>
    </div>
  </div>
</activity-box>
<loading-placeholder v-else></loading-placeholder>
</template>

<script lang="babel">
import int from 'lodash/toInteger';
import Validator from 'Validator';
import { mapGetters, mapActions } from 'vuex';
import throttle from 'lodash/throttle';
import InfiniteScroll from 'vue-infinite-loading';

import { pushOrMerge as set, isLastRecord, isValidationException, normalizeValidationErrors as normalize } from '../util';
import { actions } from './vuex/meta';
import { getters as rootGetters, actions as rootActions } from '../vuex/meta';
import { LoadingPlaceholder, ActivityBox, PersonCard } from '../components';

export default {
  name: 'GroupEdit',
  components: { LoadingPlaceholder, ActivityBox, PersonCard, InfiniteScroll },
  computed: {
    title() {
      const group = this.group;

      return group ? group.name : '';
    },
    groupTypes() {
      return {
        public: 'Public',
        private: 'Private',
      };
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
    ...mapGetters(['user']),
    ...mapGetters({
      groups: rootGetters.groups,
      groupMap: rootGetters.groupMap,
      suggestions: rootGetters.users,
    }),
  },
  created() {
    this.findGroup();
  },
  data() {
    return {
      values: {
        name: '',
        type: undefined,
        description: '',
      },
      errors: {},
      query: '',
      page: 0,
      members: [],
      editedGroup: {
        name: '',
        description: '',
        type: 'public',
        addedMembers: [],
        removedMembers: [],
      },
    };
  },
  methods: {
    updateGroup() {
      if (!this.validate()) {
        return;
      }

      this.$refs.action.classList.add('disabled');
      this.$http.put(`groups/${this.group.id}`,
        {
          ...this.values,
          addedMembers: this.editedGroup.addedMembers,
          removedMembers: this.editedGroup.removedMembers,
        })
          .then(response => response.json())
          .then((result) => {
            this.$refs.action.classList.remove('disabled');
            this.updateGroupAction([result]);
            this.$router.push({ name: 'hub.group-preview', params: { group: this.group.id } });
          })
          .catch((response) => {
            this.$refs.action.classList.remove('disabled');
            if (isValidationException(response)) {
              response.json().then(result => this.$set(this, 'errors', normalize(result.errors)));
            }

            return response;
          });
    },
    validate() {
      const v = Validator.make(this.values, {
        name: 'required|min:3|max:60',
        type: 'required',
        description: 'required',
      });

      if (v.fails()) {
        this.$set(this, 'errors', normalize(v.getErrors()));

        return false;
      }

      this.$set(this, 'errors', {});

      return true;
    },
    onSuggest: throttle(function onSuggest({ value, start, end }) {
      start();
      this.findMembers({ q: value }).then(end);
    }, 400),
    onSelect(member) {
      if (this.editedGroup.addedMembers.indexOf(member.id) < 0
              && this.members.indexOf(member) < 0) {
        this.editedGroup.addedMembers.push(member.id);
        this.members.push(member);
      }
    },
    removeMember(member) {
      if (this.editedGroup.removedMembers.indexOf(member.id) < 0) {
        const index = this.editedGroup.addedMembers.indexOf(member.id);
        if (index > -1) {
          this.editedGroup.addedMembers.splice(index, 1);
          this.members.splice(index, 1);
        }
      } else if (this.members.indexOf(member) < 0) {
        this.editedGroup.removedMembers.push(member.id);
        const removedMember = this.members.indexOf(member);
        if (removedMember >= 0) {
          this.members.splice(removedMember, 1);
        }
      }
    },
    search: throttle(function search() {
      this.page = 0;
      this.onInfinite(true);
    }),
    onInfinite(fromInfinite = true) {
      const infinite = {
        loaded: () => this.$refs.infinite.$emit('$InfiniteLoading:loaded'),
        complete: () => this.$refs.infinite.$emit('$InfiniteLoading:complete'),
        reset: () => this.$refs.infinite.$emit('$InfiniteLoading:reset'),
      };

      if (!fromInfinite) infinite.reset();
      this.page += 1;
      this.$http.get(`groups/${this.group.id}/members`, { params: { q: this.query } })
              .then(response => response.json())
              .then((result) => {
                set(this.members, result.data, this.ids);
                if (isLastRecord(result)) {
                  infinite.complete();
                } else {
                  infinite.loaded();
                }
              })
              .catch(() => infinite.complete());
    },
    setGroup() {
      if (this.group) {
        this.values = {
          name: this.group.name || '',
          type: this.group.private ? 'private' : 'public',
          description: this.group.description || '',
        };
      }
    },
    findGroup() {
      const id = int(this.$route.params.group);

      if (!(id in this.groupMap)) {
        this.getGroup({ id });
      } else {
        this.setGroup();
      }
    },
    isAdmin(member) {
      return this.group.is_admin && this.user.id === member.id;
    },
    ...mapActions({
      getGroup: rootActions.getGroups,
      updateGroupAction: actions.setGroups,
      findMembers: rootActions.getUsers,
    }),
  },
  watch: {
    $route: 'findGroup',
    group: 'setGroup',
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
    border-radius: $border-radius-sm;
  }
  &-tag {
    padding: $spacer / 2;
  }
}
</style>

<template>
<activity-box title="Add new group" subtitle="Make group to coverse better."
  @close="$router.push({ name: 'hub.groups' })">
  <template slot="actions">
    <a class="btn btn-primary" role="button" tabindex @click.prevent.stop="createGroup" ref="action">
      <i class="fa fa-fw fa-save hidden-lg-up" v-tooltip:bottom="'Create Group'"></i> <span class="hidden-md-down">Create Group</span>
    </a>
  </template>

  <div class="container py-1">
    <div class="my-2 text-xs-center">
    </div>
    <div class="row">
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-text title="Name of the group" required v-model="group.name" :feedback="errors.name"></input-text>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-radio title="Group Type" required v-model="group.type" :options="groupTypes"
                     :feedback="errors.type"></input-radio>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-textarea title="Description" v-model="group.description" :feedback="errors.description"></input-textarea>
      </div>
      <div class="col-xs-12 col-lg-8 offset-lg-2">
        <input-search title="Members" v-model="query" v-bind="{suggestions}" @suggest="onSuggest"
                      @select="onSelect"></input-search>

        <div class="row">
          <div class="col-xs-12 col-lg-6" v-for="(member, key) in members" :key="key">
            <person-card :item="member">
              <a slot="actions" class="text-muted" href="#" v-tooltip="Remove"
                 @click.stop.prevent="removeMember(member)"
              ><i class="fa fa-fw fa-trash-o"></i></a>
            </person-card>
          </div>
        </div>
      </div>
    </div>
  </div>
</activity-box>
</template>

<script lang="babel">
import Validator from 'Validator';
import throttle from 'lodash/throttle';
import { mapGetters, mapActions } from 'vuex';

import { ActivityBox, PersonCard } from '../components';
import { types as mutations } from './vuex/meta';
import { types as rootMutations, getters, actions } from '../vuex/meta';
import { isValidationException, normalizeValidationErrors as normalize } from '../util';

export default {
  name: 'GroupCreate',
  components: { ActivityBox, PersonCard },
  data() {
    return {
      group: {
        name: '',
        type: 'public',
        description: '',
        member_ids: [],
      },
      query: '',
      members: [],
      errors: {},
    };
  },
  computed: {
    groupTypes() {
      return {
        public: 'Public',
        private: 'Private',
      };
    },
    ...mapGetters({ suggestions: getters.users }),
  },
  methods: {
    createGroup() {
      if (!this.validate()) {
        return;
      }

      this.$refs.action.classList.add('disabled');
      this.$http.post('groups', this.group)
              .then(response => response.json())
              .then((result) => {
                this.$refs.action.classList.remove('disabled');
                this.$store.commit(mutations.ADD_GROUP, result);
                this.$store.commit(rootMutations.ADD_GROUP, result);
                this.$router.push({ name: 'hub.group', params: { group: result.id } });

                return result;
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
      const v = Validator.make(this.group, {
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
      if (this.group.member_ids.indexOf(member.id) < 0) {
        this.group.member_ids.push(member.id);
        this.members.push(member);
      }
    },
    removeMember(member) {
      const index = this.group.member_ids.indexOf(member.id);
      if (index > -1) {
        this.group.member_ids.splice(index, 1);
        this.members.splice(index, 1);
      }
    },
    ...mapActions({ findMembers: actions.getUsers }),
  },
  created() {
    if (!this.suggestions.length) this.findMembers();
  },
};
</script>

<style lang="scss">
</style>

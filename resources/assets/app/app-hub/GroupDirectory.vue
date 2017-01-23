<template>
    <activity-box
            v-bind="{ title, subtitle, disableFooter: true }"
            @close="$emit('close')">

        <template slot="icon">
          <img src="../assets/group-icon.svg">
        </template>

        <template slot="actions">
          <router-link class="btn btn-secondary" :to="{ name: 'hub.group-create' }">
            <i class="fa fa-fw fa-plus hidden-lg-up" v-tooltip="'Create New Group'"></i> <span class="hidden-md-down">Create New Group</span>
          </router-link>
        </template>

        <div class="container">
          <div class="directory-header row">
              <div class="col-xs-12 col-lg-8 offset-lg-2 my-2">
                  <div class="input-group input-group-lg">
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                      <input class="form-control" type="search" v-model="q" @keyup="$emit('search', q)">
                  </div>
              </div>
          </div>

          <div class="row directory-results-container">
              <div class="col-xs-12 col-lg-8 offset-lg-2">
                  <div class="row">
                      <div class="col-xs-12 directory-results-description">{{ resultMessage }}</div>
                  </div>
                  <div class="row">
                      <div v-for="(item, index) of filtered" class="col-xs-12 col-md-6">
                          <person-card :item="item" @open="onGroupSelected(item,index)">
                              <div class="person-card-bio">
                                <span v-if='item.is_member'>
                                  <span class="text-primary">JOINED</span> &centerdot;
                                </span>
                                {{ item.member_count_text }}
                              </div>
                          </person-card>
                      </div>

                      <infinite-scroll class="col-xs-12" :on-infinite="onInfinite" spinner="waveDots" ref="infinite"></infinite-scroll>
                  </div>
              </div>
          </div>
        </div>
    </activity-box>

</template>

<script lang="babel">
import Shifter from 'sifter';
import throttle from 'lodash/throttle';
import { mapActions, mapGetters } from 'vuex';

import InfiniteScroll from 'vue-infinite-loading';
import { httpThen } from '../util';
import { getters, actions } from '../vuex/meta';
import ActivityBox from '../components/ActivityBox.vue';
import PersonCard from '../components/PersonCard.vue';

export default {
  name: 'GroupDirectory',
  components: { ActivityBox, InfiniteScroll, PersonCard },
  computed: {
    ...mapGetters({
      groups: getters.groups,
    }),
    searchable() {
      const items = this.groups;
      return new Shifter(items);
    },
    filtered() {
      const searchable = this.searchable;
      const items = this.groups;
      const query = this.q;
      const result = searchable.search(query, {
        fields: ['name'],
        sort_empty: [{ field: 'name', direction: 'asc' }],
      });
      return result.items.map(({ id }) => items[id]);
    },
  },
  data() {
    return {
      q: '',
      page: 0,
      resultMessage: '',
      title: 'Campus Groups',
      subtitle: 'You can join any of these groups.',
    };
  },
  methods: {
    onClose() {
      this.$router.go(-1);
    },
    onGroupSelected(group) {
      const name = group.is_member === true ? 'hub.group' : 'hub.group-preview';

      this.$router.push({ name, params: { group: group.id } });
    },
    onSearch: throttle(function onSearch(query) {
      this.q = query;
      this.page = 1;
      this.getGroups({ q: query });
    }, 500),

    onInfinite() {
      const emit = (e) => {
        if (this.$refs.infinite) {
          this.$refs.infinite.$emit(e);
        }
      };
      const end = () => emit('$InfiniteLoading:complete');
      const done = () => emit('$InfiniteLoading:loaded');
      this.getGroups({ q: this.q, page: this.page + 1 })
              .then(httpThen)
              .then((result) => {
                this.page = result._meta.pagination.current_page;
                return result.data.length ? done() : end();
              });

      this.$emit('load-more', {
        done,
        end,
        error: end,
      });
    },
    ...mapActions({
      getGroups: actions.getGroups,
    }),
  },
};
</script>

<style lang="scss">
</style>

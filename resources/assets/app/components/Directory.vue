<template>
<activity-box
        v-bind="{ title, subtitle, disableFooter: true }"
        @close="$emit('close')">

  <template slot="icon">
    <img src="../assets/campus-directory-icon.svg">
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
            <div :is="component" :item="item" @open="$emit('item', item, index)"></div>
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
import InfiniteScroll from 'vue-infinite-loading';

import ItemCard from './PersonCard.vue';
import ActivityBox from './ActivityBox.vue';
import { mapObject } from '../util';

export default {
  props: {
    items: {
      required: true,
    },
    component: {
      default: 'item-card',
      type: String,
    },
    ...mapObject(ActivityBox.props, ['title', 'subtitle', 'actions', 'enableTopbar']),
  },
  components: { ActivityBox, ItemCard, InfiniteScroll },
  computed: {
    searchable() {
      const items = this.items;

      return new Shifter(items);
    },
    filtered() {
      const searchable = this.searchable;
      const items = this.items;
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
      resultMessage: '',
    };
  },
  methods: {
    onInfinite() {
      const emit = (e) => {
        if (this.$refs.infinite) {
          this.$refs.infinite.$emit(e);
        }
      };
      const end = () => emit('$InfiniteLoading:complete');
      const done = () => emit('$InfiniteLoading:loaded');

      this.$emit('load-more', {
        done,
        end,
        error: end,
      });
    },
  },
};
</script>

<style lang="scss">
.directory {
  &-header {

  }
  &-result-container {

  }
}
</style>

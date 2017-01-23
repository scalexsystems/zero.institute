<template>
  <directory title="Campus Directory"
             subtitle="You can message any member of the institute."
             v-bind="{ items: users }"
             @load-more="onInfinite"
             @close="onClose"
             @search="onSearch"
             @item="onPersonSelected" />
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex';
import throttle from 'lodash/throttle';

import { httpThen } from '../util';
import { getters, actions } from '../vuex/meta';
import Directory from '../components/Directory.vue';

export default {
  name: 'UserDirectory',
  created() {
    this.getPeople({});
  },
  components: { Directory },
  computed: {
    ...mapGetters({
      users: getters.users,
    }),
  },
  data() {
    return { q: '', page: 0 };
  },
  methods: {
    onClose() {
      window.history.back();
    },
    onPersonSelected(user) {
      this.$router.push({ name: 'hub.user', params: { user: user.id } });
    },
    onSearch: throttle(function onSearch(query) {
      this.page = 1;
      this.q = query;
      this.getPeople({ q: query });
    }, 500),
    onInfinite({ done }) {
      this.getPeople({ q: this.q, page: this.page + 1 })
              .then(httpThen)
              .then((result) => {
                this.page = result._meta.pagination.current_page;

                done();
              })
              .catch(() => done());
    },
    ...mapActions({
      getPeople: actions.getUsers,
    }),
  },
};
</script>

<style lang="scss"></style>

<template>
<div>
  <message-box v-if="context"
               :title="context.name"
               :subtitle="context.bio"
               :photo="context.photo"
               @openTitle="openUserPreview" @openSubtitle="openUserPreview" @openPhoto="openUserPreview">
    <message-list ref="list" :messages="context.messages" :loading="loading" :all-loaded="allLoaded"
                  @load-more="loadMore" @seen="markMessagesSeen"></message-list>

    <message-editor slot="footer" ref="input" v-model="message" :dest="`messages/attachment`" @send="send"
                    @focused="markMessagesSeen"></message-editor>
  </message-box>

  <loading-placeholder v-else></loading-placeholder>
</div>
</template>

<script lang="babel">
import first from 'lodash/first';
import each from 'lodash/each';
import int from 'lodash/toInteger';
import { mapActions, mapGetters } from 'vuex';

import { MessageBox, MessageEditor, LoadingPlaceholder } from '../components';
import { httpThen } from '../util';
import { actions as rootActions } from '../vuex/meta';
import { getters, actions, types as mutations } from './vuex/meta';
import MessageList from './components/MessagePane.vue';

export default {
  name: 'UserMessages',
  components: {
    MessageBox,
    MessageList,
    MessageEditor,
    LoadingPlaceholder,
  },
  computed: {
    context() {
      const route = this.$route;
      const userMap = this.userMap;
      const users = this.users;

      const id = int(route.params.user);
      const index = userMap[id];
      const user = users[index];

      if (!user) window.setTimeout(() => this.findUser(), 0);

      return user;
    },
    ...mapGetters({
      users: getters.users,
      userMap: getters.userMap,
    }),
  },
  data() {
    return {
      message: '',
      disabled: false,
      loading: false,
      allLoaded: false,
    };
  },
  methods: {
    send(content, attachments = [], errors = []) {
      this.sendMessage({ userId: this.context.id, content, errors, params: { attachments } });
      this.message = '';
      this.$refs.input.resize();
      this.$refs.input.focus();
    },
    loadMore(loader) {
      this.getMessages({ userId: this.context.id, params: {} })
              .then(httpThen)
              .then((result) => {
                const paginator = result._meta.pagination;

                if (paginator.current_page < paginator.total_pages) {
                  const message = first(this.context.messages);

                  if (message && message.unread === true) {
                    this.loadMore(loader);
                    return;
                  }
                }

                if (paginator.current_page < paginator.total_pages) {
                  loader.done();
                } else {
                  loader.end();
                }
              })
              .catch(() => loader.error());
    },
    markMessagesSeen() {
      window.setTimeout(() => {
        const messages = this.context.messages.filter(message => message.unread);
        each(messages, message => this.readMessage({ userId: this.context.id, message }));
      }, 1000);
    },
    findUser() {
      if (!(this.$route.params.user in this.userMap)) {
        this.findUsers({ id: this.$route.params.user })
                .then(httpThen)
                .then((result) => {
                  this.$store.commit(mutations.ADD_USER, result.data);
                });
      }
    },
    openUserPreview() {
      this.$router.push({ name: 'hub.user-preview', params: { user: this.context.id } });
    },
    ...mapActions({
      findUsers: rootActions.getUsers,
      readMessage: actions.sendMessageReadReceipt,
      sendMessage: actions.sendMessageToUser,
      getMessages: actions.getMessagesFromUser,
    }),
  },
  watch: {
    $route(to, from) {
      if (this.message.trim().length) {
        const key = `user.${from.params.user}.message`;

        window.localStorage.setItem(key, this.message);
      }

      const key = `user.${to.params.user}.message`;

      this.message = window.localStorage.getItem(key) || '';

      return this.findUser();
    },
  },
  beforeRouteEnter(to, from, next) {
    const key = `user.${to.params.user}.message`;

    if (key in window.localStorage) {
      next(vm => vm.$set(vm, 'message', window.localStorage.getItem(key)));
    } else {
      next(vm => vm.$set(vm, 'message', ''));
    }
  },
  beforeRouteLeave(to, from, next) {
    if (this.message.trim().length) {
      const key = `user.${this.context.id}.message`;

      window.localStorage.setItem(key, this.message);
    }

    next();
  },
};
</script>


<style lang="scss">

</style>

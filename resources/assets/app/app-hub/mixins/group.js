import last from 'lodash/last';
import each from 'lodash/each';
import { mapActions, mapGetters } from 'vuex';

import { MessageBox, MessageEditor, LoadingPlaceholder } from '../../components';
import { getters, actions } from '../vuex/meta';
import { httpThen } from '../../util';
import MessageList from '../components/MessagePane.vue';

export default {
  components: {
    MessageBox,
    MessageList,
    MessageEditor,
    LoadingPlaceholder,
  },
  computed: {
    context() {
      const groups = this.groups;
      const id = this.groupId;

      return groups.find(group => group.id === id);
    },
    ...mapGetters({
      groups: getters.groups,
      groupMap: getters.groupMap,
    }),
  },
  created() {
    this.findGroup();
  },
  data() {
    return {
      message: '',
    };
  },
  methods: {
    send(content, attachments = [], errors = []) {
      this.sendMessage({ groupId: this.context.id, content, errors, params: { attachments } });
      this.message = '';
      const key = `group.${this.context.id}.message`;
      if (key in window.localStorage) {
        window.localStorage.removeItem(key);
      }
      this.$refs.input.resize();
      this.$refs.input.focus();
    },
    findGroup() {
      const id = this.groupId;
      if (id && !(id in this.groupMap)) {
        this.findGroupById(id);
      }
    },
    getOlderMessages(loader) {
      if (this.context.messages_loaded) {
        loader.end();

        return;
      }

      this.getMessages({ groupId: this.context.id })
              .then(httpThen)
              .then((result) => {
                const paginator = result._meta.pagination;

                if (paginator.current_page < paginator.total_pages) {
                  const message = last(result.data);

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
              .catch(response => response);
    },
    markMessagesSeen(payload = null) {
      const groupId = this.context.id;
      if (payload !== null) {
        this.readMessage({ groupId, message: payload });
        return;
      }

      const messages = this.context.messages.filter(message => message.unread);
      each(messages, message => this.readMessage({ groupId, message }));
    },
    ...mapActions({
      getMessages: actions.getMessagesFromGroup,
      readMessage: actions.sendMessageReadReceiptForGroup,
      sendMessage: actions.sendMessageToGroup,
    }),
    ...mapActions('hub', ['findGroupById']),
  },
  watch: {
    context(value) {
      this.$debug('Group Updated.', value);

      if (value && value.messages.length === 0) {
        this.getOlderMessages({ done() {}, end() {} });
      }

      if (value && !value.messages_loaded) {
        this.$nextTick(() => {
          this.$refs.messages.$emit('reset');
        });
      }
    },
    groupId: 'findGroup',
  },
};

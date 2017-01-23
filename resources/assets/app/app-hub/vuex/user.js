import isArray from 'lodash/isArray';
import unique from 'lodash/uniqBy';
import sort from 'lodash/sortBy';
import Vue from 'vue';
import { pushIf } from '../../util';

const bootedAt = Date.now();

export default {
  state: {
    users: [],
    userMap: {},
  },
  getters: {
    users(state) {
      return state.users;
    },
    userMap(state) {
      return state.userMap;
    },
  },
  mutations: {
    ADD_USER(state, payload) {
      const users = (isArray(payload) ? payload : [payload])
          .map(user => ({
            messages: [],
            messages_next_page: 1,
            has_unread: false,
            unread_count: 0,
            ...user,
          }));

      pushIf(state.users, users, state.userMap);
    },
    SET_MESSAGE_PAGE_TO_USER(state, { userId, paginator }) {
      if (!(userId in state.userMap)) return;

      const index = state.userMap[userId];
      state.users[index].messages_next_page = paginator.current_page + 1;
    },
    ADD_MESSAGE(state, { userId, messages }) {
      if (!(userId in state.userMap)) return;

      const index = state.userMap[userId];
      const user = state.users[index];

      user.messages.push(...messages);
      user.messages = sort(unique(user.messages, 'id'), 'id');
      user.unread_count = user.messages.filter(message => message.unread).length;
      user.has_unread = user.unread_count > 0;
    },
    READ_MESSAGE(state, { userId, message }) {
      if (!(userId in state.userMap)) return;

      const index = state.userMap[userId];
      const user = state.users[index];
      const messageIndex = message.messages.indexOf(message);
      const messageState = user.messages[messageIndex];

      messageState.read_at = (new Date()).toISOString();
      if (messageState.unread) {
        user.unread_count -= 1;
      }
      messageState.unread = false;
      user.has_unread = user.unread_count > 0;
    },
    STATUS_MESSAGE(state, { userId, message, payload, success }) {
      const index = state.userMap[userId];
      const messageIndex = state.users[index].messages.indexOf(message);
      if (success) {
        state.users[index].messages.splice(messageIndex, 1, payload);
      } else {
        state.users[index].messages[messageIndex].failed = true;
        state.users[index].messages[messageIndex].sending = false;
      }
    },
  },
  actions: {
    getMessagedUsers({ commit }, params = {}) {
      return Vue.http.get('me/messages/users', { params })
          .then(response => response.json())
          .then((result) => {
            commit('ADD_USER', result.data);

            return result;
          })
          .catch(response => response);
    },
    getMessagesFromUser({ commit, state }, { userId, params }) {
      const index = state.userMap[userId];
      const user = state.users[index];
      const payload = {
        params: {
          timestamp: bootedAt,
          page: user.messages_next_page,
          ...params,
        },
      };

      return Vue.http.get(`me/messages/users/${userId}`, payload)
          .then(response => response.json())
          .then((result) => {
            commit('ADD_MESSAGE', { userId, messages: result.data });
            commit('SET_MESSAGE_PAGE_TO_USER', { userId, paginator: result._meta.pagination });

            return result;
          })
          .catch(response => response);
    },
    onNewMessageToUser({ commit }, { userId, message }) {
      const senderId = userId === undefined
          ? message.sender.id
          : userId;

      commit('ADD_MESSAGE', { userId: senderId, messages: [message] });
    },
    sendMessageToUser({ commit, rootState }, { userId, content, params = {}, errors = [] }) {
      const message = { id: Date.now(), content, sending: true, sender: rootState.user };
      commit('ADD_MESSAGE', { userId, messages: [message] });

      return Vue.http.post(`me/messages/users/${userId}`, { content, ...params })
          .then(response => response.json())
          .then((result) => {
            commit('STATUS_MESSAGE', {
              userId,
              message,
              payload: { ...result, errors },
              success: true,
            });
          })
          .catch((response) => {
            commit('STATUS_MESSAGE', { userId, message, success: false });

            return response;
          });
    },
    sendMessageReadReceipt({ commit, rootState }, { userId, message }) {
      if (message.sender_id === rootState.user.user.id) {
        commit('READ_MESSAGE', { userId, message });

        return;
      }

      Vue.http.put(`me/messages/${message.id}/read`)
          .then(() => commit('READ_MESSAGE', { userId, message }))
          .catch(response => response);
    },
  },
};

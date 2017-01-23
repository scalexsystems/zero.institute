<template>
<activity-box v-if="user"
              v-bind="{ title, subtitle, show: true, actions: [], disableFooter: true }"
              @close="close">

  <div class="container py-2">
    <div class="text-xs-center">
      <img class="user-preview-photo my-2" :src="user.photo">

      <h2>{{ user.name }}</h2>
      <p>
        <span class="text-muted" v-if="user.person._type === 'student'">Roll Number:</span>
        <span class="text-muted" v-else>Employee ID:</span> {{ user.person.uid }}
      </p>
      <p v-if="user.person._type === 'student'">
        Student &centerdot; {{ department(user.person.department_id) }}
      </p>
      <p v-if="user.person._type === 'teacher'">
        {{ user.person.designation || 'Teacher' }} &centerdot; {{ department(user.person.department_id) }}
      </p>
      <p v-if="user.person._type === 'employee'">
        {{ user.person.designation || 'Employee' }} &centerdot; {{ department(user.person.department_id) }}
      </p>

      <div class="my-2">
        <router-link :to="{name: 'hub.user', params: { user: user.id } }"
                     class="btn btn-primary">Send Message
        </router-link>
      </div>
    </div>
  </div>
</activity-box>
<loading-placeholder v-else></loading-placeholder>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex';

import { LoadingPlaceholder, ActivityBox } from '../components';

export default {
  name: 'UserPreview',
  components: { LoadingPlaceholder, ActivityBox },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.user = null;
    });
  },
  computed: {
    title() {
      const user = this.user || {};

      return user.name;
    },
    subtitle() {
      const user = this.user || {};

      return user.bio || 'User Profile';
    },
    ...mapGetters('school', ['departments']),
  },
  data() {
    return {
      user: null,
    };
  },
  created() {
    if (!this.departments.length) {
      this.getDepartments();
    }
    this.fetchUser();
  },
  methods: {
    close() {
      window.history.back();
    },
    department(value) {
      return (this.departments.find(d => d.id === value) || {}).name;
    },
    fetchUser() {
      this.$http.get(`people/${this.$route.params.user}`)
            .then(response => response.json())
            .then(user => this.$set(this, 'user', user))
            .catch(() => {
              // TODO: Redirect to 404!
            });
    },
    ...mapActions('school', ['getDepartments']),
  },
  watch: {
    $route: 'fetchUser',
  },
};
</script>

<style lang="scss">
@import "../styles/variables";
@import "../styles/methods";

.user-preview {
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

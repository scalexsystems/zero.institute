<template>
<div class="dropdown" :id="id">
    <a href="#" :id="toggler" class="btn navbar-toggler"
        data-toggle="dropdown" aria-haspopup="true" role="button" aria-expanded="false"
        :data-target="'#'+id"><img src="../assets/apps.svg" alt="Menu"></a>

    <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="'#'+toggler">

        <h6 class="dropdown-header text-uppercase m-y-1 text-xs-center">Select any one</h6>

        <hr class="mb-0">

        <div class="app-menu-container">
            <router-link :to="item.link" class="app-launcher text-xs" v-for="item in apps" role="menuitem"
               :disabled="item.locked === true">
                <img class="app-icon" :src="item.icon">
                <div class="app-label" v-if="item.locked === true" v-tooltip:bottom="'Coming soon!'">
                    {{ item.name }} <i class="fa fa-fw fa-lock"></i>
                </div>
                <div class="app-label" v-else>{{ item.name }}</div>
            </router-link>

            <div class="p-y-2 text-xs-center" v-if="apps.length === 0">
                <span>No apps</span>
            </div>
        </div>

    </div>
</div>
</template>

<script lang="babel">
import { mapGetters } from 'vuex';
import people from '../assets/apps/people.svg';
import hub from '../assets/apps/hub.svg';
import settings from '../assets/apps/menu-settings.svg';
import academics from '../assets/apps/academics.svg';
import finances from '../assets/apps/finance.svg';

export default {
    // DATA
  data() {
    return {
      current: null,
      allowed: [],
    };
  },
  computed: {
    id() {
      /* eslint-disable */
      return this._uid;
      /* eslint-enable */
    },
    toggler() {
      return `${this.id}-toggler`;
    },
    apps() {
      const user = this.user;
      const apps = [
        { name: 'Hub', icon: hub, link: '/' },
        { name: 'People', icon: people, link: '/people' },
        { name: 'Academics', icon: academics, link: '/academics', locked: true },
        { name: 'Finances', icon: finances, link: '/finances', locked: true },
      ];

      if (user.permissions && user.permissions.settings) {
        apps.splice(2, 0, { name: 'Settings', icon: settings, link: '/hub/settings' });
      }

      return apps;
    },
    ...mapGetters(['user']),
  },
};
</script>

<style lang="scss" scoped>
.navbar-toggler {
  padding-top: .7rem; // This adjusts toggler in middle of line.
  user-select: none;
  &:focus {
    outline: none;
  }
  background: transparent;
  border-color: transparent;
}

.app-menu-container {
    display: flex;
    flex-flow: wrap;
    width: 300px;
    padding: 0.5rem;
}

.app-launcher {
    color: inherit;
    text-align: center;
    flex: 0 0 33.33333%;
    max-width: 33.33333%;
    padding: 0.5rem;
    &:hover {
        color: inherit;
        text-decoration: none;
    }
    &[disabled] {
        opacity: .5;
        img {
            filter: grayscale(100%);
        }
    }
    img.app-icon {
        width: 48px;
        height: 48px;
        cursor: pointer;
    }
    div.app-label {
        font-size: 0.8rem;
        cursor: pointer;
    }
}
</style>

<template>

<settings-box class="settings"
              v-bind="{ title, subtitle }"
              @close="$router.go(-1)">

    <template slot="icon">
      <a class="activity-box-dismiss" role="button">
          <img src="../assets/settings/icon-settings.svg">
      </a>
    </template>


    <template slot="header-image">
        <img src="../assets/settings/admin-settings.svg">

    </template>

    <template slot="name">
        Institute Admin Settings
    </template>

    <template slot="settings-body">
       <div class="col-xs-12 col-lg-6 settings-items" v-for="(setting,index) in settingCards">
            <setting-card class="settings-card" :title="setting.title" :text="setting.text" v-bind="{ index }"
                         @cardClicked="settingClicked" />
      </div>
    </template>
</settings-box>

</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex';
import { getters, actions } from '../vuex/meta';
import SettingCard from './SettingsCard.vue';
import SettingsBox from './SettingsBox.vue';


export default {
  data() {
    return {
      title: 'Settings',
      subtitle: 'Institute Admin Settings',
    };
  },
  components: { SettingsBox, SettingCard },
  computed: {
    settingCards() {
      return [
        {
          title: 'Departments',
          text: `${this.departments.length} departments added`,
          path: 'departments',
        },
        {
          title: 'Disciplines',
          text: 'Add discipline here',
          path: 'disciplines',
        },
        {
          title: 'Semesters',
          text: 'Click to add semesters',
          path: 'semesters',
        },
        {
          title: 'Course Management',
          text: 'Click here to assign',
          path: 'course-management',
        },
        {
          title: 'Institute webmail domain',
          text: 'Set intitute website',
          path: '/webmail-domain',
        },
        {
          title: 'Institute Details',
          text: 'Enter institute details',
          path: 'institute-details',
        },
        {
          title: 'Send invites',
          text: 'Invite students and teachers',
          path: 'send-invites',
        },
      ];
    },
    ...mapGetters({
      departments: getters.departments,
    }),
  },
  methods: {
    settingClicked(index) {
      this.$router.push({ name: this.settingCards[index].path });
    },
    ...mapActions({
      getDepartments: actions.getDepartments,
    }),
  },
};
</script>

<style lang="scss" scoped>
@import '../styles/methods';

    a {
        color: inherit;
    }

    .settings-items {
       text-align: left;
       height: rem(70px);
       margin: rem(10px) 0;
    }

</style>

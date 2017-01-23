<template>
  <settings-box title="Course Manager" subtitle="Assign Course Manager/Administrator">

      <template slot="actions" v-if="addedManagers.length">
          <div role="button" class="btn btn-default" @click="onCancel"> Cancel </div>
          <div role="button" class="btn btn-primary" @click="onSave"> Save </div>
      </template>

      <template slot="header-image">
          <img src="../assets/settings/course-admin.svg">
      </template>

      <template slot="name">
          Course Manager
      </template>

      <template slot="description">
          He/she is responsible to add courses and assign teachers/coordinator to respective courses.

          <div class="alert alert-danger" v-if="message">{{ message }}</div>
      </template>
        <template slot="settings-body">

            <div class="col-xs-12 col-lg-12 search-wrapper">
                <div class="input-group input-group-lg">
                    <input-search class="form-control teacher-search" title="" v-model="query" v-bind="{suggestions}" @suggest="onSuggest"
                                  @select="onSelect"></input-search>
                </div>

                <div class="manager-list my-1" v-if="addedManagers.length">
                  <div class="mb-1">
                    <small class="text-muted">Add new Course Manager</small>
                  </div>

                  <div class="row">
                      <div class="col-xs-12 col-lg-6" v-for="(manager, index) of addedManagers">
                          <item-card :item="manager"
                                     @open="openMemberProfile(manager, index)">
                              <div class="person-card-bio" v-if="!manager.bio"> Profile not updated </div>
                          </item-card>
                      </div>
                  </div>
                </div>

                <div class="manager-list my-1">
                  <div class="mb-1">
                    <small class="text-muted" v-if="addedManagers.length">Existing Course Manager</small>
                  </div>
                  <div class="row">
                      <div class="col-xs-12 col-lg-6" v-for="(manager, index) of managers">
                          <item-card :item="manager"
                                     @open="openMemberProfile(manager, index)">
                              <div class="person-card-bio" v-if="!manager.bio"> Profile not updated </div>
                          </item-card>
                      </div>
                  </div>
                </div>
            </div>
        </template>
    </settings-box>
</template>
<script lang="babel">
import { mapActions, mapGetters } from 'vuex';
import { throttle } from 'lodash';
import SettingsBox from './SettingsBox.vue';
import SettingsCard from './SettingsCard.vue';
import Modal from '../components/Modal.vue';
import { PersonCard as ItemCard } from '../components';

export default{
  created() {
    if (this.managers.length === 0) {
      this.getManagers();
    }
    if (!this.teachers.length) {
      this.getTeachers();
    }
  },
  data() {
    return {
      loaded: false,
      errors: {},
      managers: [],
      query: '',
      message: undefined,
      addedManagers: [],
    };
  },
  computed: {
    suggestions() {
      return [].concat(this.teachers);
    },
    ...mapGetters('school', ['teachers']),
  },
  components: { SettingsBox, Modal, SettingsCard, ItemCard },
  methods: {
    getManagers() {
      this.$http.get('people/roles/course-manager')
        .then((response) => {
          this.managers = response.body.data;
        });
    },
    onSuggest: throttle(function onSuggest({ value, start, end }) {
      start();
      this.getTeachers({ q: value }).then(end);
    }, 400),
    onSelect(person) {
      if (this.managers.indexOf(person.id) < 0) {
        this.query = person.name;
        this.addedManagers.push(person);
      }
    },
    onSave() {
      const managers = this.addedManagers.map(m => ({ id: m.id, type: m._type }));
      if (managers.length) {
        this.$http.post('people/roles', { managers, role: 'course-manager' })
        .then(() => {
          this.managers = this.managers.concat(this.addedManagers);
          this.message = undefined;
          this.addedManagers = [];
        })
        .catch(response => response.json())
        .then(({ message }) => {
          this.message = message;
        });
      }
    },
    onCancel() {
      if (this.addedManagers.length) {
        this.addedManagers = [];
        this.message = undefined;
      }
    },
    ...mapActions('school', ['getTeachers']),
  },
};
</script>
<style lang="scss" scoped>
@import '../styles/variables';
@import '../styles/methods';
.btn-default{
  border: solid 1px $gray;
  }
.btn {
  margin: 0 rem(10px);
  width: rem(80px);
}

.person-card-bio {
    flex: 1;
    font-size: 0.85714rem;
    color: $gray;
}

.teacher-search {
   border: 0;
   padding: 0;
}

.search-wrapper {
   padding: 0;
}

</style>

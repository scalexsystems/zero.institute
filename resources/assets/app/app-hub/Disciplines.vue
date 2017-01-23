<template>
    <settings-box title="Disciplines" subtitle="Add/remove institute disciplines">

        <template slot="actions">
            <div role="button" class="btn btn-primary" @click="showAddDiscipline"> {{ title }} </div>
        </template>


        <template slot="header-image">
            <img src="../assets/settings/discipline.svg">
        </template>

        <template slot="name">
            Disciplines
        </template>

        <template slot="description">
            e.g. B.Tech, M.Tech, MBA, B.E, M.E, etc
        </template>

        <template slot="settings-body">
            <modal name="Add new disciplines" :show="onAdd" :dismissable="false">
                <div class="card">
                  <h4 class="card-header bg-white">Add New Discipline</h4>

                  <div class="card-block">
                      <input-text title="Name of the discipline" required v-model="discipline.name" :feedback="errors.name"></input-text>
                      <input-text title="Discipline Acronym" v-model="discipline.short_name" :feedback="errors.acronym"></input-text>

                      <div class="mt-1 float-xs-right">
                        <a role="button" class="btn btn-secondary btn-cancel" tabindex @click="onCancel">Cancel</a>
                        <a role="button" class="btn btn-primary" tabindex @click="onSubmit">Save</a>
                      </div>
                  </div>
                </div>
            </modal>
            <div class="container py-2">
                <div class="row my-2">
                    <settings-card class="col-xs-12 col-lg-6" v-for="(discipline, index) in disciplines" :title="discipline.name"
                                   :index="index" :text="discipline.short_name" @cardClicked="disciplineClicked">
                    </settings-card>
                </div>
            </div>
        </template>
    </settings-box>

</template>
<script lang="babel">
import { mapActions, mapGetters } from 'vuex';
import { clone } from 'lodash';
import SettingsBox from './SettingsBox.vue';
import SettingsCard from './SettingsCard.vue';
import Modal from '../components/Modal.vue';
import { actions, getters } from '../vuex/meta';

export default{
  created() {
    if (this.disciplines.length === 0) {
      this.getDisciplines();
    }
  },
  data() {
    return {
      onAdd: false,
      loaded: false,
      discipline: {
        name: '',
        short_name: '',
      },
      editReference: {
        id: false,
        index: false,
      },
      errors: {},
    };
  },
  computed: {
    title() {
      return this.editReference.id ? 'Edit Discipline' : 'Add New Discipline';
    },
    ...mapGetters({
      disciplines: getters.disciplines,
    }),
  },
  components: { SettingsBox, Modal, SettingsCard },
  methods: {
    showAddDiscipline() {
      this.onAdd = true;
    },
    onCancel() {
      this.onAdd = false;
      this.resetReference();
    },
    onSubmit() {
      const call = this.editReference.id ? 'updateDiscipline' : 'addNewDiscipline';
      this[call]();
    },
    addNewDiscipline() {
      this.$http.post('disciplines', this.discipline)
      .then(() => {
        const discipline = clone(this.discipline);
        this.onAdd = false;
        this.addDiscipline(discipline);
        this.resetReference();
      })
      .catch(() => {});
    },
    updateDiscipline() {
      this.$http.put(`disciplines/${this.editReference.id}`, this.discipline)
      .then(() => {
        this.onAdd = false;
        const discipline = clone(this.discipline);
        this.disciplines[this.editReference.index] = discipline;
        this.updateDisciplineAction(discipline);
        this.resetReference();
      });
    },
    disciplineClicked(index) {
      const discipline = this.disciplines[index];
      this.editReference = {
        id: discipline.id,
        index,
      };
      this.discipline = clone(discipline);
      this.onAdd = true;
    },
    resetReference() {
      Object.keys(this.discipline).forEach((key) => {
        this.discipline[key] = '';
      });
      this.editReference = {
        id: false,
        index: false,
      };
    },
    ...mapActions({
      getDisciplines: actions.getDisciplines,
      addDiscipline: actions.addDiscipline,
      updateDisciplineAction: actions.updateDiscipline,
    }),
  },
};
</script>
<style lang="scss" scoped>
@import '../styles/variables';
@import '../styles/methods';
.discipline-modal-body {
    color: white;
}
.discipline-modal-title {
    font-size: 1.28571rem;
    padding: rem(20px) 0;
    color: $brand-primary;
    width: rem(550px);
    margin: 0;
}
.card-footer {
    background-color: inherit;
    padding: 0
}
</style>

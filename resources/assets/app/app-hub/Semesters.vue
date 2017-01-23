<template>
    <settings-box title="Semesters" subtitle="Add/remove institute subtitles">

        <template slot="actions">
            <div role="button" class="btn btn-primary" @click="showAddSemester"> {{ title }} </div>
        </template>


        <template slot="header-image">
            <img src="../assets/settings/semesters.svg">
        </template>

        <template slot="name">
            Semesters
        </template>

        <template slot="description">
            e.g. Odd/Even, Summer, Winter, etc
        </template>

        <template slot="settings-body">
            <modal name="Add new semesters" :show="onAdd" :dismissable="false">
                <div class="card">
                  <h4 class="card-header bg-white">Add New Semester</h4>

                  <div class="card-block">
                    <input-text title="Name of the semester" required v-model="semester.name" :feedback="errors.name" />

                    <div class="float-xs-right">
                      <a role="button" class="btn btn-secondary btn-cancel" tabindex @click="onCancel">Cancel</a>
                      <a role="button" class="btn btn-primary" tabindex @click="onSubmit">Save</a>
                    </div>
                  </div>
                </div>
            </modal>
            <div class="container py-2">
                <div class="row my-2">
                    <settings-card v-for="(semester, index) in semesters"
                                   class="col-xs-12 col-lg-6"
                                   :title="semester.name"
                                   :index="index"
                                   @cardClicked="semesterClicked" />
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
    if (this.semesters.length === 0) {
      this.getSemesters();
    }
  },
  data() {
    return {
      onAdd: false,
      loaded: false,
      semester: {
        name: '',
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
      return this.editReference.id ? 'Edit Semester' : 'Add New Semester';
    },
    ...mapGetters({
      semesters: getters.semesters,
    }),
  },
  components: { SettingsBox, Modal, SettingsCard },
  methods: {
    showAddSemester() {
      this.onAdd = true;
    },
    onCancel() {
      this.onAdd = false;
      this.resetReference();
    },
    onSubmit() {
      const call = this.editReference.id ? 'updateSemester' : 'addNewSemester';
      this[call]();
    },
    addNewSemester() {
      this.$http.post('semesters', this.semester)
      .then(() => {
        const semester = clone(this.semester);
        this.onAdd = false;
        this.addSemester(semester);
        this.resetReference();
      })
      .catch(() => {});
    },
    updateSemester() {
      this.$http.put(`semesters/${this.editReference.id}`, this.semester)
      .then(() => {
        this.onAdd = false;
        const semester = clone(this.semester);
        this.semesters[this.editReference.index] = semester;
        this.updateSemesterAction(semester);
        this.resetReference();
      });
    },
    semesterClicked(index) {
      const semester = this.semesters[index];
      this.editReference = {
        id: semester.id,
        index,
      };
      this.semester = clone(semester);
      this.onAdd = true;
    },
    resetReference() {
      Object.keys(this.semester).forEach((key) => {
        this.semester[key] = '';
      });
      this.editReference = {
        id: false,
        index: false,
      };
    },
    ...mapActions({
      getSemesters: actions.getSemesters,
      addSemester: actions.addSemester,
      updateSemesterAction: actions.updateSemester,
    }),

  },
};
</script>
<style lang="scss" scoped>
    @import '../styles/variables';
    @import '../styles/methods';
    .semester-modal-body {
        color: white;
    }
    .semester-modal-title {
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

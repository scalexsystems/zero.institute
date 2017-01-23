    <template>
<settings-box title="Departments" :subtitle="subtitle">

  <template slot="actions">
    <div role="button" class="btn btn-primary" @click="showAddDepartment"> Add new department </div>
  </template>

  <template slot="header-image">
    <img src="../assets/settings/departments.svg">
  </template>

  <template slot="name">
     Academic and Administrative Departments
  </template>

  <template slot="description">
     Academic Departments: e.g. Computer Science, Mechanical, Electronics etc. <br>
     Administrative Departments: e.g. Finance, Academic, Maintenance, HR, security etc.
  </template>

    <template slot="settings-body">
        <modal name="Add new department" :show="onAdd" @hide="onCancel">
            <div class="card">
                <h4 class="card-header bg-white">{{ title }} </h4>

                <div class="card-block">
                    <input-text title="Name of the department" required v-model="department.name" :feedback="errors.name"></input-text>
                    <input-text title="Department acronym" v-model="department.short_name" :feedback="errors.short_name"></input-text>
                    <input-search title="Head of Department" v-model="query" v-bind="{suggestions}" @suggest="onSuggest"
                                  @select="onSelect"></input-search>

                    <input-radio title="Department Type" required v-model="department.academic"  :options="departmentTypes"
                                 :feedback="errors.academic"></input-radio>

                    <div class="float-xs-right mt-1">
                        <a role="button" class="btn btn-secondary btn-cancel" tabindex @click="onCancel">Cancel</a>
                        <a role="button" class="btn btn-primary" tabindex @click="onSubmit">Save</a>
                    </div>
                </div>
            </div>
        </modal>

        <div class="container py-2">
            <div class="fl fl-middle">
                <hr class="fl-auto">
                <small class="px-1 text-uppercase">
                    Academic Departments
                </small>
                <hr class="fl-auto">
            </div>

            <div class="row my-2">
                <settings-card class="col-xs-12 col-lg-6" v-for="(department, index) in academic" :title="department.name"
                       :text="getText(department)" :additional="true" :index="index"
                       @cardClicked="departmentClicked" context="academic">
                  <template slot="additional-text">
                    {{ department.stats.student || 0 }} students,
                    {{ department.stats.teachers || 0 }} teachers,
                    {{ department.stats.employees || 0 }} staff
                  </template>
                </settings-card>
              </div>
            <div class="fl fl-middle">
                <hr class="fl-auto">
                <small class="px-1 text-uppercase">
                    Non-Academic / Administrative Departments
                </small>
                <hr class="fl-auto">
            </div>

            <div class="row my-2">
                <settings-card class="col-xs-12 col-lg-6" v-for="(department, index) in nonAcademic" :title="department.name"
                       :text="getText(department)" :additional="true" :index="index"
                       @cardClicked="departmentClicked" context="nonAcademic">
                  <template slot="additional-text">
                    {{ department.stats.student || 0 }} students,
                    {{ department.stats.teachers || 0 }} teachers,
                    {{ department.stats.employees || 0 }} staff
                  </template>
                </settings-card>
              </div>
    </div>
    </template>



</settings-box>

</template>
<script lang="babel">
import { mapActions, mapGetters } from 'vuex';
import { clone, throttle } from 'lodash';
import SettingsBox from './SettingsBox.vue';
import SettingsCard from './SettingsCard.vue';
import Modal from '../components/Modal.vue';
import { actions, getters } from '../vuex/meta';

export default{
  created() {
    if (Object.keys(this.departmentsByType).length === 0) {
      this.getDepartments();
    }
    if (this.suggestions.length === 0) {
      this.getTeachers();
    }
  },
  data() {
    return {
      onAdd: false,
      loaded: false,
      department: {
        name: '',
        short_name: '',
        head: '',
        academic: '',
      },
      editReference: {
        id: false,
        index: false,
      },
      query: '',
      errors: {},
    };
  },
  computed: {
    departmentTypes() {
      return {
        academic: 'Academic',
        nonAcademic: 'Non-Academic/Administrative',
      };
    },
    academic() {
      return this.departmentsByType.academic;
    },

    nonAcademic() {
      return this.departmentsByType.nonAcademic;
    },
    title() {
      return this.editReference.id ? 'Edit Department' : 'Add New Department';
    },
    subtitle() {
      return `Add/remove Departments. ${this.departmentCount} departments added`;
    },
    ...mapGetters({
      departmentsByType: getters.departmentsByType,
      suggestions: getters.teachers,
      departmentCount: getters.departmentCount,

    }),
  },
  components: { SettingsBox, Modal, SettingsCard },
  methods: {
    showAddDepartment() {
      this.onAdd = true;
    },
    onCancel() {
      this.onAdd = false;
      this.resetReference();
    },
    onSubmit() {
      const type = this.department.academic;
      this.department.academic = type === 'academic';
      const call = this.editReference.id ? 'updateDepartment' : 'addNewDepartment';
      this[call](type);
    },
    onSuggest: throttle(function onSuggest({ value, start, end }) {
      start();
      this.getTeachers({ q: value }).then(end);
    }, 400),
    search() {},
    onSelect(teacher) {
      this.department.head = teacher;
      this.department.head_id = teacher.id;
      this.query = teacher.name;
    },
    addNewDepartment() {
      this.$http.post('departments', this.department)
      .then(response => response.json())
      .then((department) => {
        this.onAdd = false;
        this.addDepartment(department);
        this.resetReference();
      })
       .catch(() => {});
    },
    updateDepartment(type) {
      this.$http.put(`departments/${this.editReference.id}`, this.department)
        .then(() => {
          this.onAdd = false;
          const department = clone(this.department);
          this.departmentsByType[type][this.editReference.index] = department;
          this.updateDepartmentAction(department);
          this.resetReference();
        });
    },
    getText(department) {
      const hod = department.head && Object.keys(department.head).length ? department.head.name : 'Not assigned';
      return `HOD: ${hod}`;
    },
    departmentClicked(index, context) {
      const department = this.departmentsByType[context][index];
      this.editReference = {
        id: department.id,
        index,
      };
      this.department = clone(department);
      this.department.academic = this.department.academic ? 'academic' : 'nonAcademic';
      this.query = department.head.name || '';
      this.onAdd = true;
    },
    resetReference() {
      Object.keys(this.department).forEach((key) => {
        this.department[key] = '';
      });
      this.query = '';
      this.editReference = {
        id: false,
        index: false,
      };
    },
    ...mapActions({
      getDepartments: actions.getDepartments,
      addDepartment: actions.addDepartment,
      updateDepartmentAction: actions.updateDepartment,
      getTeachers: actions.getTeachers,
    }),
  },
};
</script>
<style lang="scss" scoped>
  @import '../styles/variables';
  @import '../styles/methods';

  .c-indicator {
    color: inherit;
  }

  .department-modal-title {
   font-size: 1.28571rem;
   padding: rem(20px) 0;
   color: $brand-primary;
   width: rem(550px);
   margin: 0;
  }

  .department-modal-body {
    color: white;
  }

  .card-footer {
    background-color: inherit;
  }
</style>

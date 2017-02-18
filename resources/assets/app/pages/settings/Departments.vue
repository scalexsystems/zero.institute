<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <template slot="buttons">
  <input-button value="Add New" @click.native="create"/>
  </template>

  <modal :open="editing" @close="editing = false" :dismissable="false">
    <create-department v-if="current === null" @done="editing = false"/>
    <edit-department v-else v-bind="{ department: current }" @done="editing = false"/>
  </modal>

  <div class="container-zero py-3">
    <div class="row">

      <h2 class="col-12 text-center">{{ title }}</h2>

      <div class="col-12 col-lg-6 mt-3" v-for="department in departments">
        <department-card v-bind="{ department, footer: true }" role="button" @click.native="edit(department)"/>
      </div>

    </div>
  </div>

</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import Sidebar from './mixins/sidebar'
import DepartmentCard from '../../components/department/Card.vue'
import CreateDepartment from '../../components/department/Create.vue'
import EditDepartment from '../../components/department/Edit.vue'

export default {
  name: 'InstituteDepartments',

  data: () => ({
    current: null
  }),

  computed: {
    sidebarId: () => 'settings.departments',
    ...mapGetters('departments', ['departments'])
  },

  methods: {
    edit (department) {
      this.current = department

      this.onEdit()
    },

    create () {
      this.current = null

      this.onEdit()
    }
  },

  components: { CreateDepartment, DepartmentCard, EditDepartment },

  mixins: [Sidebar]
}
</script>


<style lang="scss">
</style>

<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <template slot="buttons">
  <input-button value="Add New" @click.native="create"/>
  </template>

  <modal :open="editing" @close="editing = false" :dismissable="false">
    <create-discipline v-if="current === null" @done="editing = false"/>
    <edit-discipline v-else v-bind="{ discipline: current }" @done="editing = false"/>
  </modal>

  <div class="container-zero my-3 py-3 text-center">
    <img src="../../assets/settings/disciplines.svg">
  </div>

  <div class="container-zero py-3">
    <div class="row">

      <h2 class="col-12 text-center">{{ title }}</h2>

      <div class="col-12 col-lg-6 mt-3" v-for="discipline in disciplines">
        <discipline-card v-bind="{ discipline, footer: true }" role="button" @click.native="edit(discipline)"/>
      </div>

    </div>
  </div>

</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import Sidebar from './mixins/sidebar'
import DisciplineCard from '../../components/discipline/Card.vue'
import CreateDiscipline from '../../components/discipline/Create.vue'
import EditDiscipline from '../../components/discipline/Edit.vue'

export default {
  name: 'InstituteDisciplines',

  data: () => ({
    current: null
  }),

  computed: {
    sidebarId: () => 'settings.disciplines',
    ...mapGetters('disciplines', ['disciplines'])
  },

  methods: {
    edit (discipline) {
      this.current = discipline

      this.onEdit()
    },

    create () {
      this.current = null

      this.onEdit()
    }
  },

  components: { CreateDiscipline, DisciplineCard, EditDiscipline },

  mixins: [Sidebar]
}
</script>


<style lang="scss">
</style>

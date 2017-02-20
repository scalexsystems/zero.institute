<template>
<container-window v-bind="{ title, subtitle }">
    <template slot="sidebar">
        <sidebar/>
    </template>

    <template slot="buttons">
        <input-button value="Add New" @click.native="create"/>
    </template>

    <modal :open="editing" @close="editing = false" :dismissable="false">
        <create-semester v-if="current === null" @done="editing = false"/>
        <edit-semester v-else v-bind="{ semester: current }" @done="editing = false"/>
    </modal>

    <div class="container-zero my-3 py-3 text-center">
        <img src="../../assets/settings/semesters.svg">
    </div>

    <div class="container-zero py-3">
        <div class="row">

            <h2 class="col-12 text-center">{{ title }}</h2>

            <div class="col-12 col-lg-6 mt-3" v-for="semester in semesters">
                <semester-card v-bind="{ semester }" role="button" @click.native="edit(semester)"/>
            </div>

        </div>
    </div>

</container-window>
</template>

<script lang="babel">
    import { mapGetters } from 'vuex'
    import Sidebar from './mixins/sidebar'
    import SemesterCard from '../../components/semester/Card.vue'
    import CreateSemester from '../../components/semester/Create.vue'
    import EditSemester from '../../components/semester/Edit.vue'

    export default {
      name: 'InstituteSemesters',

      data: () => ({
        current: null
      }),

      computed: {
        sidebarId: () => 'settings.semesters',
        ...mapGetters('semesters', ['semesters'])
      },

      methods: {
        edit (semester) {
          this.current = semester

          this.onEdit()
        },

        create () {
          this.current = null

          this.onEdit()
        }
      },

      components: { CreateSemester, SemesterCard, EditSemester },

      mixins: [Sidebar]
    }
</script>


<style lang="scss">
</style>

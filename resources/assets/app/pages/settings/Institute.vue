<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <template slot="buttons">
  <input-button value="Edit" @click.native="onEdit"/>
  </template>

  <modal :open="editing" @close="editing = false" :dismissable="false">
    <edit-institute @done="editing = false"/>
  </modal>

  <div class="container-zero py-3">
    <div class="row">

      <div class="col-12 text-center my-3">

        <photo-uploader class="p-school-photo round" dest="school/logo">
          <img :src="school.logo" class="p-school-photo rounded-circle fit-center">
        </photo-uploader>

      </div>

      <h2 class="col-12 text-center">{{ title }}</h2>

      <div class="col-12">
        <div class="card card-block">
          <div class="profile-field">
            <div class="label">Name of the institute</div>
            <div class="value">{{ school.name }}</div>
          </div>

          <div class="profile-field">
            <div class="label">University</div>
            <div class="value">{{ school.university }}</div>
          </div>

          <div class="profile-field">
            <div class="label">Institute Type</div>
            <div class="value">{{ instituteType }}</div>
          </div>
        </div>
      </div>

    </div>
  </div>

</container-window>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import Sidebar from './mixins/sidebar'
import EditInstitute from '../../components/settings/edit/Institute.vue'
import instituteTypes from '../../components/settings/institute-types'

export default {
  name: 'InstituteSettings',

  computed: {
    sidebarId: () => 'settings.school',
    instituteType () {
      const school = this.school

      return instituteTypes.find(type => school.institute_type === type.id).name
    },
    ...mapGetters(['school'])
  },

  components: { EditInstitute },

  mixins: [Sidebar]
}
</script>


<style lang="scss">
.p-school-photo {
  width: 154px;
  height: 154px;
}
</style>

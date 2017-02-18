<template>
<container-window v-bind="{ title, subtitle }">
  <template slot="sidebar">
  <sidebar/>
  </template>

  <div class="container-zero my-3 py-3 text-center">
    <photo-uploader dest="school/logo" class="round rounded-circle p-school-photo" @uploaded="setSchoolLogo">
      <img class="rounded-circle p-school-photo fit-center" :src="school.logo">
    </photo-uploader>
  </div>

  <div class="container-zero my-3">
    <school-information :source="school" :submit="updateSchool"/>
  </div>

  <div class="container-zero my-3">
    <contact-information :source="school" :submit="updateSchoolAddress"/>
  </div>

</container-window>
</template>

<script lang="babel">
import { mapGetters, mapActions } from 'vuex'
import Sidebar from './mixins/sidebar'
import instituteTypes from '../../components/settings/institute-types'
import ContactInformation from '../../components/profile/ContactInformation.vue'
import SchoolInformation from '../../components/profile/SchoolInformation.vue'

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

  methods: {
    ...mapActions(['updateSchoolAddress', 'updateSchool', 'setSchoolLogo'])
  },

  components: { SchoolInformation, ContactInformation },

  mixins: [Sidebar]
}
</script>


<style lang="scss">
.p-school-photo {
  width: 154px;
  height: 154px;
}
</style>

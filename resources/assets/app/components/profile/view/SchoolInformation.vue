<template>
<div class="card-block">
  <div class="row">
    <div class="col-6">
      <div class="profile-field">
        <div class="label">Name</div>
        <div class="value">{{ source.name }}</div>
      </div>
    </div>
    <div class="col-6">
      <div class="profile-field">
        <div class="label">Email</div>
        <div class="value">{{ source.email }}</div>
      </div>
    </div>
    <div class="col-6">
      <div class="profile-field">
        <div class="label">University</div>
        <div class="value">{{ source.university }}</div>
      </div>
    </div>
    <div class="col-6">
      <div class="profile-field">
        <div class="label">Institute Type</div>
        <div class="value">{{ source.institute_type | instituteType }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapGetters } from 'vuex'
import instituteTypes from '../../settings/institute-types'

export default {
  name: 'SchoolInformation',

  props: {
    source: {
      type: Object,
      required: true
    }
  },

  computed: {
    instituteTypes: () => instituteTypes,
    ...mapGetters(['school'])
  },

  filters: {
    instituteType (value) {
      return (instituteTypes.find(i => i.id === value) || {}).name
    }
  }
}
</script>

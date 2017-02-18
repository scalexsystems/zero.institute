<template>
<div class="card-block">
  <div class="row">
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Name</div>
        <div class="value">{{ source.name }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Gender</div>
        <div class="value text-capitalize">{{ source.gender }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Date of Birth</div>
        <div class="value">{{ source.date_of_birth | dateForHumans }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Category</div>
        <div class="value">{{ source.category | category }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Religion</div>
        <div class="value">{{ source.religion }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Native Language</div>
        <div class="value">{{ source.language }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { dateForHumans } from '../../../filters'

const categories = [
  { id: 'gen', name: 'General' },
  { id: 'sc', name: 'Scheduled Castes (SC)' },
  { id: 'st', name: 'Scheduled Tribes (ST)' },
  { id: 'obc', name: 'Other Backward Classes (OBC)' },
  { id: 'sbc', name: 'Special Backward Classes (SBC)' }
]

export default {
  name: 'PersonalInformation',

  props: {
    source: {
      type: Object,
      required: true
    }
  },

  computed: {
    categories: () => categories
  },

  filters: {
    dateForHumans,
    category (value) {
      const category = categories.find(c => c.id === value) || {}

      return category.name || value
    }
  }
}
</script>

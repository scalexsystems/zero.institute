<template>
<div class="card-block">
  <div class="row">
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Name</div>
        <div class="value">{{ guardian.name }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Profession</div>
        <div class="value">{{ guardian.profession }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Annual Income</div>
        <div class="value">{{ guardian.income | currency }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Phone</div>
        <div class="value text-capitalize">{{ guardian.phone }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
export default {
  name: 'GuardianInformation',

  props: {
    source: {
      type: Object,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  },

  computed: {
    guardian () {
      return this.source[this.type] || {}
    }
  },

  filters: {
    currency (value) {
      return value ? `₹${value} lakh / annum` : ''
    }
  }
}
</script>

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
        <div class="value">{{ source.category }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">AADHAR ID</div>
        <div class="value">{{ source.govt_id }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Passport</div>
        <div class="value">{{ source.passport }}</div>
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
        <div class="label">Mother Tongue</div>
        <div class="value">{{ source.language }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import moment from 'moment'
import { isObject } from '../../../util'

export default {
  name: 'ContactInformation',

  props: {
    source: {
      type: Object,
      required: true
    }
  },

  filters: {
    dateForHumans (value) {
      return value ? moment(value).format('D MMMM YYYY') : ''
    }
  }
}
</script>
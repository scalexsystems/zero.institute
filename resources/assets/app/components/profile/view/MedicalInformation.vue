<template>
<div class="card-block">
  <div class="row">
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Blood Group</div>
        <div class="value text-uppercase">{{ source.blood_group }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Physically Challenged</div>
        <div class="value">{{ source.is_disabled ? source.disability : 'No' }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Major Disease/Illness</div>
        <div class="value">{{ source.disease }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Allergy</div>
        <div class="value">{{ source.allergy }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Body Marks/Identification Marks</div>
        <div class="value">{{ source.body_marks }}</div>
      </div>
    </div>
    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Food Habit</div>
        <div class="value">{{ source.food_habit.join(', ') }}</div>
      </div>
    </div>
    <div class="col-12">
      <div class="profile-field">
        <div class="label">Additional Remarks</div>
        <div class="value">{{ source.medical_remarks }}</div>
      </div>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import moment from 'moment'
import { isObject } from '../../../util'

export default {
  name: 'MedicalInformation',

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
<template>
<div class="card-block">
  <div class="row">

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Address</div>
        <div class="value">{{ address.text }}</div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Landmark</div>
        <div class="value">{{ address.landmark }}</div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">City</div>
        <div class="value">{{ address.city }}</div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">PIN Code</div>
        <div class="value">{{ address.pin_code }}</div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Email</div>
        <div class="value">{{ address.email }}</div>
      </div>
    </div>

    <div class="col-6 col-md-4">
      <div class="profile-field">
        <div class="label">Phone</div>
        <div class="value">{{ address.phone }}</div>
      </div>
    </div>

  </div>
</div>
</template>

<script lang="babel">
import { isObject } from '../../../util'

export default {
  name: 'ContactInformation',

  props: {
    source: {
      type: Object,
      required: true
    }
  },

  computed: {
    address () {
      const raw = this.source.address
      const address = {}

      if (!isObject(raw) || !Object.keys(raw).length) {
        return address
      }

      if ('address_line1' in raw) {
        address.text = `${raw.address_line1} ${raw.address_line2}`.trim()
      } else {
        address.text = ''
      }

      if ('city' in raw && 'name' in raw.city) {
        address.city = raw.city.name
      } else {
        address.city = ''
      }

      address.landmark = raw.landmark || ''
      address.email = raw.email || ''
      address.phone = raw.phone || ''

      return { ...raw, ...address }
    }
  }
}
</script>
<template>
<div class="container-zero c-department-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Department</h5>

      <div class="ml-auto">
        <input-button class="btn btn-secondary" @click.native="$emit('done')" value="Cancel"/>
        <input-button @click.native="save" value="Create" :class="{ disabled }"/>
      </div>
    </div>

    <div class="card-block flex-auto">
      <alert v-autofocus v-if="formStatus" type="danger" v-html="formStatus"/>

      <form class="row" @submit.prevent="save">
        <input type="submit" hidden>

        <div class="col-12">
          <input-text title="Name" v-model="attributes.name" :errors="errors" required/>
        </div>

        <div class="col-12">
          <checkbox-wrapper title="Type" :errors="errors" required>
            <input-box v-model="attributes.academic" :radio="true" title="Academic" inline/>
            <input-box v-model="attributes.academic" :radio="false" title="Non-academic" inline/>
          </checkbox-wrapper>
        </div>

        <div class="col-12 col-lg-6">
          <input-text title="Short Code" v-model="attributes.short_name" :errors="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead title="Head of Department" v-model="attributes.head_id"
                           component="SelectOptionUser"
                           :suggestions="teachers" :errors="errors" />
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'
import throttle from 'lodash.throttle'

export default {
  name: 'EditDepartment',

  data: () => ({
    attributes: {
      name: '',
      short_name: '',
      academic: true,
      head_id: 0
    },

    teachers: [],

    disabled: false
  }),

  methods: {
    async save () {
      this.clearErrors()

      this.disabled = true
      const { errors, department } = await this.store(this.attributes)
      this.disabled = false

      if (department) {
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    onSearch: throttle(function onSearch(q) {
      this.fetch(q)
    }, 400),

    async fetch (q = '') {
      const { teachers } = await this.index({ q })

      this.teachers = teachers || []
    },

    ...mapActions('departments', ['store']),
    ...mapActions('teachers', ['index'])
  },

  created () {
    this.fetch()
  },

  mixins: [formHelper]
}
</script>


<style lang="scss"></style>

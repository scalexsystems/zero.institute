<template>
<div class="container-zero c-semester-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Semester</h5>

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
  name: 'EditSemester',

  data: () => ({
    attributes: {
      name: '',
    },

    teachers: [],

    disabled: false
  }),

  methods: {
    async save () {
      this.clearErrors()

      this.disabled = true
      const { errors, semester } = await this.store(this.attributes)
      this.disabled = false

      if (semester) {
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('semesters', ['store']),
  },

  mixins: [formHelper]
}
</script>


<style lang="scss"></style>

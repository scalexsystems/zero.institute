<template>
<div class="container-zero c-discipline-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Discipline</h5>

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
          <input-text title="Short Code" v-model="attributes.short_name" :errors="errors" required/>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script lang="babel">
import { mapActions } from 'vuex'
import { formHelper } from 'bootstrap-for-vue'

export default {
  name: 'EditDiscipline',

  data: () => ({
    attributes: {
      name: '',
      short_name: ''
    },

    teachers: [],

    disabled: false
  }),

  methods: {
    async save () {
      this.clearErrors()

      this.disabled = true
      const { errors, discipline } = await this.store(this.attributes)
      this.disabled = false

      if (discipline) {
        this.$emit('done')
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('disciplines', ['store'])
  },

  mixins: [formHelper]
}
</script>


<style lang="scss"></style>

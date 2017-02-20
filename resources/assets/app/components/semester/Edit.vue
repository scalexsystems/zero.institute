<template>
<div class="container-zero c-semester-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Edit Semester</h5>

      <div class="ml-auto">
        <input-button class="btn btn-secondary" @click.native="$emit('done')" value="Cancel"/>
        <input-button @click.native="edit" value="Save" :class="{ disabled }"/>
      </div>
    </div>

    <div class="card-block flex-auto">
      <alert v-autofocus v-if="formStatus" type="danger" v-html="formStatus"/>

      <form class="row" @submit.prevent="edit">
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
import Create from './Create.vue'
import { only } from '../../util'

export default {
  name: 'EditSemester',

  extends: Create,

  props: {

    semester: {
      type: Object,
      required: true
    }

  },

  methods: {

    async edit () {
      this.clearErrors()

      this.disabled = true
      const { errors, semester } = await this.update({ id: this.semester.id, payload: this.attributes })
      this.disabled = false

      if (semester) {
        this.$emit('done')
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('semesters', ['update'])
  },

  created () {
    this.attributes = only(this.semester, Object.keys(this.attributes))
  }
}
</script>

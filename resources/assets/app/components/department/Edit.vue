<template>
<div class="container-zero c-department-create mx-auto">
  <div class="card">
    <div class="card-header d-flex flex-row align-items-center">
      <h5 class="mb-0">Create Department</h5>

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

        <div class="col-12">
          <checkbox-wrapper title="Type" :errors="errors" required>
            <input-box v-model="attributes.academic" :radio="true" title="Academic" inline/>
            <input-box v-model="attributes.academic" :radio="false" title="Non-academic" inline/>
          </checkbox-wrapper>
        </div>

        <div class="col-12 col-lg-6">
          <input-text title="Short Code" v-model="attributes.short_name" :email="errors" required/>
        </div>

        <div class="col-12 col-lg-6">
          <input-typeahead title="Head of Department" v-model="attributes.head_id"
                           component="SelectOptionUser"
                           :suggestions="teachers" :errors="errors"/>
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
  name: 'EditDepartment',

  extends: Create,

  props: {

    department: {
      type: Object,
      required: true
    }

  },

  computed: {
    suggestions () {
      const selected = this.department.head_id ? [this.department.head] : []
      const teachers = this.teachers

      return selected.concat(teachers)
    },
  },

  methods: {

    async edit () {
      this.clearErrors()

      this.disabled = true
      const { errors, department } = await this.update({ id: this.department.id, payload: this.attributes })
      this.disabled = false

      if (department) {
        this.$emit('done')
      } else if (errors) {
        this.setErrors(errors)
        this.formStatus = errors.$message
      } else {
        this.formStatus = 'Ah! Oh! This is not expected. Contact support.'
      }
    },

    ...mapActions('departments', ['update'])
  },

  created () {
    this.attributes = only(this.department, Object.keys(this.attributes))
  }
}
</script>

<template>
<form-card v-if="$can('view-medical-information', source)"
           :editable="$can('update-medical-information', source)"
           :keep-editing="waiting"
           title="Medical Information"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-medical-information slot="view" v-bind="{ source }"/>
  <edit-medical-information slot="edit" v-bind="{ source, submit }" ref="edit" @updated="waiting = false"/>
</form-card>
</template>

<script lang="babel">
import EditMedicalInformation from './edit/MedicalInformation.vue'
import ViewMedicalInformation from './view/MedicalInformation.vue'

export default {
  name: 'MedicalInformation',

  props: {
    source: {
      type: Object,
      required: true
    },

    submit: {
      type: Function,
      required: true
    }
  },

  data: () => ({
    waiting: false
  }),

  methods: {
    onEdit () {
      if (this.$refs.edit) {
        this.$refs.edit.$emit('edit')
      }
    },

    onSave () {
      this.waiting = true
      if (this.$refs.edit) {
        this.$refs.edit.$emit('save')
      }
    },

    onCancel () {
      this.waiting = false
    }
  },

  components: { EditMedicalInformation, ViewMedicalInformation }
}
</script>
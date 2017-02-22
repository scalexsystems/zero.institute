<template>
<form-card v-if="$can('view-medical-information', source)"
           :editable="$can('update-medical-information', source)"
           :keep-editing="waiting"
           title="Medical Information" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-medical-information slot="view" v-bind="{ source }"/>
  <edit-medical-information slot="edit" v-bind="{ source, submit }" ref="edit"
                            @updated="onUpdated"
                            @submit="onSubmit"
                            @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditMedicalInformation from './edit/MedicalInformation.vue'
import ViewMedicalInformation from './view/MedicalInformation.vue'
import mixin from './mixin'

export default {
  name: 'MedicalInformation',

  components: { EditMedicalInformation, ViewMedicalInformation },

  mixins: [mixin]
}
</script>

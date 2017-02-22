<template>
<form-card v-if="$can('view-school-information', source)"
           :editable="$can('update-school-information', source)"
           :keep-editing="waiting"
           title="School Information" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-school-information slot="view" v-bind="{ source }"/>
  <edit-school-information slot="edit" v-bind="{ source, submit }" ref="edit"
                             @updated="onUpdated"
                             @submit="onSubmit"
                             @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditSchoolInformation from './edit/SchoolInformation.vue'
import ViewSchoolInformation from './view/SchoolInformation.vue'
import mixin from './mixin'

export default {
  name: 'SchoolInformation',

  components: { EditSchoolInformation, ViewSchoolInformation },

  mixins: [mixin]
}
</script>

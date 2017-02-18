<template>
<form-card v-if="$can('view-school-related-information', source)"
           :editable="$can('update-school-related-information', source)"
           :keep-editing="waiting"
           title="School Related Information" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-school-related-information slot="view" v-bind="{ source }"/>
  <edit-school-related-information slot="edit" v-bind="{ source, submit }" ref="edit"
                                   @updated="onUpdated"
                                   @submit="onSubmit"
                                   @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditSchoolRelatedInformation from './edit/SchoolRelatedInformation.vue'
import ViewSchoolRelatedInformation from './view/SchoolRelatedInformation.vue'
import mixin from './mixin'

export default {
  name: 'SchoolRelatedInformation',

  components: { EditSchoolRelatedInformation, ViewSchoolRelatedInformation },

  mixins: [mixin]
}
</script>
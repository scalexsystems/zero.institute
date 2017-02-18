<template>
<form-card v-if="$can('view-personal-information', source)"
           :editable="$can('update-personal-information', source)"
           :keep-editing="waiting"
           title="Personal Information" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-personal-information slot="view" v-bind="{ source }"/>
  <edit-personal-information slot="edit" v-bind="{ source, submit }" ref="edit"
                             @updated="onUpdated"
                             @submit="onSubmit"
                             @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditPersonalInformation from './edit/PeronalInformation.vue'
import ViewPersonalInformation from './view/PersonalInformation.vue'
import mixin from './mixin'

export default {
  name: 'PersonalInformation',

  components: { EditPersonalInformation, ViewPersonalInformation },

  mixins: [mixin]
}
</script>

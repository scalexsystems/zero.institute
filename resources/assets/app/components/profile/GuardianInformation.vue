<template>
<form-card v-if="$can('view-guardian-information', source)"
           :editable="$can('update-guardian-information', source)"
           :keep-editing="waiting"
           :title="title" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-guardian-information slot="view" v-bind="{ source, type }"/>
  <edit-guardian-information slot="edit" v-bind="{ source, type, submit }" ref="edit"
                             @updated="onUpdated"
                             @submit="onSubmit"
                             @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditGuardianInformation from './edit/GuardianInformation.vue'
import ViewGuardianInformation from './view/GuardianInformation.vue'
import mixin from './mixin'

export default {
  name: 'GuardianInformation',

  props: {
    title: {
      type: String,
      required: true
    },
    type: {
      type: String,
      required: true
    }
  },

  components: { EditGuardianInformation, ViewGuardianInformation },

  mixins: [mixin]
}
</script>

<template>
<form-card v-if="$can('view-contact-information', source)"
           :editable="$can('update-contact-information', source)"
           :keep-editing="waiting"
           title="Contact Information" ref="form"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-contact-information slot="view" v-bind="{ source }"/>
  <edit-contact-information slot="edit" v-bind="{ source, submit }" ref="edit"
                            @updated="onUpdated"
                            @submit="onSubmit"
                            @error="resetFormButtons"/>
</form-card>
</template>

<script lang="babel">
import EditContactInformation from './edit/ContactInformation.vue'
import ViewContactInformation from './view/ContactInformation.vue'
import mixin from './mixin'

export default {
  name: 'ContactInformation',

  components: { EditContactInformation, ViewContactInformation },

  mixins: [mixin]
}
</script>
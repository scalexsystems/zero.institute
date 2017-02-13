<template>
<form-card v-if="$can('view-school-related-information', source)"
           :editable="$can('update-school-related-information', source)"
           :keep-editing="waiting"
           title="School Related Information"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-school-related-information slot="view" v-bind="{ source }"/>
  <edit-school-related-information slot="edit" v-bind="{ source, submit }" ref="edit" @updated="waiting = false"/>
</form-card>
</template>

<script lang="babel">
import EditSchoolRelatedInformation from './edit/SchoolRelatedInformation.vue'
import ViewSchoolRelatedInformation from './view/SchoolRelatedInformation.vue'

export default {
  name: 'SchoolRelatedInformation',

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

  components: { EditSchoolRelatedInformation, ViewSchoolRelatedInformation }
}
</script>
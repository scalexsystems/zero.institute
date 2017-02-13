<template>
<form-card v-if="$can('view-contact-information', source)"
           :editable="$can('update-contact-information', source)"
           :keep-editing="waiting"
           title="Contact Information"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-contact-information slot="view" v-bind="{ source }"/>
  <edit-contact-information slot="edit" v-bind="{ source, submit }" ref="edit" @updated="waiting = false"/>
</form-card>
</template>

<script lang="babel">
import EditContactInformation from './edit/ContactInformation.vue'
import ViewContactInformation from './view/ContactInformation.vue'

export default {
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

  components: { EditContactInformation, ViewContactInformation }
}
</script>
<template>
<form-card v-if="$can('view-personal-information', source)"
           :editable="$can('update-personal-information', source)"
           :keep-editing="waiting"
           title="Personal Information"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-personal-information slot="view" v-bind="{ source }"/>
  <edit-personal-information slot="edit" v-bind="{ source, submit }" ref="edit" @updated="waiting = false"/>
</form-card>
</template>

<script lang="babel">
import EditPersonalInformation from './edit/ContactInformation.vue'
import ViewPersonalInformation from './view/PersonalInformation.vue'

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

  components: { EditPersonalInformation, ViewPersonalInformation }
}
</script>
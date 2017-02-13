<template>
<form-card v-if="$can('view-guardian-information', source)"
           :editable="$can('update-guardian-information', source)"
           :keep-editing="waiting"
           :title="title"
           @edit="onEdit" @save="onSave" @cancel="onCancel">
  <view-guardian-information slot="view" v-bind="{ source, type }"/>
  <edit-guardian-information slot="edit" v-bind="{ source, type, submit }" ref="edit" @updated="waiting = false"/>
</form-card>
</template>

<script lang="babel">
import EditGuardianInformation from './edit/GuardianInformation.vue'
import ViewGuardianInformation from './view/GuardianInformation.vue'

export default {
  name: 'GuardianInformation',

  props: {
    source: {
      type: Object,
      required: true
    },

    title: {
      type: String,
      required: true
    },

    type: {
      type: String,
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

  components: { EditGuardianInformation, ViewGuardianInformation }
}
</script>
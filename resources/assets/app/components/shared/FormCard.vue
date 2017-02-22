<template>
<div class="card c-shared-form-card">

  <div class="card-header bg-white d-flex flex-row align-items-center p-3">
    <h5 class="card-title mb-0 ml-2">{{ title }}</h5>

    <div class="ml-auto btn-group">
      <input-button v-if="editing || keepEditing" key="cancel" :value="cancelText" @click.native="onCancel" :disabled="keepEditing" class="btn btn-secondary" />
      <input-button v-if="editing || keepEditing" icon="save" key="save" :value="saveText" @click.native="onSave" :disabled="keepEditing" />
      <input-button v-else-if="editable" icon="pencil" key="edit" :value="editText" @click.native="onEdit" class="btn btn-secondary edit-button" />
    </div>
  </div>

  <slot v-if="editing || keepEditing" name="edit"></slot>
  <slot v-else name="view"></slot>

</div>
</template>

<script lang="babel">
export default {
  props: {
    editable: {
      type: Boolean,
      default: true
    },

    keepEditing: {
      type: Boolean,
      default: true
    },

    editText: {
      type: String,
      default: 'Edit'
    },

    cancelText: {
      type: String,
      default: 'Cancel'
    },

    saveText: {
      type: String,
      default: 'Save'
    },

    title: {
      type: String
    }
  },

  data: () => ({
    editing: false
  }),

  methods: {
    onEdit () {
      if (!this.editable) return

      this.editing = true
      this.$nextTick(() => this.$emit('edit'))
    },

    onSave () {
      if (!this.editing) return

      this.$emit('save')

      this.$nextTick(() => {
        this.editing = false
      })
    },

    onCancel () {
      if (!this.editing) return

      this.$emit('cancel')

      this.$nextTick(() => {
        this.editing = false
      })
    }
  },

  created () {
    this.$on('error', () => {
      this.editing = true
    })

    this.$on('submit', () => {
      this.onSave()
    })
  }
}
</script>

<style lang="scss">
@import '../../styles/variables';

.c-shared-form-card {
  .edit-button {
    color: $text-muted;
    border-color: transparent;

    &:hover {
      color: $btn-secondary-color;
      border-color: $btn-secondary-border;
    }
  }
}
</style>

<template>
<div class="c-hub-message-composer">
  <textarea class="c-hub-message-composer-input" name="message" :value="value" ref="input"
            placeholder="Start discussing..." @input="onInput"
            @keydown.enter="onEnter" :disabled="disabled" rows='1'
            autocomplete="off" autocorrect="off" @focus="$emit('focus')"></textarea>
  <div class="c-hub-message-composer-actions">
    <a role="button" class="action" v-tooltip:left="'Add files'"
       @click.prevent="$refs.uploader.$emit('upload')">
      <img src="../../assets/attach-file.svg" alt="+">
    </a>
    <file-uploader v-bind="{ dest }" ref="uploader" @uploaded="onUploaded"></file-uploader>
  </div>
</div>
</template>

<script lang="babel">
import resize from 'autosize'
import FileUploader from './FileUploader.vue'

export default {
  name: 'MessageComposer',

  data () {
    return {
      showPopup: false
    }
  },

  props: {
    disabled: {
      type: Boolean,
      default: false
    },
    value: {
      type: String,
      required: true
    },
    dest: {
      type: String
    }
  },

  methods: {
    resize () {
      const event = window.document.createEvent('Event')
      event.initEvent('autosize:destroy', false, true)
      this.$refs.input.dispatchEvent(event)
      this.$nextTick(() => {
        resize(this.$refs.input)
      })
    },
    focus () {
      setTimeout(() => this.$refs.input.focus(), 0)
    },
    onInput (event) {
      this.$emit('input', event.target.value)
    },
    onEnter (event) {
      if (event.shiftKey !== true && event.target.value.trim()) {
        event.preventDefault()
        this.$emit('send', this.value)
      }
    },
    onUploaded (attachments, errors) {
      const message = attachments.length ? attachments[0].message : ''

      this.$emit('send', { message, attachments: attachments.map(i => i.id), errors })
    }
  },

  mounted () {
    this.$nextTick(() => {
      resize(this.$refs.input)
    })
  },

  components: { FileUploader }
}
</script>


<style lang="scss">
@import '../../styles/variables';

.c-hub-message-composer {
  padding: 0 1.8714rem;
  border-top: 1px solid $border-color;
  position: relative;
}

.c-hub-message-composer-actions {
  position: absolute;
  right: 1.8714rem;
  top: 1rem;
}

.c-hub-message-composer-input {
  border: none;
  resize: none;
  width: 95%;
  min-height: 21px;
  max-height: 300px;
  line-height: 1.5;
  overflow-x: hidden;
  padding: 1.45rem 0;
  &:active, &:focus {
    outline: none;
  }
}
</style>

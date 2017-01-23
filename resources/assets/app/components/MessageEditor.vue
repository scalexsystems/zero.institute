<template>
<div class="message-input-wrapper">
  <textarea class="message-input" name="message" :value="value" ref="input"
            placeholder="Start discussing..." autofocus @input="onInput"
            @keydown.enter="onEnter" :disabled="disabled" rows='1'
            autocomplete="off" autocorrect="off" @focus="$emit('focused')"></textarea>
  <div class="message-editor-actions">
    <a role="button" class="action" v-tooltip:left="'Add files'"
       @click.prevent="$refs.uploader.$emit('upload')">
       <img src="../assets/attach-file.svg" alt="+">
    </a>

    <file-uploader v-bind="{ dest }" ref="uploader" @uploaded="onUploaded"></file-uploader>
  </div>
</div>
</template>

<script lang="babel">
import resize from 'autosize';
import FileUploader from './FileUploader.vue';

export default {
  data() {
    return {
      showPopup: false,
    };
  },
  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
    value: {
      type: String,
      required: true,
    },
    dest: {
      type: String,
    },
  },
  components: { FileUploader },
  methods: {
    resize() {
      const event = window.document.createEvent('Event');
      event.initEvent('autosize:destroy', false, true);
      this.$refs.input.dispatchEvent(event);
      this.$nextTick(() => {
        resize(this.$refs.input);
      });
    },
    focus() {
      setTimeout(() => this.$refs.input.focus(), 0);
    },
    onInput(event) {
      this.$emit('input', event.target.value);
    },
    onEnter(event) {
      if (event.shiftKey !== true && event.target.value.trim()) {
        event.preventDefault();
        this.$emit('send', this.value);
      }
    },
    onUploaded(attachments, errors) {
      if (!attachments.length) return;

      const message = attachments[0].message || '';

      this.$emit('send', message, attachments.map(i => i.id), errors);
    },
  },
  mounted() {
    this.$nextTick(() => {
      resize(this.$refs.input);
    });
  },
};
</script>


<style lang="scss" scoped>
@import '../styles/variables';

.message-input-wrapper {
  padding: 0 1.8714rem;
  border-top: 1px solid $border-color;
  position: relative;
}

.message-editor-actions {
  position: absolute;
  right: 1.8714rem;
  top: 1rem;
}

.message-input {
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

.message-actions {
 width: 5%;
}
</style>

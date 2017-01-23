<template>
    <div class="attachment-wrapper" v-if="attachments.length">
      <image-attachment v-bind="{ images }" v-if="images.length"></image-attachment>
      <template v-for="(attachment, index) of files">
          <file-attachment v-bind="{ attachment }" v-if="isFile(attachment)"></file-attachment>
          <failed-attachment v-bind="{ attachment, messageId: message.id }" v-if="isError(attachment)"></failed-attachment>
      </template>
    </div>
</template>
<script lang="babel">
import FileAttachment from './FileAttachment.vue';
import ImageAttachment from './ImageAttachment.vue';
import FailedAttachment from './FailedAttachment.vue';

export default{
  data() {
    return { };
  },
  props: {
    message: {
      required: true,
    },
  },
  computed: {
    files() {
      const attachments = this.attachments;

      return attachments.filter(a => !this.isImage(a));
    },
    images() {
      const attachments = this.attachments;

      return attachments.filter(a => this.isImage(a));
    },
    attachments() {
      const message = this.message;
      const errors = this.message.errors;
      const items = message.attachments.data;

      if (errors === undefined) {
        return items;
      }

      const prepared = [];

      for (let i = 0, index = 0; i < errors.length; i += 1) {
        if (errors[i]) {
          prepared[i] = errors[i];
        } else {
          prepared[i] = items[index];

          index += 1;
        }
      }

      return prepared;
    },
  },
  methods: {
    isImage(attachment) {
      if (!('mime' in attachment)) return false;

      return ['png', 'gif', 'jpg', 'jpeg', 'webp', 'tiff'].indexOf(attachment.extension) > -1;
    },
    isFile(attachment) {
      if (!('mime' in attachment)) return false;

      return ['png', 'gif', 'jpg', 'jpeg', 'webp', 'tiff'].indexOf(attachment.extension) < 0;
    },
    isError(attachment) {
      return !('mime' in attachment);
    },
  },

  components: { FileAttachment, ImageAttachment, FailedAttachment },
};
</script>
<style lang="scss" scoped>
@import '../../../styles/methods';
.attachment-wrapper {

}
</style>

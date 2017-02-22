<template>
  <div class="c-hub-message-attachment d-flex flex-row mt-3">
    <sender-photo :sender="message.sender"></sender-photo>

    <div class="text-message d-flex flex-column flex-auto">
      <message-header v-bind="{ message }"></message-header>
      <div v-if="content" class="content" v-html="content"></div>
      <div v-if="count > 0" class="card card-inverse" :class="[ $style.photoCard ]" role="button" @click="$emit('preview', photos)">
        <div class="embed-responsive embed-responsive-16by9 card-img">
          <img class="embed-responsive-item photo" :src="preview">
        </div>

        <div class="card-img-overlay d-flex justify-content-center align-items-center" v-if="count > 1" style="background: rgba(0, 0, 0, 0.1)">
          <h1 class="text-white">{{ count }} Photos</h1>
        </div>
      </div>

      <div v-if="files.length" class="attachments">
        <message-attachment v-for="file in files" :key="file"
          @preview="$emit('preview', file) ":attachment="file"></message-attachment>
      </div>
      <!-- TODO: Retry failed uploads. -->
    </div>
  </div>
</template>

<script lang="babel">
import MessageAttachment from './MessageAttachment.vue'
import MessageHeader from './MessageHeader.vue'
import SenderPhoto from './UserIcon.vue'
import mixin from './mixin'

export default {
  name: 'MessageWithAttachment',

  computed: {
    photos () {
      return this.message.attachments.filter(any => this.isImage(any))
    },

    failed () {
      return this.message.attachments.filter(any => this.isFailedAttachment(any))
    },

    files () {
      return this.message.attachments.filter(any => !this.isImage(any) && !this.isFailedAttachment(any))
    },

    preview () {
      const photo = this.photos[0]

      return photo.links.preview || photo.links.original
    },

    count () {
      return this.photos.length
    }
  },

  components: { MessageAttachment, MessageHeader, SenderPhoto },
  mixins: [mixin]
}
</script>

<style lang="scss" module>
.photo-card {
  min-width: 280px;
  max-width: 480px;

  img {
    object-fit: cover;
  }
}
</style>

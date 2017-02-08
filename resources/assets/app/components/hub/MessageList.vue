<template>
  <div class="c-hub-message-list">
    <modal :open="photos !== null" @close="cursor = -1" wrapper="d-flex flex-row">
      <photo-browser :photos="photos" class="flex-auto fullscreen" @end="next" @start="prev"></photo-browser>
    </modal>

    <div class="c-hub-message-list-container">
      <message v-for="(message, index) in messages" :key="message"
               v-bind="{ message, continued: message.$continued === true }"
               @preview="(payload) => preview(message, index, payload)"></message>

      <infinite-loader @infinite="any => $emit('infinite', any)" ref="il"></infinite-loader>
    </div>
  </div>
</template>

<script lang="babel">
import { isArray } from '../../util'
import Message from './message'
import PhotoBrowser from './PhotoBrowser.vue'

export default {
  name: 'MessageList',

  props: {
    messages: {
      type: Array,
      required: true
    }
  },

  data () {
    return { cursor: -1 }
  },

  computed: {
    photos () {
      const cursor = this.cursor

      if (cursor < 0) return null

      return this.messages[cursor].attachments.filter(
        any => ['png', 'gif', 'jpg', 'jpeg', 'webp', 'tiff', 'svg'].indexOf(any.extension) > -1
      ).map(
        (any) => {
          const links = any.links

          return {
            src: links.preview || links.original,
            alt: any.title
          }
        }
      )
    }
  },

  methods: {
    preview (message, index, payload) {
      console.log(payload)

      if (isArray(payload)) {
        this.previewPhotos(message, index)
      }

      this.previewAttachment(message, index, payload)
    },

    previewAttachment () {},

    previewPhotos (message, cursor) {
      this.cursor = cursor
    },

    next () {
      for (let i = this.cursor + 1; i < this.messages.length; i += 1) {
        if (this.messages[i].$hasPhotos) {
          this.cursor = i

          return
        }
      }
    },

    prev () {
      for (let i = this.cursor - 1; i >= 0; i -= 1) {
        if (this.messages[i].$hasPhotos) {
          this.cursor = i

          return
        }
      }
    }
  },

  created() {
    this.$on('reset', e => this.$refs && this.$refs.il.$emit('reset', e))
  },

  components: { Message, PhotoBrowser }
}
</script>

<template>
<div class="c-hub-message-list" ref="messages">
  <modal :open="photos !== null" @close="cursor = -1" wrapper="d-flex flex-row">
    <photo-browser :photos="photos" class="flex-auto fullscreen" @end="next" @start="prev"></photo-browser>
  </modal>

  <div class="c-hub-message-list-container container d-flex flex-column justify-content-end">
    <infinite-loader @infinite="any => $emit('infinite', any)" ref="il" direction="top"></infinite-loader>
    <message v-for="(message, index) in messages" :key="message"
             v-bind="{ message, continued: message.$continued === true }"
             @preview="(payload) => preview(message, index, payload)"></message>
  </div>
</div>
</template>

<script lang="babel">
import { isArray, last } from '../../util'
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
    return { cursor: -1, scrollNext: false }
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
      if (isArray(payload)) {
        this.previewPhotos(message, index)
      }

      this.previewAttachment(message, index, payload)
    },

    previewAttachment () {},

    previewPhotos (_, cursor) {
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
    },

    scrollTo (bottom = true) {
      if (!this.$refs || !this.$refs.messages) return

      if (bottom) {
        this.$refs.messages.scrollTop = this.$refs.messages.scrollHeight
      }
    }
  },

  created () {
    this.$on('reset', e => this.$refs && this.$refs.il.$emit('reset', e))
    this.$nextTick(() => this.scrollTo())
  },

  components: { Message, PhotoBrowser },

  watch: {
    messages (messages, old) {
      const scrollNext = this.scrollNext

      this.scrollNext = this.$refs.messages.scrollHeight < this.$refs.messages.clientHeight

      if (!messages || !messages.length) return

      // Source changed (If Keep Alive)
      if (old.length && last(messages).id === last(old).id && messages[0].id === old[0].id) {
        this.scrollNext = false
      }

      // Last update height was smaller than required
      if (scrollNext === true) {
        this.$nextTick(() => this.scrollTo())

        return
      }

      // Fetch old message.
      if (old.length && last(messages).id === last(old).id && messages[0].id !== old[0].id) {
        return
      }

      this.$nextTick(() => this.scrollTo())
    }
  }
}
</script>

<style lang="scss">
.c-hub-message-list {
  position: relative;
  overflow-x: hidden;
  overflow-y: auto;
}
</style>

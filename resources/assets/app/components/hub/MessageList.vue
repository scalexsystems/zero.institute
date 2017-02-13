<template>
<div class="c-hub-message-list" ref="list">
  <modal :open="photos !== null" @close="cursor = -1" wrapper="d-flex flex-row">
    <photo-browser :photos="photos" class="flex-auto fullscreen" @end="next" @start="prev"></photo-browser>
  </modal>

  <div class="c-hub-message-list-container container d-flex flex-column justify-content-end">
    <div class="col-12 text-center" v-if="!complete">
      <input-button class="btn btn-secondary btn-sm my-2 text-muted my-2" @click.native="onInfinite" v-if="!fetching" value="Load older messages"/>
      <icon type="circle-o-notch" class="fa-spin" v-else />
    </div>
    <message v-for="(message, index) in messages" :key="message" data-type="message"
             v-bind="{ message, continued: message.$continued === true }" ref="messages"
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
    return { cursor: -1, fetching: false, complete: false, position: 0, offset: 0 }
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

    previewAttachment () {
    },

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

    onInfinite () {
      this.fetching = true
      this.saveScrollPosition()
      this.$emit('infinite', {
        loaded: () => {
          this.fetching = false
          this.restoreScrollPosition()
        },
        complete: () => {
          this.fetching = false
          this.complete = true
          this.restoreScrollPosition()
        }
      })
    },

    saveScrollPosition () {
      this.position = this.messages.length ? this.messages[0].id : 0

      if (this.position !== 0) {
        this.offset = this.$refs.messages[0].$el.offsetTop
      }
    },

    restoreScrollPosition () {
      const position = this.position

      if (!this.$refs || !this.$refs.messages) return

      this.position = 0
      const message = this.$refs.messages.find(vm => position === vm.message.id)

      if (!message) return

      this.$refs.list.scrollTop = - (this.offset || 0) + message.$el.offsetTop
    }
  },

  created () {
    this.$on('reset', () => {
      this.fetching = false
      this.complete = false
    })
    this.onInfinite()
  },

  components: { Message, PhotoBrowser },

  watch: {
    messages (messages, old) {
      if (messages.length === 0) {
        this.onInfinite()
        return
      }

      if (!old.length || last(messages).id !== last(old).id) {
        this.$nextTick(() => {
          if (!this.$refs || !this.$refs.list) return

          this.$refs.list.scrollTop = this.$refs.list.scrollHeight
        })
      }
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

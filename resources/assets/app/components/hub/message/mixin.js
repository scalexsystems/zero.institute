import { escapeHtml as e, nl2br } from '../../../util'

export default {
  props: {
    message: {
      type: Object,
      required: true
    }
  },

  computed: {
    content () {
      const message = this.message

      return nl2br(e(
          (message.content || '').trim()
          .replace(/(\r?\n){2,}/g, '\n\n')
      ))
    }
  },

  methods: {
    isImage (any) {
      if (this.isFailedAttachment(any)) return false

      return ['png', 'gif', 'jpg', 'jpeg', 'webp', 'tiff', 'svg'].indexOf(any.extension) > -1
    },

    isFailedAttachment (any) {
      return ('$failed' in any)
    }
  }
}

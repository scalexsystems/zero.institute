import TextMessage from './Text.vue'
import AttachmentMessage from './Attachment.vue'
import ContinuedMessage from './Continued.vue'

function hasAttachment (message) {
  return message.attachments && message.attachments.length > 0
}

function choose ({ message, continued }) {
  if (hasAttachment(message)) {
    return AttachmentMessage
  }

  if (continued) {
    return ContinuedMessage
  }

  return TextMessage
}

export default {
  functional: true,

  props: {
    message: {
      type: Object,
      required: true
    },
    continued: {
      type: Boolean,
      default: false
    }
  },

  render (h, context) {
    context.data.props = context.data.props || {}
    context.data.props.message = context.props.message

    return h(choose(context.props), context.data, context.children)
  }
}

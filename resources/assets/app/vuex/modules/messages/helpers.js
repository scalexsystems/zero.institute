import moment from 'moment'
import { isImageExtension } from '../../../util'

export function prepareGroup (any) {
  any.$messages = []
  any.$messages_page = 1
  any.$members = []
  any.$members_page = 1
  any.$messages_loaded = false
  any.$unread_count = any.unread_count || 0
  any.$last_message_id = any.last_message_id || 0
  any.$has_unread = any.$unread_count > 0

  return any
}

export function prepareUser (any) {
  any.$messages = []
  any.$messages_page = 1
  any.$messages_loaded = false
  any.$unread_count = any.unread_count || 0
  any.$last_message_id = any.last_message_id || 0
  any.$has_unread = any.$unread_count > 0

  return any
}

export function dateChangesAt (a, b) {
  return !moment(a.received_at).isSame(moment(b.received_at), 'day')
}

export const TIMESTAMP = Date.now()

export function prepareMessages (messages) {
  const output = []

  for (let i = 0; i < messages.length; i += 1) {
    const prev = i > 0 ? output[i - 1] : null
    const current = messages[i]
    const $dateChanges = prev ? dateChangesAt(current, prev) : false
    const $hasPhotos = current.attachments && current.attachments
            .filter(a => isImageExtension(a.extension)).length > 0
    const $continued = prev !== null && // Not first message
        $dateChanges === false && // Not first message of the day
        (!current.attachments || current.attachments.length === 0) && // Has no attachments
        current.sender.id === prev.sender.id // From same sender

    output.push({
      $continued,
      $dateChanges,
      $hasPhotos,
      $receivedAt: $continued ? (prev.$receivedAt || prev.received_at) : null,
      ...current
    })
  }

  return output
}

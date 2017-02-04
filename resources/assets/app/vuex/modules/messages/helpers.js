import moment from 'moment'

export function prepare (any) {
  any.$messages = []
  any.$next_page = 1
  any.$messages_loaded = false
  any.$has_unread = false
  any.$unread_count = 0

  return any
}

export function dateChangesAt (a, b) {
  return !moment(a.received_at).isSame(moment(b.received_at), 'day')
}

export const TIMESTAMP = Date.now()

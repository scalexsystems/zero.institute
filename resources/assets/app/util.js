import moment from 'moment'

export const escapeHtml = (unsafeString) => {
  const div = document.createElement('div')

  div.appendChild(document.createTextNode(unsafeString))

  return div.innerHTML
}

export const nl2br = content => content.replace(/\n+/g, '<br>')

export const each = (any, cb) => {
  if (isArray(any)) {
    for (let i = 0; i < any.length; i += 1) {
      cb(any[i], i)
    }
  } else {
    const keys = Object.keys(any)

    for (let i = 0; i < keys.length; i += 1) {
      cb(any[keys[i]], keys[i])
    }
  }
}

export function isObject(any) {
  return any !== null && typeof (any) === 'object'
}

export function isBoolean(any) {
  return typeof (any) === 'boolean'
}

export function last(any) {
  return isArray(any) ? any[any.length - 1] : null
}

export function isArray(any) {
  return Array.isArray(any)
}

export function toArray(any) {
  return isArray(any) ? any : [any]
}

export function isString(any) {
  return typeof (any) === 'string'
}

export function isFunction(any) {
  return any instanceof Function
}

export function toInt(any) {
  return parseInt(any, 10)
}

export function clone(any) {
  return JSON.parse(JSON.stringify(any))
}

export function isImageExtension(any) {
  return ['png', 'gif', 'jpg', 'jpeg', 'webp', 'tiff', 'svg'].indexOf(any) > -1
}

export const only = (source, keys) => {
  const output = {}

  each(keys, key => {
    output[key] = source[key]
  })

  return output
}

export function notLastPage(meta) {
  return meta && meta.pagination && meta.pagination.current_page < meta.pagination.total_pages
}

export function nextPage(meta) {
  if (meta && meta.pagination) {
    return meta.pagination.current_page + 1
  }

  return 1
}

// -- Date Helpers --
export function dateIsoToInput(any) {
  const date = moment(any, moment.ISO_8601, true)

  return date.isValid() ? date.format('YYYY-MM-DD') : ''
}

// NOTICE: UNSAFE with unsafe strings; only use on previously-escaped ones!
// export const unescapeHtml = (escapedString) => {
//   const div = document.createElement('div')
//   div.innerHTML = escapedString
//   const child = div.childNodes[0]
//
//   return child ? child.nodeValue : ''
// }
//

//
// export const pushOrMerge = (target, items, local = []) => {
//   if (!isArray(items)) {
//     return pushOrMerge(target, [items], local)
//   }
//
//   items.forEach((item) => {
//     const index = target.findIndex(i => i.id === item.id)
//
//     if (index === -1) {
//       target.push(item)
//     } else {
//       target.splice(index, 1, { ...item, ...mapObject(target[index], local) })
//     }
//   })
//
//   return target
// }
//
// export const pushIf = (target, items, mappings = {}, local) => {
//   if (!isArray(items)) {
//     return pushIf(target, [items], mappings)
//   }
//
//   items.forEach((item) => {
//     if (item.id in mappings) {
//       if (local === undefined) return
//
//       const index = mappings[item.id]
//       target.splice(index, 1, { ...item, ...mapObject(target[index], local) })
//
//       return
//     }
//
//     /* eslint-disable */
//     mappings[item.id] = target.length;
//     /* eslint-enable */
//     target.push(item)
//   })
//
//   return target
// }
//
// export const isValidationException = (response) => {
//   if (response.status === 422) return true
//
//   return true
// }
//
// export const normalizeValidationErrors = (errors) => {
//   const transformed = {}
//   _.each(errors, (value, key) => {
//     transformed[key] = (_.isArray(value) ? value.join(' ') : value)
//   })
//   return transformed
// }
//
// export const httpThen = (response) => {
//   if ('ok' in response) {
//     if (response.ok === true) {
//       return response.json()
//     }
//
//     throw response
//   }
//
//   return response
// }
//
// export const isLastRecord = ({ _meta, pagination }) => {
//   /* eslint-disable no-param-reassign, next */
//   if (_meta) pagination = _meta.pagination
//
//   return pagination && pagination.current_page === pagination.total_pages
// }

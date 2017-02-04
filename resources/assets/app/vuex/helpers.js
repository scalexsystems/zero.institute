import { isObject, toArray } from '../util'
/**
 * @param {object} a
 * @param {object} b
 *
 * @return {boolean}
 */
export function ID_COMPARE (a, b) {
  return a && b && a.id === b.id
}

/**
 * @return {number}
 */
export function ID_SORT_COMPARE (a, b) {
  if (a.id < b.id) return -1
  if (a.id > b.id) return 1
  return 0
}

export function binarySearch (haystack, needle) {
  let start = 0, end = haystack.length - 1

  while (start < end) {
    const mid = start + parseInt((end - start) / 2, 10)
    const item = haystack[mid]

    if (item.id < needle.id) {
      start = mid + 1
    } else if (item.id > needle.id) {
      end = mid - 1
    } else {
      return mid
    }
  }

  return start
}

export function binarySearchIndex (haystack, needle) {
  needle = isObject(needle) ? needle : { id: needle }

  const index = binarySearch(haystack, needle)

  if (ID_COMPARE(haystack[index], needle)) {
    return index
  }

  return -1
}

export function binarySearchFind (haystack, needle) {
  needle = isObject(needle) ? needle : { id: needle }

  const index = binarySearchIndex(haystack, needle)

  return index > -1 ? haystack[index] : null
}

export function keepLocals (newValue, oldValue) {
  if (!isObject(oldValue) || !isObject(newValue)) return newValue

  const keys = Object.keys(oldValue).filter(key => /^\$/.test(key))

  for (let i = 0; i < keys.length; i += 1) {
    const key = keys[i]

    newValue[key] = oldValue[key]
  }

  return newValue
}

export function insert (target, items) {
  items = toArray(items).sort(ID_SORT_COMPARE)

  for (let i = 0; i < items.length; i += 1) {
    const item = items[i]
    const index = binarySearchIndex(target, item)

    if (index > -1) {
      target.splice(index, 1, keepLocals(item, target[index]))
    } else {
      target.push(item)
    }
  }

  return target
}

export function remove (target, item) {
  const index = binarySearchIndex(target, item)

  if (index > -1) target.splice(index, 1)

  return target
}

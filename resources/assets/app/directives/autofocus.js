/**
 * get the first scroll parent of an element
 * @param  {DOM} elm    the element which find scroll parent
 * @return {DOM}        the first scroll parent
 */
function getScrollParent (elm) {
  if (elm.tagName === 'BODY') {
    return window
  } else if (['scroll', 'auto'].indexOf(window.getComputedStyle(elm).overflowY) > -1) {
    return elm
  } else if (elm.classList.contains('ps-container')) {
    return elm
  }

  return getScrollParent(elm.parentNode)
}

export default {
  bind (el) {
    const scroll = getScrollParent(el)

    scroll.scrollTop = el.offsetTop
  }
}

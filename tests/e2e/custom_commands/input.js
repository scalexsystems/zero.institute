exports.command = function (name, value) {
  const isSelector = /(^\.|^#|[\[\]])/.test(name)
  const browser = this
  const selector = isSelector ? name : `[name="${name}"]`

  return browser.setValue(selector, value)
}

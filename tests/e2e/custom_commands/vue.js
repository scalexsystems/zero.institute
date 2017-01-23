exports.command = function () {
  const browser = this

  browser.waitForElementPresent('.app', 5000, 'Vue app ready!')

  return this
}

exports.command = function (url) {
  const browser = this

  browser.url(url).waitForElementPresent('body', 5000, `Visit ${url}`)

  return this
}

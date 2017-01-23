exports.command = function (target) {
  const browser = this
  const value = JSON.stringify(target)
  const isSelector = /^(\.|#|button|a)/.test(target)
  const xpath = `//a[text()[normalize-space() = ${value}]]`

  if (isSelector) {
    browser.click(target)
  } else {
    browser.useXpath().click(xpath).useCss()
  }

  return this
}

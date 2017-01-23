exports.command = function (name) {
  const browser = this.useXpath()
  const value = JSON.stringify(name)
  const xpath = `//button[text()[normalize-space() = ${value}] or @value = ${value}]`
  browser.click(xpath)

  return this.useCss()
}

exports.assertion = function (text) {
  const MESSAGE = `Testing if text ${JSON.stringify(text)} is present in page.`
  let FAILED = `Cannot find text ${JSON.stringify(text)} in `

  this.message = MESSAGE

  this.expected = function () {
    return true
  }

  this.pass = function (value) {
    if (!value) this.message = FAILED

    return value === true
  }

  this.failure = function (result) {
    const failed = result === false || (result && result.status === -1)

    return failed
  }

  this.value = function (result) {
    const value = result.value

    if (typeof (value) === 'string') {
      FAILED += JSON.stringify(value.replace(/[\r\n]+/g, ' <br> ').replace(/[\s]/g, ' '))

      return value.indexOf(text) > -1
    }

    return false
  }

  this.command = function (callback) {
    return this.api.getText('body', callback)
  }
}

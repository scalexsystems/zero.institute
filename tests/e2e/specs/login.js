export default {
  after: browser => browser.end(),

  'Login page renders correctly': (browser) => {
    const url = `${browser.globals.devServerURL}/login`

    browser.visit(url)
  }

}

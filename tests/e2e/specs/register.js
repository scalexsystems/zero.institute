export default {
  after: browser => browser.end(),

  'Register page renders correctly': (browser) => {
    const url = `${browser.globals.devServerURL}/register`

    browser.visit(url)
  }

}

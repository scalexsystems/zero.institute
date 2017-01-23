export default {
  after: browser => browser.end(),

  'Landing page renders correctly': (browser) => {
    const url = browser.globals.devServerURL

    browser.visit(url)
  }

}

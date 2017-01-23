require('babel-register')

const config = require('../../scripts/config')

const log = config.logger
const url = `http://${config.laravel.address}`

log(`Test Host: ${url}`)

module.exports = {
  src_folders: ['tests/e2e/specs'],
  output_folder: 'tests/reports/e2e/nightwatch',
  custom_commands_path: ['tests/e2e/custom_commands'],
  custom_assertions_path: ['tests/e2e/custom_assertions'],

  selenium: {
    start_process: true,
    server_path: require('selenium-server').path,
    port: 4444,
    cli_args: {
      'webdriver.chrome.driver': require('chromedriver').path,
      'phantomjs.binary.path': require('phantomjs-prebuilt').path
    }
  },

  test_settings: {

    default: {
      selenium_port: 4444,
      selenium_host: 'localhost',
      silent: true,
      request_timeout_options: {
        timeout: 2000,
        retry_attempts: 5
      },
      globals: {
        devServerURL: url,
        timeout: (process.env.CI ? 5000 : 500)
      },

      screenshots: {
        enabled: true,
        on_failure: true,
        on_error: false,
        path: 'tests/reports/e2e/screenshots'
      }
    },

    chrome: {
      desiredCapabilities: {
        browserName: 'chrome',
        javascriptEnabled: true,
        acceptSslCerts: true
      }
    },

    firefox: {
      desiredCapabilities: {
        browserName: 'firefox',
        javascriptEnabled: true,
        acceptSslCerts: true
      }
    },

    phantomjs: {
      desiredCapabilities: {
        browserName: 'phantomjs',
        javascriptEnabled: true,
        acceptSslCerts: true
      }
    }
  }

}

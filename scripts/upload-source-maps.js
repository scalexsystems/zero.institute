const SENTRY_API = 'https://sentry.io/api/0/projects/scalex-systems/zero'
const request = require('request')
const package = require('../package.json')
const fs = require('fs')
const path = require('path')
const rm = require('rimraf')
const exec = require('child_process').execSync
const glob = require('glob')

require('dotenv').config()

const version = package.version
const buildDir = path.resolve(__dirname, '../public/app')
// 1. Create release.
function createRelease(resolve, reject) {
  request({
    method: 'POST',
    url: `${SENTRY_API}/releases/`,
    auth: { bearer: process.env.SENTRY_TOKEN },
    json: { version }
  }, (error, response, body) => {
    if (error) {
      console.log(error)
      reject(error)

      return
    }

    console.log(`Sentry created ${body.version} for ${version}.`)
    package.version = version

    fs.writeFileSync(path.resolve(__dirname, '../package.json'), JSON.stringify(package, null, 2))
    resolve()
  })
}


// 2. Upload source maps.
function upload() {
  const files = glob.sync(`${buildDir}/**/*.map`)

  let uploaded = 0

  files.forEach((file) => {
    request({
      method: 'POST',
      uri: `${SENTRY_API}/releases/${version}/files/`,
      auth: { bearer: process.env.SENTRY_TOKEN },
      formData: {
        file: fs.createReadStream(file),
        name: file.replace(buildDir, 'https://zero.institute/app')
      }
    }, (error, response, body) => {
      uploaded += 1

      console.log(`\n- ${uploaded} of ${files.length}`)
      console.log('  POST: ', file.replace(buildDir, ''))
      console.log('  Status: ', response && response.statusMessage)
      if (error) console.log(error)
      else console.log(' ', body)
    })
  })
}

(new Promise(createRelease)).then(() => upload())
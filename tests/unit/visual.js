import 'style-loader!css-loader!sass-loader!./helpers/app.scss'
import 'style-loader!css-loader!bootstrap-for-vue/dist/bootstrap-for-vue.css'
import 'style-loader!css-loader!mocha-css'

import Vue from 'vue'
import BootstrapForVue from 'bootstrap-for-vue'
Vue.use(BootstrapForVue, { all: true, custom: true })

const mochaDOM = document.createElement('div')
mochaDOM.id = 'mocha'
document.body.appendChild(mochaDOM)

import 'mocha/mocha.js'
import chai from 'chai'
import chaiDOM from 'chai-dom'

window.$ = window.jQuery = require('jquery')
window.Tether = require('jquery')
require('bootstrap')
window.mocha.setup('bdd')
chai.use(chaiDOM)
chai.should()
window.expect = chai.expect

beforeEach(function () {
  this.DOM = document.createElement('div')
  this.DOM.id = `test-${Math.floor(Math.random() * 1000000000)}`

  document.body.appendChild(this.DOM)
})

afterEach(function () {
  const tests = document.querySelectorAll('.test')
  const test = tests[tests.length -1]

  if (!test) return

  const el = document.querySelector(`#${this.DOM.id}`)

  test.appendChild(el)
})

const specsContext = require.context('./specs', true)
specsContext.keys().forEach(specsContext)

// window.mocha.checkLeaks()
window.mocha.run()

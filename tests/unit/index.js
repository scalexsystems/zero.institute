// Polyfill fn.bind() for PhantomJS
/* eslint-disable no-extend-native, import/no-extraneous-dependencies */
Function.prototype.bind = require('function-bind')

// require all test files (files that ends with .spec.js)
const testsContext = require.context('./specs', true, /\.spec$/)
testsContext.keys().forEach(testsContext)

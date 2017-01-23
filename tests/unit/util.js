import Vue from 'vue'
import { ErrorBag } from '../../resources/assets/app/mixins/formHelper'

export function makeErrors (items = {}) {
  return new ErrorBag(items)
}

export function mount (Component) {
  const Constructor = Vue.extend(Component)

  Constructor.prototype.$ = function (selector) {
    return this.$el.querySelector(selector)
  }

  Constructor.prototype.tick = function () {
    return new Promise(resolve => this.$nextTick(resolve))
  }

  const vm = new Constructor()

  vm.$mount()

  return vm
}

export function render (Component, data) {
  return mount({
    functional: true,

    render (h) {
      return h(Component, data)
    }
  })
}

export function directive (name, expression, value) {
  return { name, expression, value }
}

export function wait (milis) {
  return new Promise(resolve => setTimeout(resolve, milis))
}

import Vue from 'vue'
import store from 'app/vuex'

export function createVM (context, component) {
  if (!context.DOM) {
    const app = new Vue(component)
    context.$ = app.$ = s => app.$el.querySelector(s)
    context.tick = app.tick = () => new Promise(r => app.$nextTick(r))

    app.$mount()

    return app
  } else {
    const app = new Vue({
      el: context.DOM,
      store,
      data () {
        return { show: false }
      },
      template: `
        <div id="${context.DOM.id}" class="test-component-container">
            <button @click="show = !show" role="button">{{ show ? '-' : '+' }}</button>
            <div class="test-output" v-show="show"><test-case></test-case></div>
        </div>`,
      components: {
        TestCase: component
      }
    })

    const vm = app.$children[0]

    context.$app = app
    context.$vm = vm
    context.$ = vm.$ = s => vm.$el.querySelector(s)
    context.tick = vm.tick = () => new Promise(r => app.$nextTick(r))

    return vm
  }
}

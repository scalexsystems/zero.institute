import * as shared from './shared'

export default function (Vue) {
  Object.keys(shared).forEach(name => Vue.component(name, shared[name]))
}

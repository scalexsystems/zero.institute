import more from './More.vue'
import simple from './Simple.vue'
import lengthAware from './LengthAware.vue'

const themes = {
  more,
  simple,
  lengthAware
}

export default {
  functional: true,

  props: {
    theme: {
      type: String,
      default: 'more',
      validator (theme) {
        return Object.keys(themes).includes(theme)
      },
    }
  },

  render (h, ctx) {
    const component = themes[ctx.props.theme]

    return h(component, ctx.data)
  }
}

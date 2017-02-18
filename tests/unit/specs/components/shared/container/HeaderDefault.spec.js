import { createVM } from 'util'
import HeaderDefault from 'app/components/shared/container/HeaderDefault.vue'

function render (template, data, context) {
  return createVM(context, {
    template,
    data () {
      return data
    },
    components: { HeaderDefault }
  })
}


describe('components/shared/container/HeaderDefault.vue', function () {
  it('should render correctly', function () {
    const vm = render(
      `<header-default v-bind="{ title: title, subtitle: subtitle }"></header-default>`,
      { title: 'Foo Title', subtitle: 'Foo Subtitle' },
      this
    )


    // --
  })

  it('should render with back button', function () {
    const vm = render(
      `<header-default v-bind="{ title: title, subtitle: subtitle, back: true }"></header-default>`,
      { title: 'Foo Title', subtitle: 'Foo Subtitle' },
      this
    )


    // --
  })

  it('should render with photo', function () {
    const vm = render(
      `<header-default v-bind="{ title: title, subtitle: subtitle, photo: 'http://unsplash.it/200/300' }"></header-default>`,
      { title: 'Foo Title', subtitle: 'Foo Subtitle' },
      this
    )


    // --
  })
})

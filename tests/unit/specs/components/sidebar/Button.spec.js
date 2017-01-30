import { createVM } from 'util'
import SidebarButton from 'app/components/sidebar/Button.vue'

function render (template, context, data = {}) {
  SidebarButton.components = {
    RouterLink: { template: '<div><slot/></div>'}
  }

  return createVM(context, {
    template,
    data () {
      return data
    },
    components: { SidebarButton }
  })
}

describe('components/sidebar/Button.vue', function () {

  it ('should render correctly', function () {
    const vm = render(
      `<sidebar-button route="/foo" photo="http://unsplash.it/200/300" :has-extra="true">
        Foo Bar <span slot="extra" class="badge badge-default">1</span>
       </sidebar-button>`, this
    )

    // --
  })
})

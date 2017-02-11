import { createVM } from 'util'
import InfiniteLoader from 'app/components/shared/InfiniteLoader.vue'

function render (template, context) {
  return createVM(context, {
    template,
    data: () => ({
      title: 'Foo Bar',
      subtitle: 'The subtitle',
      back: true
    }),
    methods: {
      onInfinite (any) {
        console.log(any)
      }
    },
    components: { InfiniteLoader }
  })
}


describe('components/shared/InfiniteLoader.vue', function () {
  it('should render correctly', function () {
    const vm = render(
        `<div>
            <infinite-loader @infinite="onInfinite"></infinite-loader>
         </div>`, this
    )

    // --
  })
})

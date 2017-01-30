import { createVM } from 'util'
import PhotoBrowser from 'app/components/hub/PhotoBrowser.vue'

/**
 * UserIcon factory function
 * @param  template
 * @param  message
 * @param  context  Test Context
 * @return VM
 */
function render (template, context) {
  return createVM(context, {
    template,
    components: { PhotoBrowser },
    data () {
      return { photos: [
        { src: 'http://unsplash.it/300?random=1' },
        { src: 'http://unsplash.it/800/600?random=2' },
        { src: 'http://unsplash.it/1200/600?random=3' },
        { src: 'http://unsplash.it/400/1200?random=4' }
      ] }
    }
  })
}

describe('components/hub/PhotoBrowser.vue', function () {
  it ('should render correctly', function () {
    const vm = render(`
      <photo-browser :photos="photos"></photo-browser>
      `, this)

    // TODO: Add tests!
  })
})

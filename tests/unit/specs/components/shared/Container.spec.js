import { createVM } from 'util'
import Container from 'app/components/shared/Container.vue'

function render (template, context, data = {}) {
  return createVM(context, {
    template,
    data () {
      return {
        title: 'Foo Bar',
        subtitle: 'The subtitle',
        back: true,
      }
    },
    components: { Container }
  })
}


describe('components/shared/Container.vue', function () {

  it ('should render correctly', function () {
    const vm = render(
      `<container v-bind="{ title: title, subtitle: subtitle, back: back }">
        This is in container body!
       </container>`, this
    )

    // --
  })

  it ('should render with footer & buttons in header', function () {
    const vm = render(
      `<container v-bind="{ title: title, subtitle: subtitle, back: back, hasFooter: true }">
       <template slot="buttons">
        <input-button>One</input-button>
       </template>

        This is in container body!

        <div class="p-3" slot="footer">This is in footer</div>
       </container>`, this
    )

    // --
  })

  it ('should render with scrollable content', function () {
    const vm = render(
      `<container v-bind="{ title: title, subtitle: subtitle, back: back, hasFooter: true }">
        <p>This is in container body!</p>

        <p>The object-fit property defines how an element responds to the height and width of its content box. It's intended for images, videos and other embeddable media formats in conjunction with the object-position property. Used by itself, object-fit lets us crop an inline image by giving us fine-grained control over how it squishes and stretches inside its box.</p>

        <p>object-fit can be set with one of these five values:</p>

        <p>fill: this is the default value which stretches the image to fit the content box, regardless of its aspect-ratio.</p>
        <p>contain: increases or decreases the size of the image to fill the box whilst preserving its aspect-ratio.</p>
        <p>cover: the image will fill the height and width of its box, once again maintaining its aspect ratio but often cropping the image in the process.</p>
        <p>none: image will ignore the height and width of the parent and retain its original size.</p>
        <p>scale-down: the image will compare the difference between none and contain in order to find the smallest concrete object size.</p>

        <p>This is how we might set that property:</p>

        <pre>img {
          height: 120px;
        }

        .cover {
          width: 260px;
          object-fit: cover;
        }
        </pre>
        <p>object-fit example</p>
        <p>Because the second image has an aspect ratio that is different than the original image on the left it will stretch outside the realm of its content box, cropping the top and bottom parts of the image.</p>

        <p>It’s worth noting that by default the image is centered within its content box but this can be altered with the object-position property.</p>

        <div class="p-3" slot="footer">This is in footer</div>
       </container>`, this
    )

    // --
  })
})

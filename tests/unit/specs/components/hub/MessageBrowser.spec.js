import { createVM } from 'util'
import MessageBrowser from 'app/components/hub/MessageBrowser.vue'

const IMAGE = 'data:image/png;base64,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'
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
    components: { MessageBrowser },
    data () {
      return { messages: [
        {
          content: 'This is just a foo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          }
        },
        {
          content: 'This is another foo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          }
        },
        {
          content: 'This is another foo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          },
          $continued: true
        },
        {
          content: 'This is just a photo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          },
          attachments: [
            { extension: 'pdf', title: 'A sample PDF', size: 1242 },
            { extension: 'png', links: { preview: 'http://unsplash.it/360/240?random=1' }},
            { extension: 'doc', title: 'A sample DOC', size: 10242 },
            { extension: 'png', links: { preview: 'http://unsplash.it/360/240?random=2' }},
            { extension: 'ppt', title: 'A sample PPT', size: 12242 },
            { extension: 'png', links: { preview: 'http://unsplash.it/360/240?random=3' }},
            { extension: 'txt', title: 'A sample TXT', size: 242 },
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=5' }},
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=6' }},
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=7' }},
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=8' }},
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=9' }},
            { extension: 'png', links: { preview: 'http://unsplash.it/600?random=10' }}
          ],
          $hasPhotos: true
        },
        {
          content: 'This is just a photo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          },
          attachments: [
            { extension: 'pdf', title: 'A sample PDF', size: 1242 },
            { extension: 'doc', title: 'A sample DOC', size: 10242 },
            { extension: 'ppt', title: 'A sample PPT', size: 12242 },
            { extension: 'txt', title: 'A sample TXT', size: 242 }
          ]
        },
        {
          content: 'This is just a photo message.',
          received_at: '2017-01-27T17:26:45.810Z',
          sender: {
            name: 'Rahul Kadyan',
            photo: IMAGE
          },
          attachments: [
            { extension: 'png', links: { preview: 'http://unsplash.it/1600/900?random=4' }}
          ],
          $hasPhotos: true
        }
      ]
      }
    }
  })
}

describe('components/hub/MessageBrowser.vue', function () {
  it('should render text message', function () {
    const vm = render(`<message-browser v-bind="{ messages: messages }"></message-browser>`, this)
  })
})

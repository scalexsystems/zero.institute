import { createVM } from 'util'
import ContinuedMessage from 'app/components/hub/message/Continued.vue'

const IMAGE = 'data:image/png;base64,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'
/**
 * UserIcon factory function
 * @param  template
 * @param  context  Test Context
 * @return VM
 */
function render (template, message, context) {
  return createVM(context, {
    template,
    components: { ContinuedMessage },
    data () {
      return {
        message: message
      }
    }
  })
}

describe('components/hub/message/Continued.vue', function () {
  it('should render correctly', function () {
    const vm = render(`<continued-message v-bind="{ message: message }"></continued-message>`, {
      content: 'This is just a foo message.',
      received_at: '2017-01-27T17:26:45.810Z',
      sender: {
        name: 'Rahul Kadyan',
        photo: IMAGE,
      }
    }, this)

    vm.$('.sender-placeholder').should.exist
    vm.$('.content').should.have.text('This is just a foo message.')
  })

  it('should render sending status', function () {
    const vm = render(`<continued-message v-bind="{ message: message }"></continued-message>`, {
      content: 'This is just a foo message.',
      received_at: '2017-01-27T17:26:45.810Z',
      sender: {
        name: 'Rahul Kadyan',
        photo: IMAGE,
      },
      $status: {
        sending: true
      }
    }, this)

    vm.$('.sender-placeholder').should.exist
    vm.$('.content').should.have.text('This is just a foo message.')
    // ADD Tests!
  })

  it('should render failed status', function () {
    const vm = render(`<continued-message v-bind="{ message: message }"></continued-message>`, {
      content: 'This is just a foo message. An outgoing message, not yet sent.',
      received_at: '2017-01-27T17:26:45.810Z',
      sender: {
        name: 'Rahul Kadyan',
        photo: IMAGE,
      },
      $status: {
        failed: true,
        message: 'Network not available.'
      }
    }, this)

    vm.$('.sender-placeholder').should.exist
    // ADD Tests!
  })
})
